        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-left" href="{{ route('dashboard') }}">
                <!-- <div class="sidebar-brand-icon">
                    <img src="{{ asset($setting->company_logo) }}" alt="Company Logo" style="width: 40px; height: auto;">
                </div> -->
                <div class="sidebar-brand-icon font-weight-bold">
                    <h6 class="mx-3">{{ $setting->app_name }}</h6>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'home')) }}</span></a>
            </li>

            @php
                $permissionsNeeded = ['dashboard'];
                $hasAccess = array_intersect($permissionsNeeded, $list_of_permission);
            @endphp
            @if ($hasAccess)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'dashboard')) }}</span></a>
            </li>
            @endif

            @php
                $permissionsNeeded = ['role.index', 'user.index', 'activity_log.index'];
                $hasAccess = array_intersect($permissionsNeeded, $list_of_permission);
            @endphp
            @if ($hasAccess)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#access"
                    aria-expanded="true" aria-controls="access">
                        <i class="fas fa-fw fa-door-open"></i>
                        <span>{{ ucwords(str_replace('_', ' ', 'access')) }}</span>
                    </a>
                    <div id="access" class="collapse" aria-labelledby="access" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach ($permissionsNeeded as $permission)
                                @if (in_array($permission, $list_of_permission))
                                    <a class="collapse-item" href="{{ route($permission) }}">
                                        {{ ucwords(str_replace('_', ' ', explode('.', $permission)[0])) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            @php
                $permissionsNeeded = ['currency.index', 'tax_rate.index', 'account_group.index', 'account.index', 'payment_term.index'];
                $hasAccess = array_intersect($permissionsNeeded, $list_of_permission);
            @endphp
            @if ($hasAccess)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master"
                    aria-expanded="true" aria-controls="master">
                        <i class="fas fa-fw fa-database"></i>
                        <span>{{ ucwords(str_replace('_', ' ', 'master')) }}</span>
                    </a>
                    <div id="master" class="collapse" aria-labelledby="master" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Accounting :</h6>
                            @foreach ($permissionsNeeded as $permission)
                                @if (in_array($permission, $list_of_permission))
                                    <a class="collapse-item" href="{{ route($permission) }}">
                                        {{ ucwords(str_replace('_', ' ', explode('.', $permission)[0])) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            @php
                $permissionsNeeded = ['budget.index', 'journal.index', 'ledger.index'];
                $hasAccess = array_intersect($permissionsNeeded, $list_of_permission);
            @endphp
            @if ($hasAccess)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaction"
                    aria-expanded="true" aria-controls="transaction">
                        <i class="fas fa-fw fa-exchange-alt"></i>
                        <span>{{ ucwords(str_replace('_', ' ', 'transaction')) }}</span>
                    </a>
                    <div id="transaction" class="collapse" aria-labelledby="transaction" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Accounting :</h6>
                            @foreach ($permissionsNeeded as $permission)
                                @if (in_array($permission, $list_of_permission))
                                    <a class="collapse-item" href="{{ route($permission) }}">
                                        {{ ucwords(str_replace('_', ' ', explode('.', $permission)[0])) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            @php
                $permissionsNeeded = ['balance_sheet.index', 'income_statement.index', 'cash_flow.index'];
                $hasAccess = array_intersect($permissionsNeeded, $list_of_permission);
            @endphp
            @if ($hasAccess)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report"
                    aria-expanded="true" aria-controls="report">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>{{ ucwords(str_replace('_', ' ', 'report')) }}</span>
                    </a>
                    <div id="report" class="collapse" aria-labelledby="report" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Accounting :</h6>
                            @foreach ($permissionsNeeded as $permission)
                                @if (in_array($permission, $list_of_permission))
                                    <a class="collapse-item" href="{{ route($permission) }}">
                                        {{ ucwords(str_replace('_', ' ', explode('.', $permission)[0])) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
