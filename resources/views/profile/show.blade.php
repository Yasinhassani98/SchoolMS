@extends('layout.base')
@section('title', 'profile Details')
@section('content')

    <div class="card mb-4 mt-4 shadow">
        <div class="card-header bg-primary text-white justify-content-center d-flex">
            <h5 class="card-title mb-0">User Details</h5>
        </div>
        @role('student')
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <img src="{{ $user->student->getImageURL() }}" alt="{{ $user->name }}'s Profile Picture"
                            class="img-fluid rounded-circle shadow-sm" style="width: 200px; height: 200px; object-fit: cover;"
                            loading="lazy">
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">user Name:</strong>
                            <p class="mb-0">{{ $user->name ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">user Gender:</strong>
                            <p class="mb-0">{{ $user->student->gender ?? '' }}</p>
                        </div>
                    </div>
                    {{-- @role('student') --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Parent Name:</strong>
                            <p class="mb-0">{{ $user->student->parent->name ?? '' }}</p>
                        </div>
                    </div>
                    {{-- @endrole --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Classroom Name:</strong>
                            <p class="mb-0">{{ $user->student->classroom->name ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Email:</strong>
                            <p class="mb-0">{{ $user->email ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Phone:</strong>
                            <p class="mb-0">{{ $user->student->phone ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Enrollment Date:</strong>
                            <p class="mb-0">{{ $user->student->enrollment_date ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Address:</strong>
                            <p class="mb-0">{{ $user->student->address ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Date of Birth:</strong>
                            <p class="mb-0">{{ $user->student->date_of_birth ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Status:</strong>
                            <p class="mb-0">{{ ucfirst($user->student->status) }}</p>
                        </div>
                    </div>
                </div>
            @endrole


            @role('teacher')
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <img src="{{ $user->teacher->getImageURL() }}" alt="{{ $user->name }}'s Profile Picture"
                                class="img-fluid rounded-circle shadow-sm"
                                style="width: 200px; height: 200px; object-fit: cover;" loading="lazy">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">user Name:</strong>
                                <p class="mb-0">{{ $user->name ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">user Gender:</strong>
                                <p class="mb-0">{{ $user->teacher->gender ?? '' }}</p>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Classroom Name:</strong>
                            <p class="mb-0">{{ $user->student->classroom->name ?? ''}}</p>
                        </div>
                    </div> --}}
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Email:</strong>
                                <p class="mb-0">{{ $user->email ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Phone:</strong>
                                <p class="mb-0">{{ $user->teacher->phone ?? '' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Date of Birth:</strong>
                                <p class="mb-0">{{ $user->teacher->date_of_birth ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Specialization</strong>
                                <p class="mb-0">{{ $user->teacher->specialization ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Hiring Date</strong>
                                <p class="mb-0">{{ $user->teacher->hiring_date ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3">
                                <strong class="text-secondary">Status</strong>
                                <p class="mb-0">{{ $user->teacher->status ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            @role('parent')
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <img src="{{ $user->parent->getImageURL() }}" alt="{{ $user->name }}'s Profile Picture"
                            class="img-fluid rounded-circle shadow-sm"
                            style="width: 200px; height: 200px; object-fit: cover;" loading="lazy">
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">user Name:</strong>
                            <p class="mb-0">{{ $user->name ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Email:</strong>
                            <p class="mb-0">{{ $user->email ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Phone:</strong>
                            <p class="mb-0">{{ $user->parent->phone ?? '' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light p-3">
                            <strong class="text-secondary">Date of Birth:</strong>
                            <p class="mb-0">{{ $user->parent->date_of_birth ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role('superadmin')
        <div class="card-body p-4">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">user Name:</strong>
                        <p class="mb-0">{{ $user->name ?? '' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-light p-3">
                        <strong class="text-secondary">Email:</strong>
                        <p class="mb-0">{{ $user->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endrole


    @role('admin')
    <div class="card-body p-4">
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card bg-light p-3">
                    <strong class="text-secondary">user Name:</strong>
                    <p class="mb-0">{{ $user->name ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-light p-3">
                    <strong class="text-secondary">Email:</strong>
                    <p class="mb-0">{{ $user->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
@endrole
        </div>
    @endsection
