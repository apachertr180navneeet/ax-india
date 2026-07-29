<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VideoReportedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public VideoReport $report;
    public Video $video;
    public User $reporter;

    public function __construct(VideoReport $report, Video $video, User $reporter)
    {
        $this->report = $report;
        $this->video = $video;
        $this->reporter = $reporter;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $reason = $this->report->reason?->value ?? $this->report->reason;

        return (new MailMessage)
            ->subject('Video Reported: ' . $this->video->title)
            ->greeting('Admin Alert')
            ->line($this->reporter->full_name . ' has reported a video.')
            ->line('Video: ' . $this->video->title)
            ->line('Reason: ' . $reason)
            ->action('Review Report', url('/admin/reports/' . $this->report->id))
            ->line('Please review this report at your earliest convenience.');
    }

    public function toArray($notifiable): array
    {
        $reason = $this->report->reason?->value ?? $this->report->reason;

        return [
            'type' => 'video_report',
            'message' => $this->reporter->full_name . ' reported "' . $this->video->title . '" for ' . $reason,
            'reporter_id' => $this->reporter->id,
            'reporter_name' => $this->reporter->full_name,
            'video_id' => $this->video->id,
            'video_title' => $this->video->title,
            'video_slug' => $this->video->slug,
            'reason' => $reason,
        ];
    }
}
