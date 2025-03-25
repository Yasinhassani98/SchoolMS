<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->paginate(10);
        // dd($reports);
        return view('admin.reports.index', compact('reports'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        Report::create($request->all());
        return redirect()->route('welcome');
    }
    public function show(Report $report)
    {
        // dd($report);
        return view('admin.reports.show', compact('report'));
    }
}
