@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'balance_sheet')) }}
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
                            <h4>{{ ucwords(str_replace('_', ' ', 'assets')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="assets-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="assets-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-assets">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'equities')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="equities-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="equities-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-equities">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'liabilities')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="liabilities-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="liabilities-body">
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th id="total-liabilities">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <h4>{{ ucwords(str_replace('_', ' ', 'imbalance')) }}</h4>
                            <table class="table table-sm table-hover table-bordered" width="100%" id="imbalance-table">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
                                        <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                    </tr>
                                </thead>
                                <tbody id="imbalance-body">
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_assets')) }}</td>
                                        <td id="total-activa">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_liabilities')) }}</td>
                                        <td id="total-liabilities2">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_equities')) }}</td>
                                        <td id="total-equities2">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_liabilities_+_equities')) }}</td>
                                        <td id="total-passiva">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', 'total_imbalance')) }}</td>
                                        <td id="total-imbalance">0</td>
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
                url: "{{ route('balance_sheet.data', ['year' => ':year', 'month' => ':month']) }}".replace(':year', year).replace(':month', month),
                method: 'GET',
                success: function(response) {
                    // Clear previous data
                    $('#assets-body').empty();
                    $('#liabilities-body').empty();
                    $('#equities-body').empty();

                    // Menampilkan data assets
                    response.assets.forEach(function(asset) {
                        $('#assets-body').append(`
                            <tr>
                                <td>${asset.code}</td>
                                <td>${asset.name}</td>
                                <td>${asset.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-assets').text(response.totals.assets); // Total from API response

                    // Menampilkan data liabilities
                    response.liabilities.forEach(function(liability) {
                        $('#liabilities-body').append(`
                            <tr>
                                <td>${liability.code}</td>
                                <td>${liability.name}</td>
                                <td>${liability.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-liabilities').text(response.totals.liabilities); // Total from API response

                    // Menampilkan data equities
                    response.equities.forEach(function(equity) {
                        $('#equities-body').append(`
                            <tr>
                                <td>${equity.code}</td>
                                <td>${equity.name}</td>
                                <td>${equity.balance}</td>
                            </tr>
                        `);
                    });
                    $('#total-equities').text(response.totals.equities); // Total from API response

                    // Menampilkan data imbalance
                    $('#total-activa').text(response.totals.assets);
                    $('#total-passiva').text(response.totals.passiva);
                    $('#total-imbalance').text(response.totals.imbalance);
                    $('#total-liabilities2').text(response.totals.liabilities); // Total from API response
                    $('#total-equities2').text(response.totals.equities); // Total from API response

                    // Update the sum of the imbalance total
                    // $('#total-imbalance-sum').text(parseFloat(response.totals.assets) + parseFloat(response.totals.passiva) + parseFloat(response.totals.imbalance));
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });
    });
</script>
@endsection
