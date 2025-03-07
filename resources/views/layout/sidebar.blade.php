<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            @role('admin')
            <li>
                <a href="{{ route('admin.students.index') }}" class="{{ Route::is('admin.students.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-sharp-duotone fa-solid fa-graduation-cap"></i><span class="nav-text">Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.teachers.index') }}" class="{{ Route::is('admin.teachers.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-person-chalkboard"></i><span class="nav-text">Teachers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.classrooms.index') }}" class="{{ Route::is('admin.classrooms.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-users"></i><span class="nav-text">Classrooms</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.subjects.index') }}" class="{{ Route::is('admin.subjects.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-clipboard-list"></i><span class="nav-text">Subjects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.levels.index') }}" class="{{ Route::is('admin.levels.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-school"></i><span class="nav-text">Levels</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.marks.index') }}" class="{{ Route::is('admin.marks.*')? 'active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-marker"></i><span class="nav-text">Marks</span>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</div>
