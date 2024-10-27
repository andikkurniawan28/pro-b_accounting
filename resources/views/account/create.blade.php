@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'create_account')) }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("account.index") }}">{{ ucwords(str_replace('_', ' ', 'account')) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield("title")</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("account.store") }}" method="POST">
                            @csrf
                            @method("POST")

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="account_group_id">
                                    {{ ucwords(str_replace('_', ' ', 'account_group')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="account_group_id" name="account_group_id" required autofocus>
                                        <option disabled selected>Select an account group:</option>
                                        @foreach ($account_groups as $account_group)
                                            <option value="{{ $account_group->id }}">{{ ucwords(str_replace('_', ' ', $account_group->name)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="name">
                                    {{ ucwords(str_replace('_', ' ', 'name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old("name") }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="normal_balance">
                                    {{ ucwords(str_replace('_', ' ', 'normal_balance')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="normal_balance" name="normal_balance" required>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                    </select>
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

@section('additional_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#account_group_id').select2({
            theme: 'bootstrap',
            placeholder: "Select an account group"
        });
    });
</script>
@endsection
