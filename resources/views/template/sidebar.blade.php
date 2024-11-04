        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> --}}
                <div class="sidebar-brand-text mx-3">{{ $setting->app_name }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'dashboard')) }}</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#access"
                    aria-expanded="true" aria-controls="access">
                    <i class="fas fa-fw fa-door-open"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'access')) }}</span>
                </a>
                <div id="access" class="collapse" aria-labelledby="access" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('role.index') }}">{{ ucwords(str_replace('_', ' ', 'role')) }}</a>
                        <a class="collapse-item" href="{{ route('user.index') }}">{{ ucwords(str_replace('_', ' ', 'user')) }}</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master"
                    aria-expanded="true" aria-controls="master">
                    <i class="fas fa-fw fa-database"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'master')) }}</span>
                </a>
                <div id="master" class="collapse" aria-labelledby="master" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('account_group.index') }}">{{ ucwords(str_replace('_', ' ', 'account_group')) }}</a>
                        <a class="collapse-item" href="{{ route('account.index') }}">{{ ucwords(str_replace('_', ' ', 'account')) }}</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaction"
                    aria-expanded="true" aria-controls="transaction">
                    <i class="fas fa-fw fa-exchange-alt"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'transaction')) }}</span>
                </a>
                <div id="transaction" class="collapse" aria-labelledby="transaction" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('journal.index') }}">{{ ucwords(str_replace('_', ' ', 'journal')) }}</a>
                        <a class="collapse-item" href="{{ route('ledger.index') }}">{{ ucwords(str_replace('_', ' ', 'ledger')) }}</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report"
                    aria-expanded="true" aria-controls="report">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>{{ ucwords(str_replace('_', ' ', 'report')) }}</span>
                </a>
                <div id="report" class="collapse" aria-labelledby="report" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('balance_sheet.index') }}">{{ ucwords(str_replace('_', ' ', 'balance_sheet')) }}</a>
                        <a class="collapse-item" href="{{ route('income_statement.index') }}">{{ ucwords(str_replace('_', ' ', 'income_statement')) }}</a>
                        <a class="collapse-item" href="{{ route('cash_flow.index') }}">{{ ucwords(str_replace('_', ' ', 'cash_flow')) }}</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
