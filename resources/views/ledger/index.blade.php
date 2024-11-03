@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'ledger')) }}
@endsection

@section('content')
    <style>
        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <!-- Form untuk Select2 dan Tanggal -->
                <form action="#" method="POST">
                    @csrf @method('POST')
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Account</label>
                            <select id="account_select" class="form-control select2" name="account_id">
                                <option value="">Select Account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>From</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label>To</label>
                            <?php
                            // Mengatur tanggal hari ini
                            $today = new DateTime();
                            // Menambahkan satu hari
                            $nextDay = $today->modify('+1 day')->format('Y-m-d');
                            ?>
                            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="End Date"
                                value="{{ $nextDay }}">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <div class="btn-group" role="group" aria-label="Button group">
                                <a id="filter_button" class="btn btn-primary text-white">Filter</a>
                                <button type="submit" class="btn btn-secondary text-white">Posting</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" id="ledger_table" width="100%">
                        <thead>
                            <tr>
                                <th class="text-left">{{ ucwords(str_replace('_', ' ', 'date')) }}</th>
                                <th class="text-left">{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                <th class="text-left">{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
                                <th class="text-right">{{ ucwords(str_replace('_', ' ', 'debit')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                <th class="text-right">{{ ucwords(str_replace('_', ' ', 'credit')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                <th class="text-right">{{ ucwords(str_replace('_', ' ', 'balance')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                <th class="text-left">{{ ucwords(str_replace('_', ' ', 'user')) }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#account_select').select2({
            theme: 'bootstrap',
            placeholder: "Select an account"
        });

        // Inisialisasi DataTable tanpa data awal
        var table = $('#ledger_table').DataTable({
            processing: true,
            serverSide: true,
            deferLoading: 0,
            ordering: false, // Nonaktifkan pengurutan otomatis
            ajax: {
                url: "",
                type: "GET",
                data: function(d) {
                    d.account_id = $('#account_select').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                error: function(xhr, error, code) {
                    console.log("Error: " + error);
                }
            },
            columns: [
                { data: 'date', name: 'date' },
                { data: 'code', name: 'code' },
                { data: 'description', name: 'description' },
                {
                    data: 'debit',
                    name: 'debit',
                    class: 'text-right',
                    render: $.fn.dataTable.render.number('{{ $setting->thousand_separator }}', '{{ $setting->decimal_separator }}', 2, '')
                },
                {
                    data: 'credit',
                    name: 'credit',
                    class: 'text-right',
                    render: $.fn.dataTable.render.number('{{ $setting->thousand_separator }}', '{{ $setting->decimal_separator }}', 2, '')
                },
                {
                    data: 'balance',
                    name: 'balance',
                    class: 'text-right',
                    render: $.fn.dataTable.render.number('{{ $setting->thousand_separator }}', '{{ $setting->decimal_separator }}', 2, '')
                },
                { data: 'user', name: 'user' },
            ],
            dom: 'Bfrtip', // Menambahkan elemen tombol ke dalam DOM
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            bPaginate: false,
            bFilter: false,
            bInfo: false
        });

        $('#filter_button').on('click', function() {
            if ($('#account_select').val() && $('#start_date').val() && $('#end_date').val()) {
                var account_id = $('#account_select').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                var baseUrl = `/ledger/data/${account_id}/${start_date}/${end_date}`;
                table.ajax.url(baseUrl).load(); // Mengisi ulang DataTable dengan data baru
            } else {
                alert('Please select an account and specify both start and end dates.');
            }
        });
    });
</script>
@endsection

