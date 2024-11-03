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

                    // Menampilkan data revenues
                    response.revenues.forEach(function(revenue) {
                        $('#revenues-body').append(`
                            <tr>
                                <td>${revenue.code}</td>
                                <td>${revenue.name}</td>
                                <td>${revenue.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-revenues').text(response.totals.revenues); // Total from API response

                    // Menampilkan data expenses
                    response.expenses.forEach(function(expense) {
                        $('#expenses-body').append(`
                            <tr>
                                <td>${expense.code}</td>
                                <td>${expense.name}</td>
                                <td>${expense.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-expenses').text(response.totals.expenses); // Total from API response

                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });
    });
</script>
@endsection
