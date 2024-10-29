@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'edit_journal')) }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('journal.index') }}">{{ ucwords(str_replace('_', ' ', 'journal')) }}</a></li>
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
                        <form action="{{ route('journal.update', $journal->id) }}" method="POST" id="journal-form">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="code">
                                    {{ ucwords(str_replace('_', ' ', 'code')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" value="{{ $journal->code }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="date">
                                    {{ ucwords(str_replace('_', ' ', 'date')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d', strtotime($journal->date)) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="journal-details-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%;">Account</th>
                                                <th style="width: 30%;">Description</th>
                                                <th style="width: 15%;">Debit</th>
                                                <th style="width: 15%;">Credit</th>
                                                <th style="width: 15%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($journal->journal_entry as $index => $detail)
                                            <tr>
                                                <td>
                                                    <select name="details[{{ $index }}][account_id]" class="form-control select2" required>
                                                        <option disabled>Select an Account:</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}" {{ $account->id == $detail->account_id ? 'selected' : '' }}>{{ $account->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="details[{{ $index }}][description]" class="form-control" placeholder="Description" value="{{ $detail->description }}" required>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                                        </div>
                                                        <input type="text" name="details[{{ $index }}][debit]" class="form-control debit number-separator" step="0.01" value="{{ number_format($detail->debit, 2, $setting->decimal_separator, $setting->thousand_separator) }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                                        </div>
                                                        <input type="text" name="details[{{ $index }}][credit]" class="form-control credit number-separator" step="0.01" value="{{ number_format($detail->credit, 2, $setting->decimal_separator, $setting->thousand_separator) }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>

                                    <button type="button" id="add-row" class="btn btn-success mt-3">Add Row</button>

                                    <div class="table-responsive">
                                    <table class="table table-bordered mt-4">
                                        <thead>
                                            <tr>
                                                <th>Total Debit</th>
                                                <th>Total Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                                        </div>
                                                        <input type="text" id="total-debit" name="debit" class="form-control" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                                        </div>
                                                        <input type="text" id="total-credit" name="credit" class="form-control" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3" id="submit-button" disabled>Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('additional_script')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let rowCount = {{ count($journal->journal_entry) }};

                function initializeSelect2() {
                    $('.select2').select2({
                        placeholder: "Select an Account",
                        theme: 'bootstrap',
                        width: '100%',
                    });
                }

                initializeSelect2();
                updateTotals();

                function updateTotals() {
                    let totalDebit = 0;
                    let totalCredit = 0;

                    // Ambil pemisah dari setting
                    const thousandSeparator = '{{ $setting->thousand_separator }}';
                    const decimalSeparator = '{{ $setting->decimal_separator }}';

                    // Hitung total debit
                    document.querySelectorAll('.debit').forEach(input => {
                        const value = input.value
                            .replace(new RegExp('\\' + thousandSeparator, 'g'), '') // Hapus pemisah ribuan
                            .replace(new RegExp('\\' + decimalSeparator, 'g'), '.'); // Ganti pemisah desimal menjadi titik
                        totalDebit += parseFloat(value) || 0;
                    });

                    // Hitung total kredit
                    document.querySelectorAll('.credit').forEach(input => {
                        const value = input.value
                            .replace(new RegExp('\\' + thousandSeparator, 'g'), '') // Hapus pemisah ribuan
                            .replace(new RegExp('\\' + decimalSeparator, 'g'), '.'); // Ganti pemisah desimal menjadi titik
                        totalCredit += parseFloat(value) || 0;
                    });

                    document.getElementById('total-debit').value = totalDebit.toLocaleString('{{ $setting->locale_string }}');
                    document.getElementById('total-credit').value = totalCredit.toLocaleString('{{ $setting->locale_string }}');

                    document.getElementById('submit-button').disabled = !(totalDebit > 0 && totalDebit === totalCredit);
                }

                document.getElementById('add-row').addEventListener('click', function () {
                    let tableBody = document.querySelector('#journal-details-table tbody');
                    let newRow = `
                        <tr>
                            <td>
                                <select name="details[${rowCount}][account_id]" class="form-control select2" required>
                                    <option disabled selected>Select an Account:</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="details[${rowCount}][description]" class="form-control" placeholder="Description" required>
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                    </div>
                                    <input type="text" name="details[${rowCount}][debit]" class="form-control debit number-separator" step="0.01" value="0" required>
                                </div>
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{ $setting->currency->symbol }}</span>
                                    </div>
                                    <input type="text" name="details[${rowCount}][credit]" class="form-control credit number-separator" step="0.01" value="0" required>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                    initializeSelect2();
                    easyNumberSeparator({
                        selector: '.number-separator',
                        separator: '{{ $setting->thousand_separator }}',
                        decimalSeparator: '{{ $setting->decimal_separator }}',
                    });
                    updateTotals();
                    rowCount++;
                });

                document.querySelector('#journal-details-table tbody').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-row')) {
                        e.target.closest('tr').remove();
                        updateTotals();
                    }
                });

                document.querySelector('#journal-details-table tbody').addEventListener('input', function (e) {
                    if (e.target.classList.contains('debit') || e.target.classList.contains('credit')) {
                        updateTotals();
                    }
                });
            });
        </script>
    @endsection
@endsection
