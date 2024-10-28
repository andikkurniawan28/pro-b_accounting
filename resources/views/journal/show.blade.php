@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'view_journal')) }}
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
                        <div>
                            <button class="btn btn-success" id="print-button">Print</button>
                            <button class="btn btn-primary" id="pdf-button">Convert to PDF</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">
                                {{ ucwords(str_replace('_', ' ', 'code')) }}:
                            </label>
                            <div class="col-sm-10">
                                <span>{{ $journal->code }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">
                                {{ ucwords(str_replace('_', ' ', 'date')) }}:
                            </label>
                            <div class="col-sm-10">
                                <span>{{ date("d-m-Y", strtotime($journal->date)) }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="journal-details-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Account</th>
                                            <th style="width: 25%;">Description</th>
                                            <th style="width: 15%;">Debit</th>
                                            <th style="width: 15%;">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($journal->journal_entry as $detail)
                                        <tr>
                                            <td>{{ $detail->account->name }}</td>
                                            <td>{{ $detail->description }}</td>
                                            <td>{{ number_format($detail->debit, 0) }}</td>
                                            <td>{{ number_format($detail->credit, 0) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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
                                                <span>{{ number_format($journal->journal_entry->sum('debit'), 0) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ number_format($journal->journal_entry->sum('credit'), 0) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('additional_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('print-button').addEventListener('click', function() {
            window.print();
        });

        document.getElementById('pdf-button').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text('Journal Invoice', 14, 20);
            doc.text(`Code: ${{{ $journal->code }}}`, 14, 30);
            doc.text(`Date: ${{{ $journal->date }}}`, 14, 40);

            const columns = ["Account", "Description", "Debit", "Credit"];
            const rows = {{ json_encode($journal->journal_entry->map(function ($detail) {
                return [
                    $detail->account->name,
                    $detail->description,
                    number_format($detail->debit, 0),
                    number_format($detail->credit, 0),
                ];
            })) }};

            doc.autoTable({
                head: [columns],
                body: rows,
            });

            doc.save(`journal_${{{ $journal->code }}}.pdf`);
        });
    </script>
    @endsection
@endsection
