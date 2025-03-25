@extends('layout.base')
@section('title', 'Report Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Report Details</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $report->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $report->email }}</td>
                                </tr>
                                <tr>
                                    <th>Date Submitted</th>
                                    <td>{{ $report->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td>
                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($report->message)) !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        @if(auth()->user()->can('delete', $report))
                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Report
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection