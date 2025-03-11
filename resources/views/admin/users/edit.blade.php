@extends('layout.base')
@section('title', 'Edit User')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Edit User</h5>
            <form class="row" action="{{ route('admin.users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" value="{{ old('password') }}">
                    <small class="text-muted">Leave blank to keep current password</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password.confirmation" class="form-label">Password Confirmation</label>
                    <input type="password" class="form-control @error('password.confirmation') is-invalid @enderror" id="password.confirmation"
                        name="password.confirmation" value="{{ old('password.confirmation') }}" >
                    @error('password.confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="roles" class="form-label">Roles<span class="text-danger">*</span></label>
                    <input name="roles" id="roles"
                        class="form-control @error('roles') is-invalid @enderror"
                        value="{{ old('roles', $user->roles->map(function($role) {
                            return [
                                'value' => $role->name,
                                'label' => $role->name
                            ]; 
                        })->toJson()) }}">
                    @error('roles')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" @selected(old('status', $user->status) == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $user->status) == 'inactive')>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update User</button>
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
            const input = document.querySelector('input[name=roles]');
            if (!input) {
                console.error('Role input element not found');
                return;
            }

            // Prepare roles data
            const roles = {!! json_encode($roles->map(function($role) {
                return [
                    'value' => $role->name,
                    'label' => $role->name,
                    'searchBy' => $role->name // Additional search terms
                ];
            })) !!};

            // Initialize Tagify with enhanced configuration
            const tagify = new Tagify(input, {
                whitelist: roles,
                dropdown: {
                    maxItems: 20,
                    enabled: 1,
                    closeOnSelect: false,
                    searchKeys: ['label', 'searchBy'],
                    highlightFirst: true,
                    placeAbove: false,
                    appendTarget: document.body
                },
                enforceWhitelist: true,
                maxTags: 5,
                placeholder: 'Search and select roles...',
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
                    tagData.class = 'role-tag';
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value)
            });

            // Enhanced event handlers
            tagify.on('add', function(e) {
                const { data: tagData } = e.detail;
                console.log('Role added:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('remove', function(e) {
                const { data: tagData } = e.detail;
                console.log('Role removed:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('invalid', function(e) {
                console.warn('Invalid role selection:', e.detail);
            });

            // Focus handling
            input.addEventListener('focus', function() {
                tagify.dropdown.show();
            });
        });
    </script>
@endpush