@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'edit_account_group')) }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account_group.index') }}">{{ ucwords(str_replace('_', ' ', 'account_group')) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account_group.update', $account_group->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="name">
                                    {{ ucwords(str_replace('_', ' ', 'name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $account_group->name) }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="activity_type">
                                    {{ ucwords(str_replace('_', ' ', 'activity_type')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="activity_type" name="activity_type">
                                        <option value="" disabled>Select Activity Type</option>
                                        <option value="" {{ is_null($account_group->normal_balance) ? 'selected' : '' }}>None</option>
                                        <option value="Investing" {{ $account_group->activity_type == 'Investing' ? 'selected' : '' }}>Investing</option>
                                        <option value="Financing" {{ $account_group->activity_type == 'Financing' ? 'selected' : '' }}>Financing</option>
                                        <option value="Operating" {{ $account_group->activity_type == 'Operating' ? 'selected' : '' }}>Operating</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
