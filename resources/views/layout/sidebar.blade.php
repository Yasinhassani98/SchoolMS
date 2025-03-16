<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            @role(['admin', 'superadmin'])
            <li class="nav-label">Admin & Superadmin</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-chart-line"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.roles.index') }}" class="{{ Route::is('admin.roles.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-user-shield"></i><span class="nav-text">Roles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.permissions.index') }}"
                    class="{{ Route::is('admin.permissions.*') ? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-key"></i><span class="nav-text">Permissions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-users"></i><span class="nav-text">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.students.index') }}" class="{{ Route::is('admin.students.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-sharp-duotone fa-solid fa-graduation-cap"></i><span class="nav-text">Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.teachers.index') }}"
                    class="{{ Route::is('admin.teachers.*') ? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-person-chalkboard"></i><span class="nav-text">Teachers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.parents.index') }}" class="{{ Route::is('admin.parints.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-user-friends"></i><span class="nav-text">Parents</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.academic-years.index') }}"
                    class="{{ Route::is('admin.academic-years.*') ? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-calendar-alt"></i><span class="nav-text">Academic Years</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.levels.index') }}" class="{{ Route::is('admin.levels.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-layer-group"></i><span class="nav-text">Levels</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.classrooms.index') }}"
                    class="{{ Route::is('admin.classrooms.*') ? 'active' : '' }}" aria-expanded="false">
                    <i class="fa fa-door-closed"></i><span class="nav-text">Classrooms</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.subjects.index') }}"
                    class="{{ Route::is('admin.subjects.*') ? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-book"></i><span class="nav-text">Subjects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.marks.index') }}" class="{{ Route::is('admin.marks.*') ? 'active' : '' }}"
                    aria-expanded="false">
                    <i class="fa-solid fa-marker"></i><span class="nav-text">Marks</span>
                </a>
            </li>
                <li>
                    <a href="{{ route('admin.attendances.index') }}" class="{{ Route::is('attendances.*') ? 'active' : '' }}"
                        aria-expanded="false">
                        <i class="fa-solid fa-clipboard-check"></i><span class="nav-text">Attendances</span>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</div>



