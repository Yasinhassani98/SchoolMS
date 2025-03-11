@extends('layout.base')
@section('title', 'Add New Role')
@section('content')

    <div class="card mb-4 mt-2 container">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Role</h5>
            <form class="row" action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Role Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="permissions" class="form-label">Permissions</label>
                    <input name="permissions" id="permissions"
                        class="form-control @error('permissions') is-invalid @enderror"
                        value="{{ old('permissions') }}">
                    @error('permissions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Role</button>
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
            min-height: 40px;
            height: auto;
            max-height: none;
        }
        
        .tagify__input {
            min-height: 30px;
            height: auto;
            overflow: hidden;
        }

        .tagify__tags {
            display: flex;
            flex-wrap: wrap;
            min-height: 30px;
            height: auto;
        }
        
        .permission-tag .tagify__tag__removeBtn {
            color: #dc3545;
        }
        
        .permission-tag {
            background-color: #e9f5ff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get input element and ensure it exists
            const input = document.querySelector('input[name=permissions]');
            if (!input) {
                console.error('Permissions input element not found');
                return;
            }

            // Prepare permissions data
            const permissions = {!! json_encode($permissions->map(function($permission) {
                return [
                    'value' => $permission->name,
                    'label' => $permission->name,
                    'searchBy' => $permission->name // Additional search terms
                ];
            })) !!};

            // Initialize Tagify with enhanced configuration
            const tagify = new Tagify(input, {
                whitelist: permissions,
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
                maxTags: 50,
                placeholder: 'Search and select permissions...',
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
                    tagData.class = 'permission-tag';
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value)
            });

            // Enhanced event handlers
            tagify.on('add', function(e) {
                const { data: tagData } = e.detail;
                console.log('Permission added:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('remove', function(e) {
                const { data: tagData } = e.detail;
                console.log('Permission removed:', tagData);
                // Trigger validation or additional actions
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tagify.on('invalid', function(e) {
                console.warn('Invalid permission selection:', e.detail);
            });

            // Focus handling
            input.addEventListener('focus', function() {
                tagify.dropdown.show();
            });
        });
    </script>
@endpush