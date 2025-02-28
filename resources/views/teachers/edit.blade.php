@extends('layout.base')
@section('title', 'Edit Teacher')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit Teacher {{ $teacher->name }}</h5>
            <form enctype="multipart/form-data" class="row" action="{{ route('teachers.update',$teacher->id) }}" method="POST">
                @method('PUT')
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
                    <label for="name" class="form-label">Teacher Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name',$teacher->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="classroom_ids" class="form-label">Classrooms</label>
                    <input name="classroom_ids" id="classroom_ids"
                        class="form-control @error('classroom_ids') is-invalid @enderror"
                        value="{{ old('classroom_ids', $teacher->classrooms->map(function($classroom) {
                            return [
                                'value' => $classroom->id,
                                'label' => 'Grade ' . $classroom->level->level . ' - ' . $classroom->name
                            ]; 
                        })->toJson()) }}">
                    @error('classroom_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-12">
                    <label for="subject_ids" class="form-label">Subjects</label>
                    <input name="subject_ids" id="subject_ids"
                        class="form-control @error('subject_ids') is-invalid @enderror"
                        value="{{ old('subject_ids', $teacher->subjects->map(function($subject) {
                            return [
                                'value' => $subject->id,
                                'label' => $subject->level->level . ' - ' . $subject->name
                            ]; 
                        })->toJson()) }}">
                    @error('subject_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                        name="email" value="{{ old('email',$teacher->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone',$teacher->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date_of_birth" class="form-label">Date of birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth',$teacher->date_of_birth) }}" required>
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="phone"
                        name="specialization" value="{{ old('specialization',$teacher->specialization) }}">
                    @error('specialization')
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
                    <button type="submit" class="btn btn-primary">Update teacher</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card-title {
            color: var(--primary-color);
        }

        .tagify {
            --tags-border-color: #dee2e6;
            --tags-hover-border-color: #8bbafe;
            --tags-focus-border-color: #86b7fe;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get input element and ensure it exists
            const input = document.querySelector('input[name=classroom_ids]');
            if (!input) {
                console.error('Classroom input element not found');
                return;
            }

            // Prepare classroom data
            const classrooms = {!! json_encode($classrooms->map(function($classroom) {
                return [
                    'value' => $classroom->id,
                    'label' => 'Grade ' . $classroom->level->level . ' - ' . $classroom->name,
                    'searchBy' => 'Grade ' . $classroom->level->level . ' ' . $classroom->name // Additional search terms
                ];
            })) !!};

            // Initialize Tagify with enhanced configuration
            const tagify = new Tagify(input, {
                whitelist: classrooms,
                dropdown: {
                    maxItems: 50,
                    enabled: 1,
                    closeOnSelect: false,
                    searchKeys: ['label', 'searchBy'],
                    highlightFirst: true,
                    placeAbove: false,
                    appendTarget: document.body
                },
                enforceWhitelist: true,
                maxTags: 10,
                placeholder: 'Search and select classrooms...',
                editTags: false,
                delimiters: null,
                templates: {
                    tag: function(tagData) {
                        return `
                            <tag title="${tagData.label}"
                                 contenteditable='false'
                                 spellcheck='false'
                                 class="tagify__tag ${tagData.class ? tagData.class : ''}"
                                 ${this.getAttributes(tagData)}>
                                <x title="Remove" class="tagify__tag__removeBtn"></x>
                                <div class="tagify__tag-text">${tagData.label}</div>
                            </tag>
                        `;
                    },
                    dropdownItem: function(tagData) {
                        return `
                            <div ${this.getAttributes(tagData)}
                                 class='tagify__dropdown__item ${tagData.class ? tagData.class : ''}'
                                 tabindex="0"
                                 role="option">
                                <strong>${tagData.label.split(' - ')[0]}</strong>
                                <span>${tagData.label.split(' - ')[1]}</span>
                            </div>
                        `;
                    }
                },
                transformTag: function(tagData) {
                    tagData.label = tagData.label || tagData.value;
                    tagData.class = 'classroom-tag';
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value)
            });

            // Enhanced event handlers
            tagify.on('add', function(e) {
                const { data: tagData } = e.detail;
                console.log('Classroom added:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('remove', function(e) {
                const { data: tagData } = e.detail;
                console.log('Classroom removed:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('invalid', function(e) {
                console.warn('Invalid classroom selection:', e.detail);
            });

            // Focus handling
            input.addEventListener('focus', function() {
                tagify.dropdown.show();
            });
        });

        // Subjects Tagify Implementation
        document.addEventListener('DOMContentLoaded', function() {
            // Get input element and ensure it exists
            const input = document.querySelector('input[name=subject_ids]');
            if (!input) {
                console.error('Subject input element not found');
                return;
            }

            // Prepare subjects data
            const subjects = {!! json_encode($subjects->map(function($subject) {
                return [
                    'value' => $subject->id,
                    'label' => $subject->level->level . ' - ' . $subject->name,
                    'searchBy' => $subject->name // Additional search terms
                ];
            })) !!};

            // Initialize Tagify with enhanced configuration
            const tagify = new Tagify(input, {
                whitelist: subjects,
                dropdown: {
                    maxItems: 50,
                    enabled: 1,
                    closeOnSelect: false,
                    searchKeys: ['label', 'searchBy'],
                    highlightFirst: true,
                    placeAbove: false,
                    appendTarget: document.body
                },
                enforceWhitelist: true,
                maxTags: 10,
                placeholder: 'Search and select subjects...',
                editTags: false,
                delimiters: null,
                templates: {
                    tag: function(tagData) {
                        return `
                            <tag title="${tagData.label}"
                                 contenteditable='false'
                                 spellcheck='false'
                                 class="tagify__tag ${tagData.class ? tagData.class : ''}"
                                 ${this.getAttributes(tagData)}>
                                <x title="Remove" class="tagify__tag__removeBtn"></x>
                                <div class="tagify__tag-text">${tagData.label}</div>
                            </tag>
                        `;
                    },
                    dropdownItem: function(tagData) {
                        return `
                            <div ${this.getAttributes(tagData)}
                                 class='tagify__dropdown__item ${tagData.class ? tagData.class : ''}'
                                 tabindex="0"
                                 role="option">
                                <span>${tagData.label}</span>
                            </div>
                        `;
                    }
                },
                transformTag: function(tagData) {
                    tagData.label = tagData.label || tagData.value;
                    tagData.class = 'subject-tag';
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value)
            });

            // Enhanced event handlers
            tagify.on('add', function(e) {
                const { data: tagData } = e.detail;
                console.log('Subject added:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('remove', function(e) {
                const { data: tagData } = e.detail;
                console.log('Subject removed:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('invalid', function(e) {
                console.warn('Invalid subject selection:', e.detail);
            });

            // Focus handling
            input.addEventListener('focus', function() {
                tagify.dropdown.show();
            });
        });
    </script>
@endpush
