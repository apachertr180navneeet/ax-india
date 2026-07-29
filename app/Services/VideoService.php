<?php

namespace App\Services;

use App\Models\Video;
use App\Models\VideoFile;
use App\Models\Download;
use App\Repositories\VideoRepository;
use App\Traits\FileUploadTrait;
use App\Traits\Sluggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class VideoService
{
    use FileUploadTrait, Sluggable;

    public function __construct(private Video $video, private VideoFile $videoFile, private VideoRepository $videoRepository) {}

    public function uploadVideo($user, array $data, UploadedFile $file, ?UploadedFile $thumbnail = null): Video
    {
        try {
            return DB::transaction(function () use ($user, $data, $file, $thumbnail) {
                $filePath = $this->uploadFile($file, 'videos');
                $thumbnailPath = $thumbnail ? $this->uploadFile($thumbnail, 'thumbnails') : null;

                $video = $this->video->create([
                    'user_id' => $user->id,
                    'title' => $data['title'],
                    'slug' => $this->generateSlug($this->video, $data['title']),
                    'description' => $data['description'] ?? null,
                    'thumbnail' => $thumbnailPath,
                    'duration' => $data['duration'] ?? 0,
                    'file_path' => $filePath,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'category_id' => $data['category_id'] ?? null,
                    'visibility' => $data['visibility'] ?? 'public',
                    'is_published' => $data['is_published'] ?? false,
                    'scheduled_at' => $data['scheduled_at'] ?? null,
                    'allow_downloads' => $data['allow_downloads'] ?? true,
                    'status' => $data['status'] ?? 'pending',
                ]);

                $this->videoFile->create([
                    'video_id' => $video->id,
                    'file_path' => $filePath,
                    'file_type' => 'original',
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'resolution' => $data['resolution'] ?? null,
                    'duration' => $data['duration'] ?? 0,
                    'is_processed' => false,
                    'processing_status' => 'pending',
                ]);

                if (!empty($data['tags'])) {
                    $tagNames = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                    app(TagService::class)->syncVideoTags($video, $tagNames);
                }

                Log::info('Video uploaded', ['video_id' => $video->id, 'user_id' => $user->id]);

                return $video->load(['user', 'category', 'tags', 'files']);
            });
        } catch (\Exception $e) {
            Log::error('Video upload failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function updateVideo(int $id, $user, array $data, ?UploadedFile $thumbnail = null): Video
    {
        try {
            return DB::transaction(function () use ($id, $user, $data, $thumbnail) {
                $video = $this->video->findOrFail($id);
                if ($video->user_id !== $user->id) {
                    abort(403, 'Forbidden');
                }

                $updateData = collect($data)->except(['tags', 'thumbnail'])->toArray();

                if ($thumbnail) {
                    if ($video->thumbnail) {
                        $this->deleteFile($video->thumbnail);
                    }
                    $updateData['thumbnail'] = $this->uploadFile($thumbnail, 'thumbnails');
                }

                $video->update($updateData);

                if (!empty($data['tags'])) {
                    $tagNames = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                    app(TagService::class)->syncVideoTags($video, $tagNames);
                }

                Log::info('Video updated', ['video_id' => $video->id, 'user_id' => $user->id]);

                return $video->fresh()->load(['user', 'category', 'tags', 'files']);
            });
        } catch (\Exception $e) {
            Log::error('Video update failed', ['video_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deleteVideo(int $id, $user): bool
    {
        try {
            return DB::transaction(function () use ($id, $user) {
                $video = $this->video->where('user_id', $user->id)->findOrFail($id);

                if ($video->file_path) {
                    $this->deleteFile($video->file_path);
                }
                if ($video->thumbnail) {
                    $this->deleteFile($video->thumbnail);
                }

                foreach ($video->files as $file) {
                    $this->deleteFile($file->file_path);
                }

                $result = $video->delete();

                Log::info('Video deleted', ['video_id' => $id, 'user_id' => $user->id]);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('Video delete failed', ['video_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getVideo(int $id): ?Video
    {
        $video = $this->videoRepository->findById($id);

        if ($video) {
            $this->videoRepository->incrementViews($id);
        }

        return $video;
    }

    public function getPublishedVideos(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return $this->videoRepository->findPublished($filters, $perPage);
    }

    public function getUserVideos(int $userId, int $perPage = 12): LengthAwarePaginator
    {
        return $this->videoRepository->findByUser($userId, $perPage);
    }

    public function getTrendingVideos(int $limit = 10)
    {
        return $this->videoRepository->getTrending($limit);
    }

    public function getRelatedVideos(Video $video, int $limit = 8)
    {
        return $this->videoRepository->getRelated($video, $limit);
    }

    public function toggleLike($user, int $videoId, string $type): void
    {
        try {
            $this->videoRepository->toggleLike($user->id, $videoId, $type);
        } catch (\Exception $e) {
            Log::error('Toggle like failed', ['user_id' => $user->id, 'video_id' => $videoId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function toggleDownload($user, int $videoId): void
    {
        try {
            $existing = Download::where('user_id', $user->id)
                ->where('video_id', $videoId)
                ->first();

            if (!$existing) {
                Download::create([
                    'user_id' => $user->id,
                    'video_id' => $videoId,
                    'downloaded_at' => now(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);

                Log::info('Video download tracked', ['user_id' => $user->id, 'video_id' => $videoId]);
            }
        } catch (\Exception $e) {
            Log::error('Track download failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function searchVideos(string $query, int $perPage = 12): LengthAwarePaginator
    {
        return $this->videoRepository->search($query, $perPage);
    }

    public function updateViews(int $videoId): void
    {
        $this->videoRepository->incrementViews($videoId);
    }
}
