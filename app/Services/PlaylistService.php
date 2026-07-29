<?php

namespace App\Services;

use App\Models\Playlist;
use App\Repositories\PlaylistRepository;
use App\Traits\Sluggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class PlaylistService
{
    use Sluggable;

    public function __construct(private Playlist $playlist, private PlaylistRepository $playlistRepository) {}

    public function create($user, array $data): Playlist
    {
        try {
            return DB::transaction(function () use ($user, $data) {
                $playlist = $this->playlistRepository->create([
                    'user_id' => $user->id,
                    'name' => $data['name'],
                    'slug' => $this->generateSlug($this->playlist, $data['name']),
                    'description' => $data['description'] ?? null,
                    'visibility' => $data['visibility'] ?? 'public',
                    'sort_order' => $data['sort_order'] ?? 0,
                ]);

                Log::info('Playlist created', ['playlist_id' => $playlist->id, 'user_id' => $user->id]);

                return $playlist->load('user');
            });
        } catch (\Exception $e) {
            Log::error('Playlist creation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update($user, int $id, array $data): Playlist
    {
        try {
            return DB::transaction(function () use ($user, $id, $data) {
                $playlist = $this->playlist->where('user_id', $user->id)->findOrFail($id);

                $this->playlistRepository->update($playlist, $data);

                Log::info('Playlist updated', ['playlist_id' => $id]);

                return $playlist->fresh()->load('user');
            });
        } catch (\Exception $e) {
            Log::error('Playlist update failed', ['playlist_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function delete($user, int $id): bool
    {
        try {
            return DB::transaction(function () use ($user, $id) {
                $playlist = $this->playlist->where('user_id', $user->id)->findOrFail($id);

                $result = $this->playlistRepository->delete($playlist);

                Log::info('Playlist deleted', ['playlist_id' => $id]);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('Playlist deletion failed', ['playlist_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getUserPlaylists(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->playlistRepository->findByUser($userId, $perPage);
    }

    public function addVideo($user, int $playlistId, int $videoId): void
    {
        try {
            $playlist = $this->playlist->where('user_id', $user->id)->findOrFail($playlistId);
            $this->playlistRepository->addVideo($playlist, $videoId);

            Log::info('Video added to playlist', ['playlist_id' => $playlistId, 'video_id' => $videoId]);
        } catch (\Exception $e) {
            Log::error('Add video to playlist failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function removeVideo($user, int $playlistId, int $videoId): void
    {
        try {
            $playlist = $this->playlist->where('user_id', $user->id)->findOrFail($playlistId);
            $this->playlistRepository->removeVideo($playlist, $videoId);

            Log::info('Video removed from playlist', ['playlist_id' => $playlistId, 'video_id' => $videoId]);
        } catch (\Exception $e) {
            Log::error('Remove video from playlist failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getPlaylistVideos(int $playlistId, int $perPage = 10): LengthAwarePaginator
    {
        $playlist = $this->playlistRepository->findById($playlistId);

        if (!$playlist) {
            abort(404, 'Playlist not found');
        }

        return $this->playlistRepository->getVideos($playlist, $perPage);
    }
}
