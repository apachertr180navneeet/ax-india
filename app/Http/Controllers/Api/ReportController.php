<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportVideoRequest;
use App\Http\Requests\ReviewReportRequest;
use App\Services\ReportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly ReportService $reportService) {}

    public function store(ReportVideoRequest $request): JsonResponse
    {
        $report = $this->reportService->reportVideo(
            $request->user(),
            $request->integer('video_id'),
            $request->validated()
        );

        return $this->successResponse($report, 'Video reported successfully', 201);
    }

    public function index(Request $request): JsonResponse
    {
        $reports = $this->reportService->getReports(
            $request->input('status'),
            $request->integer('per_page', 15)
        );

        return $this->successResponse($reports, 'Reports retrieved successfully');
    }

    public function adminIndex(Request $request): JsonResponse
    {
        $reports = $this->reportService->getReports(
            $request->input('status'),
            $request->integer('per_page', 15)
        );

        return $this->successResponse($reports, 'All reports retrieved successfully');
    }

    public function review(ReviewReportRequest $request, int $id): JsonResponse
    {
        $report = $this->reportService->reviewReport(
            $request->user()->id,
            $id,
            $request->input('status'),
            $request->input('admin_note')
        );

        return $this->successResponse($report, 'Report reviewed successfully');
    }
}
