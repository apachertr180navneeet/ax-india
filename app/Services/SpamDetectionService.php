<?php

namespace App\Services;

use App\Models\SpamDetectionLog;
use App\Models\Comment;
use App\Models\Video;

class SpamDetectionService
{
    /**
     * Analyze text content (video description or comment) for spam patterns.
     */
    public function analyzeText(string $text, string $targetType, int $targetId, ?int $userId = null): array
    {
        $flags = [];
        $score = 0.0;

        // Rule 1: Link spam check
        if (preg_match_all('/https?:\/\/[^\s]+/', $text, $matches)) {
            $linkCount = count($matches[0]);
            if ($linkCount >= 3) {
                $flags[] = 'excessive_links';
                $score += 40.0;
            } elseif ($linkCount >= 1) {
                $score += 15.0;
            }
        }

        // Rule 2: Repetitive characters / ALL CAPS
        $capsRatio = strlen(preg_replace('/[^A-Z]/', '', $text)) / max(1, strlen($text));
        if (strlen($text) > 10 && $capsRatio > 0.7) {
            $flags[] = 'excessive_caps';
            $score += 25.0;
        }

        // Rule 3: Known spam keywords
        $spamKeywords = ['free money', 'click here now', 'telegram link', 'whatsapp group', 'crypto bonus', 'buy followers'];
        foreach ($spamKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $flags[] = 'spam_keyword:' . $keyword;
                $score += 35.0;
            }
        }

        $actionTaken = 'none';
        if ($score >= 75.0) {
            $actionTaken = 'blocked';
        } elseif ($score >= 40.0) {
            $actionTaken = 'flagged';
        }

        $log = SpamDetectionLog::create([
            'target_type' => $targetType,
            'target_id' => $targetId,
            'user_id' => $userId,
            'spam_score' => min(100.0, $score),
            'detected_flags' => $flags,
            'action_taken' => $actionTaken,
        ]);

        return [
            'score' => min(100.0, $score),
            'flags' => $flags,
            'action_taken' => $actionTaken,
            'log' => $log,
        ];
    }
}
