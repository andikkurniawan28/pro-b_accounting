@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'cash_flow')) }}
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
                            <h4>{{ ucwords(str_replace('_', ' ', 'operating')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="operating-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="operating-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-operating">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'investing')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="investing-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="investing-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-investing">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'financing')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="financing-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="financing-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-financing">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'cash_flow')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="cash_flow-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="cash_flow-body">
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_operating')) }}</td>
                                        <td id="total-operating2">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_investing')) }}</td>
                                        <td id="total-investing2">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_financing')) }}</td>
                                        <td id="total-financing2">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_net_cash_flow')) }}</td>
                                        <td id="total-net_cash_flow">0</td>
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
                url: "{{ route('cash_flow.data', ['year' => ':year', 'month' => ':month']) }}".replace(':year', year).replace(':month', month),
                method: 'GET',
                success: function(response) {
                    // Clear previous data
                    $('#operating-body').empty();
                    $('#investing-body').empty();
                    $('#financing-body').empty();

                    // Populate operating table
                    response.operating.forEach(function(operating) {
                        $('#operating-body').append(`
                            <tr>
                                <td>${operating.code}</td>
                                <td>${operating.name}</td>
                                <td>${operating.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-operating').text(response.totals.operating);

                    // Populate investing table
                    response.investing.forEach(function(investing) {
                        $('#investing-body').append(`
                            <tr>
                                <td>${investing.code}</td>
                                <td>${investing.name}</td>
                                <td>${investing.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-investing').text(response.totals.investing);

                    // Populate financing table
                    response.financing.forEach(function(financing) {
                        $('#financing-body').append(`
                            <tr>
                                <td>${financing.code}</td>
                                <td>${financing.name}</td>
                                <td>${financing.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-financing').text(response.totals.financing);

                    // Calculate cash_flow totals
                    $('#total-operating2').text(response.totals.operating);
                    $('#total-investing2').text(response.totals.investing);
                    $('#total-financing2').text(response.totals.financing);
                    $('#total-net_cash_flow').text(response.totals.net_cash_flow);
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });
    });
</script>
@endsection
