@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'view_budget')) }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("budget.index") }}">{{ ucwords(str_replace('_', ' ', 'budget')) }}</a></li>
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

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="account_id">
                                    {{ ucwords(str_replace('_', ' ', 'account')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="account_id" name="account_id" value="{{ $budget->account->code }} | {{ $budget->account->name }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="description">
                                    {{ ucwords(str_replace('_', ' ', 'description')) }}
                                </label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" readonly>{{ $budget->description }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="amount">
                                    {{ ucwords(str_replace('_', ' ', 'amount')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="amount" name="amount" value="{{ number_format($budget->amount, 2, $setting->decimal_separator, $setting->thousand_separator) }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="start_date">
                                    {{ ucwords(str_replace('_', ' ', 'start_date')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $budget->start_date }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="end_date">
                                    {{ ucwords(str_replace('_', ' ', 'end_date')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $budget->end_date }}" readonly>
                                </div>
                            </div>

                            <hr>

                            <!-- Journal Entries Section -->
                            <h5 class="mt-4">Related Journal Entries</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach ($budget->journal_entry as $entry)
                                            <tr>
                                                <td>{{ date('d F Y', strtotime($entry->journal->date)) }}</td>
                                                <td>{{ $entry->journal->code }}</td>
                                                <td>{{ $entry->description }}</td>
                                                <td>
                                                    @php
                                                        if($entry->account->normal_balance == "Debit"){
                                                            $balance = $entry->debit - $entry->credit;
                                                        } else {
                                                            $balance = $entry->credit - $entry->debit;
                                                        }
                                                        $total += $balance;
                                                        echo number_format($balance, 2, $setting->decimal_separator, $setting->thousand_separator);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th colspan="3">Spent</th>
                                            <th>{{ number_format($total, 2, $setting->decimal_separator, $setting->thousand_separator) }}</th>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th colspan="3">Amount</th>
                                            <th>{{ number_format($budget->amount, 2, $setting->decimal_separator, $setting->thousand_separator) }}</th>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th colspan="3">Left</th>
                                            <th>{{ number_format($budget->left, 2, $setting->decimal_separator, $setting->thousand_separator) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
