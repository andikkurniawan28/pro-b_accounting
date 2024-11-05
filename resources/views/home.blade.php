@extends('template.master')

@section('content')

<!-- Jumbotron Section -->
<div class="jumbotron jumbotron-fluid bg-light text-center mb-4">
    <div class="container">
        <h1 class="display-4">Welcome to the {{ $setting->app_name }}</h1>
        <p class="lead">Manage your finances effectively with our comprehensive tools and features.</p>
    </div>
</div>

<div class="row">
    <!-- Dashboard -->
    @php $permissionsNeeded = ['dashboard']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Dashboard</h5>
            </div>
            <div class="card-body">
                <p>Overview of key financial metrics, recent activities, and performance summaries in one place.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Settings -->
    @php $permissionsNeeded = ['setting.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Settings</h5>
            </div>
            <div class="card-body">
                <p>Configure system settings, including application preferences and global settings for your organization.</p>
                <a href="{{ route('setting.index') }}" class="btn btn-primary">Manage Settings</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Roles -->
    @php $permissionsNeeded = ['role.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Roles</h5>
            </div>
            <div class="card-body">
                <p>Define and manage user roles and permissions within the system to control access to specific features.</p>
                <a href="{{ route('role.index') }}" class="btn btn-primary">Manage Roles</a>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Users -->
    @php $permissionsNeeded = ['user.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Users</h5>
            </div>
            <div class="card-body">
                <p>Manage user accounts and profiles for individuals who have access to the system.</p>
                <a href="{{ route('user.index') }}" class="btn btn-primary">Manage Users</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Currency -->
    @php $permissionsNeeded = ['currency.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Currency</h5>
            </div>
            <div class="card-body">
                <p>Configure and manage currency settings for financial transactions and reporting.</p>
                <a href="{{ route('currency.index') }}" class="btn btn-primary">Manage Currency</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Account Groups -->
    @php $permissionsNeeded = ['account_group.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Account Groups</h5>
            </div>
            <div class="card-body">
                <p>Organize accounts into groups to streamline categorization and reporting.</p>
                <a href="{{ route('account_group.index') }}" class="btn btn-primary">Manage Account Groups</a>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Accounts -->
    @php $permissionsNeeded = ['account.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Accounts</h5>
            </div>
            <div class="card-body">
                <p>Create and manage individual accounts to record transactions accurately.</p>
                <a href="{{ route('account.index') }}" class="btn btn-primary">Manage Accounts</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Journals -->
    @php $permissionsNeeded = ['journal.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Journals</h5>
            </div>
            <div class="card-body">
                <p>Record and track transactions through journal entries for accurate financial documentation.</p>
                <a href="{{ route('journal.index') }}" class="btn btn-primary">Manage Journals</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Ledgers -->
    @php $permissionsNeeded = ['ledger.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Ledgers</h5>
            </div>
            <div class="card-body">
                <p>Summarize and review transactions by account in the ledger to monitor balances and activity.</p>
                <a href="{{ route('ledger.index') }}" class="btn btn-primary">Manage Ledgers</a>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Balance Sheet -->
    @php $permissionsNeeded = ['balance_sheet.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Balance Sheet</h5>
            </div>
            <div class="card-body">
                <p>View the financial position of your organization with assets, liabilities, and equity reports.</p>
                <a href="{{ route('balance_sheet.index') }}" class="btn btn-primary">View Balance Sheet</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Income Statement -->
    @php $permissionsNeeded = ['income_statement.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Income Statement</h5>
            </div>
            <div class="card-body">
                <p>Review the revenue, expenses, and profit to assess the financial performance over a period.</p>
                <a href="{{ route('income_statement.index') }}" class="btn btn-primary">View Income Statement</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Cash Flow -->
    @php $permissionsNeeded = ['cash_flow.index']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
    @if ($hasAccess)
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Cash Flow</h5>
            </div>
            <div class="card-body">
                <p>Analyze cash inflows and outflows to manage liquidity and cash reserves.</p>
                <a href="{{ route('cash_flow.index') }}" class="btn btn-primary">View Cash Flow</a>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
