@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'income_statement')) }}
@endsection

@section('content')
    <style>
        .table th, .table td {
            width: 33.33%; /* Membagi lebar kolom menjadi 3 bagian yang sama */
            text-align: center; /* Mengatur teks agar rata tengah */
        }
    </style>
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf @method('POST')
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Period</label>
                            <input type="month" id="period" name="period" class="form-control"
                                value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m') }}">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <div class="btn-group" role="group" aria-label="Button group">
                                <a id="filter_button" class="btn btn-primary text-white">Filter</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'revenues')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="revenues-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="revenues-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-revenues">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'expenses')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="expenses-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="expenses-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-expenses">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'cost_of_goods_sold')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="cogs-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="cogs-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-cogs">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'other_income')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="other_income-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="other_income-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-other_income">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'other_expense')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="other_expense-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="other_expense-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-other_expense">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'profit')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="profit-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="profit-body">
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_gross_profits')) }}</td>
                                        <td id="total-gross_profit">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_operating_profit')) }}</td>
                                        <td id="total-operating_profit">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_net_profit')) }}</td>
                                        <td id="total-net_profit">0</td>
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

@section('additional_script')
<script>
    $(document).ready(function() {
        $('#filter_button').on('click', function() {
            var period = $('#period').val();
            var yearMonth = period.split('-'); // Split year and month
            var year = yearMonth[0];
            var month = yearMonth[1];

            $.ajax({
                url: "{{ route('income_statement.data', ['year' => ':year', 'month' => ':month']) }}".replace(':year', year).replace(':month', month),
                method: 'GET',
                success: function(response) {
                    // Clear previous data
                    $('#revenues-body').empty();
                    $('#expenses-body').empty();
                    $('#cogs-body').empty();
                    $('#other_income-body').empty();
                    $('#other_expense-body').empty();

                    // Populate revenues table
                    response.revenues.forEach(function(revenue) {
                        $('#revenues-body').append(`
                            <tr>
                                <td>${revenue.code}</td>
                                <td>${revenue.name}</td>
                                <td>${revenue.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-revenues').text(response.totals.revenues);

                    // Populate expenses table
                    response.expenses.forEach(function(expense) {
                        $('#expenses-body').append(`
                            <tr>
                                <td>${expense.code}</td>
                                <td>${expense.name}</td>
                                <td>${expense.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-expenses').text(response.totals.expenses);

                    // Populate cogs table
                    response.cogs.forEach(function(cog) {
                        $('#cogs-body').append(`
                            <tr>
                                <td>${cog.code}</td>
                                <td>${cog.name}</td>
                                <td>${cog.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-cogs').text(response.totals.cogs);

                    // Populate other revenues table
                    response.other_income.forEach(function(otherRevenue) {
                        $('#other_income-body').append(`
                            <tr>
                                <td>${otherRevenue.code}</td>
                                <td>${otherRevenue.name}</td>
                                <td>${otherRevenue.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-other_income').text(response.totals.other_income);

                    // Populate other expenses table
                    response.other_expense.forEach(function(otherExpense) {
                        $('#other_expense-body').append(`
                            <tr>
                                <td>${otherExpense.code}</td>
                                <td>${otherExpense.name}</td>
                                <td>${otherExpense.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-other_expense').text(response.totals.other_expense);

                    // Calculate profit totals
                    $('#total-gross_profit').text(response.totals.gross_profit);
                    $('#total-operating_profit').text(response.totals.operating_profit);
                    $('#total-net_profit').text(response.totals.net_profit);
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });
    });
</script>
@endsection
