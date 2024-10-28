@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'setting')) }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("setting.store") }}" method="POST">
                            @csrf @method("POST")

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="app_name">
                                    {{ ucwords(str_replace('_', ' ', 'app_name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="app_name" name="app_name" value="{{ $setting->app_name }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_name">
                                    {{ ucwords(str_replace('_', ' ', 'company_name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $setting->company_name }}" required>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
