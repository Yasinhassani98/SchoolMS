@extends('layout.base')

@section('content')
    @extends('layout.base')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Update Student</h5>
            <form class="row" action="{{ route('students.update',$student) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Student Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ $student->name }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="classroom" class="form-label">Classroom</label>
                    <input type="number" class="form-control @error('classroom') is-invalid @enderror" id="classroom"
                        name="classroom_id" value="{{ $student->classroom_id }}" required>
                    @error('classroom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email"
                        name="Email" value="{{ $student->email }}" required>
                    @error('Email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="Phone" class="form-label">Phone</label>
                    <input type="number" class="form-control @error('Phone') is-invalid @enderror" id="Phone"
                        name="Phone" value="{{ $student->phone }}" required>
                    @error('Phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="enrollment_date" class="form-label">Enrollment date</label>
                    <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror"
                        id="enrollment_date" name="enrollment_date" value="{{ $student->enrollment_date }}" required>
                    @error('enrollment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ $student->address }}" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date_of_birth" class="form-label">Date of birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ $student->date_of_birth }}" required>
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="parent_phone" class="form-label">Parent phone</label>
                    <input type="number" class="form-control @error('parent_phone') is-invalid @enderror" id="parent_phone"
                        name="parent_phone" value="{{ $student->parent_phone }}" required>
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
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@endsection
