@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'create_journal')) }}
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
                        <form action="{{ route('journal.store') }}" method="POST" id="journal-form">
                            @csrf
                            @method('POST')

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="code">
                                    {{ ucwords(str_replace('_', ' ', 'code')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" value="{{ $code }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="date">
                                    {{ ucwords(str_replace('_', ' ', 'date')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
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
                                            <tr>
                                                <td>
                                                    <select name="details[0][account_id]" class="form-control select2" required>
                                                        <option disabled selected>Select an Account:</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="details[0][description]" class="form-control" placeholder="Description" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[0][debit]" class="form-control debit" step="0.01" value="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[0][credit]" class="form-control credit" step="0.01" value="0" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <button type="button" id="add-row" class="btn btn-success mt-3">Add Row</button>

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
                                                    <input type="text" id="total-debit" name="debit" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" id="total-credit" name="credit" class="form-control" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-primary mt-3" id="submit-button" disabled>Save</button>
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
                let rowCount = 1;

                function initializeSelect2() {
                    $('.select2').select2({
                        placeholder: "Select an Account",
                        theme: 'bootstrap',
                        width: '100%',
                    });
                }

                initializeSelect2();

                function updateTotals() {
                    let totalDebit = 0;
                    let totalCredit = 0;
                    document.querySelectorAll('.debit').forEach(input => totalDebit += parseFloat(input.value) || 0);
                    document.querySelectorAll('.credit').forEach(input => totalCredit += parseFloat(input.value) || 0);
                    document.getElementById('total-debit').value = totalDebit.toFixed(2);
                    document.getElementById('total-credit').value = totalCredit.toFixed(2);
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
                                <input type="number" name="details[${rowCount}][debit]" class="form-control debit" step="0.01" value="0" required>
                            </td>
                            <td>
                                <input type="number" name="details[${rowCount}][credit]" class="form-control credit" step="0.01" value="0" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                    initializeSelect2();
                    rowCount++;
                    updateTotals();
                });

                document.querySelector('#journal-details-table').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-row')) {
                        e.target.closest('tr').remove();
                        updateTotals();
                    }
                });

                document.querySelector('#journal-details-table').addEventListener('input', function (e) {
                    if (e.target.classList.contains('debit') || e.target.classList.contains('credit')) {
                        updateTotals();
                    }
                });

                updateTotals();
            });
        </script>
    @endsection
@endsection
