@extends('layout.base')
@section('title', 'Add New Parint')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Parint</h5>
            <form enctype="multipart/form-data" class="row" action="{{ route('admin.parints.store') }}" method="POST">
                @csrf
                <div class="mb-3 col-md-6">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                        name="image" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Parint Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="Email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" value="{{ old('password') }}" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="password.confirmation" class="form-label">Password Confirmation<span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password.confirmation') is-invalid @enderror" id="password.confirmation"
                        name="password.confirmation" value="{{ old('password.confirmation') }}" required>
                    @error('password.confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date_of_birth" class="form-label">Date of birth<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Add Parint</button>
                </div>
            </form>
        </div>
    </div>
@endsection
