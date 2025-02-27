@extends('layout.base')
@section('title', 'Add New Student')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Student</h5>
            <form enctype="multipart/form-data" class="row" action="{{ route('students.store') }}" method="POST">
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
                    <label for="name" class="form-label">Student Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="classroom" class="form-label">Classroom</label>
                    <select class="form-control @error('classroom_id') is-invalid @enderror" id="classroom_id"
                        name="classroom_id">
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" @selected(old('classroom_id') == $classroom->id)>{{ $classroom->name }}
                            </option>
                        @endforeach
                        @error('classroom_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="Phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('Phone') is-invalid @enderror" id="Phone"
                        name="Phone" value="{{ old('Phone') }}">
                    @error('Phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="enrollment_date" class="form-label">Enrollment date</label>
                    <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror"
                        id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date') }}" required>
                    @error('enrollment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date_of_birth" class="form-label">Date of birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="parent_phone" class="form-label">Parent phone</label>
                    <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" id="parent_phone"
                        name="parent_phone" value="{{ old('parent_phone') }}">
                    @error('parent_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" @selected(old('status') == 'active')>Active</option>
                        <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
@endsection
