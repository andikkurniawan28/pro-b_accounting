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
                        <form action="{{ route("setting.store") }}" method="POST" enctype="multipart/form-data">
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

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_logo">
                                    {{ ucwords(str_replace('_', ' ', 'company_logo')) }}
                                </label>
                                <div class="col-sm-10">
                                    @if($setting->company_logo)
                                        <div class="mb-3">
                                            <img src="{{ asset($setting->company_logo) }}" alt="Company Logo" style="max-height: 100px; max-width: 200px;">
                                        </div>
                                    @endif
                                    <input type="file" class="custom-file" id="company_logo" name="company_logo" accept=".jpg, .jpeg, .png">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_phone">
                                    {{ ucwords(str_replace('_', ' ', 'company_phone')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company_phone" name="company_phone" value="{{ $setting->company_phone }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_email">
                                    {{ ucwords(str_replace('_', ' ', 'company_email')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="company_email" name="company_email" value="{{ $setting->company_email }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_street">
                                    {{ ucwords(str_replace('_', ' ', 'company_street')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company_street" name="company_street" value="{{ $setting->company_street }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_city_and_province">
                                    {{ ucwords(str_replace('_', ' ', 'company_city_and_province')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company_city_and_province" name="company_city_and_province" value="{{ $setting->company_city_and_province }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="company_country">
                                    {{ ucwords(str_replace('_', ' ', 'company_country')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company_country" name="company_country" value="{{ $setting->company_country }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="currency_id">
                                    {{ ucwords(str_replace('_', ' ', 'main_currency')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="currency_id" name="currency_id" required autofocus>
                                        <option disabled>Select a currency :</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ $currency->id == $setting->currency_id ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $currency->name)) }} -
                                                {{ $currency->symbol }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="thousand_separator">
                                    {{ ucwords(str_replace('_', ' ', 'thousand_separator')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="thousand_separator" name="thousand_separator" value="{{ $setting->thousand_separator }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="decimal_separator">
                                    {{ ucwords(str_replace('_', ' ', 'decimal_separator')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="decimal_separator" name="decimal_separator" value="{{ $setting->decimal_separator }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="locale_string">
                                    {{ ucwords(str_replace('_', ' ', 'locale_string')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="locale_string" name="locale_string" value="{{ $setting->locale_string }}" required>
                                </div>
                            </div>

                            @php $permissionsNeeded = ['setting.store']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
                            @if ($hasAccess)
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#currency_id').select2({
            theme: 'bootstrap',
            placeholder: "Select a currency"
        });
    });
</script>
@endsection
