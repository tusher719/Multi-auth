<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            Tusher<span>Dev</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">web apps</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Email</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/email/inbox.html" class="nav-link">Inbox</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Read</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/compose.html" class="nav-link">Compose</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a href="pages/apps/calendar.html" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Calendar</span>
                </a>
            </li>
            <li class="nav-item nav-category">Components</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                    <i class="link-icon" data-feather="feather"></i>
                    <span class="link-title">Todos</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('all.todos') }}" class="nav-link">All Todos</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/alerts.html" class="nav-link">Add Todos</a>
                        </li>
                    </ul>
                </div>
            </li>

            @if(Auth::user()->can('type.menu'))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Advanced UI</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="advancedUI">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/sortablejs.html" class="nav-link">SortableJs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/sweet-alert.html" class="nav-link">Sweet Alert</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            <li class="nav-item nav-category">Role & Permission</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#RolePermission" role="button" aria-expanded="false" aria-controls="RolePermission">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Role & Permission</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="RolePermission">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('all.permission') }}" class="nav-link">All Permission</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.roles') }}" class="nav-link">Add Role</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('add.roles.permission') }}" class="nav-link">Role in Permission</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.roles.permission') }}" class="nav-link">All Role in Permission</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#admin" role="button" aria-expanded="false" aria-controls="RolePermission">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Manage Admin User</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="admin">
                    <ul class="nav sub-menu">
                        @if(Auth::user()->can('admin.all'))
                        <li class="nav-item">
                            <a href="{{ route('all.admin') }}" class="nav-link">All Admin</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('admin.add'))
                        <li class="nav-item">
                            <a href="{{ route('add.admin') }}" class="nav-link">Add Admin</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Student Manage</li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#cp" role="button" aria-expanded="false" aria-controls="RolePermission">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Creative Park</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="cp">
                    <ul class="nav sub-menu">
                        @if(Auth::user()->can('admin.all'))
                        <li class="nav-item">
                            <a href="{{ route('all.cp.members') }}" class="nav-link">All Students</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('admin.add'))
                        <li class="nav-item">
                            <a href="{{ route('add.cp.member') }}" class="nav-link">Add Student</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('admin.add'))
                        <li class="nav-item">
                            <a href="{{ route('all.tag') }}" class="nav-link">Tags</a>
                        </li>
                        @endif

                    </ul>
                </div>
            </li>


            <li class="nav-item nav-category">Privet</li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#cp" role="button" aria-expanded="false" aria-controls="RolePermission">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Wallet</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="cp">
                    <ul class="nav sub-menu">
                        @if(Auth::user()->can('admin.all'))
                        <li class="nav-item">
                            <a href="{{ route('wallet.main') }}" class="nav-link">Wallet Main</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('admin.all'))
                        <li class="nav-item">
                            <a href="{{ route('wallet') }}" class="nav-link">Accounts</a>
                        </li>
                        @endif
                        @if(Auth::user()->can('admin.add'))
                        <li class="nav-item">
                            <a href="{{ route('wallet.record') }}" class="nav-link">Records</a>
                        </li>
                        @endif
                        {{-- @if(Auth::user()->can('admin.add')) --}}
                        <li class="nav-item">
                            <a href="{{ route('add.more') }}" class="nav-link">Add More</a>
                        </li>
                        {{-- @endif --}}
                        @if(Auth::user()->can('admin.add'))
                        <li class="nav-item">
                            <a href="{{ route('wallet.analytics') }}" class="nav-link">Analytics</a>
                        </li>
                        @endif

                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Documentation</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<nav class="settings-sidebar">
    <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
            <i data-feather="settings"></i>
        </a>
        <div class="theme-wrapper">
            <h6 class="text-muted mb-2">Light Theme:</h6>
            <a class="theme-item" href="../demo1/dashboard.html">
                <img src="{{ asset('assets') }}/images/screenshots/light.jpg" alt="light theme">
            </a>
            <h6 class="text-muted mb-2">Dark Theme:</h6>
            <a class="theme-item active" href="../demo2/dashboard.html">
                <img src="{{ asset('assets') }}/images/screenshots/dark.jpg" alt="light theme">
            </a>
        </div>
    </div>
</nav>
