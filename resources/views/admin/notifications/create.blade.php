@extends('layout.base')
@section('title','Create a notification')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Notification Management</h4>
                <span>Create and send notifications to users</span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Send notification to specific user -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Send to Specific User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('notifications.send') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="user_id">User<span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">Notification Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message">Notification Message<span class="text-danger">*</span></label>
                            <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="type">Notification Type<span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="info">Information (Blue)</option>
                                <option value="success">Success (Green)</option>
                                <option value="warning">Warning (Yellow)</option>
                                <option value="danger">Error (Red)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Send notification to all users -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Send to All Users</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('notifications.broadcast') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="broadcast_title">Notification Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" id="broadcast_title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="broadcast_message">Notification Message<span class="text-danger">*</span></label>
                            <textarea name="message" id="broadcast_message" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="broadcast_type">Notification Type<span class="text-danger">*</span></label>
                            <select name="type" id="broadcast_type" class="form-control" required>
                                <option value="info">Information (Blue)</option>
                                <option value="success">Success (Green)</option>
                                <option value="warning">Warning (Yellow)</option>
                                <option value="danger">Error (Red)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Send to All</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Send notification to specific group -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Send to Specific Group</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('notifications.sendToGroup') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="role">Group<span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="group_title">Notification Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" id="group_title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="group_message">Notification Message<span class="text-danger">*</span></label>
                            <textarea name="message" id="group_message" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="group_type">Notification Type<span class="text-danger">*</span></label>
                            <select name="type" id="group_type" class="form-control" required>
                                <option value="info">Information (Blue)</option>
                                <option value="success">Success (Green)</option>
                                <option value="warning">Warning (Yellow)</option>
                                <option value="danger">Error (Red)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Send to Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
