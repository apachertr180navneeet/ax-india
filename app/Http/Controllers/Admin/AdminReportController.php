<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoReport;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = VideoReport::with(['user', 'video'])->latest()->paginate(15);
        return view('admin.reports.index', compact('reports'));
    }

    public function resolve($id)
    {
        $report = VideoReport::findOrFail($id);
        $report->delete();
        return back()->with('success', 'Report resolved and cleared.');
    }
}
