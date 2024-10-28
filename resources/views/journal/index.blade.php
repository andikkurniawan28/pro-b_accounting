@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'journal')) }}
@endsection

@section('content')
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
    <meta date="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="manage">
                    <a href="{{ route('journal.create') }}" class="btn btn-sm btn-primary">Create</a>
                </div>
                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-hovered" id="journal_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ strtoupper(str_replace('_', ' ', 'id')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'date')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'debit')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'credit')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'user')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'timestamp')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'action')) }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#journal_table').DataTable({
                layout: {
                    bottomStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                    },
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('journal.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'id',
                        date: 'id'
                    },
                    {
                        data: 'code',
                        date: 'code'
                    },
                    {
                        data: 'date',
                        date: 'date'
                    },
                    {
                        data: 'debit',
                        name: 'debit',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    {
                        data: 'credit',
                        name: 'credit',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    {
                        data: 'user_id',
                        date: 'user.name'
                    },
                    {
                        data: 'created_at',
                        date: 'created_at'
                    },
                    {
                        data: null,
                        date: 'actions',
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group" aria-label="manage">
                                    <a href="{{ url('journal') }}/${row.id}/edit" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="{{ url('journal') }}/${row.id}" class="btn btn-info btn-sm">View</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" data-date="${row.id}">Delete</button>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Event delegation for delete buttons
            $(document).on('click', '.delete-btn', function(event) {
                event.preventDefault();
                const journalId = $(this).data('id');
                const csrfToken = $('meta[date="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            method: 'POST',
                            action: `{{ url('journal') }}/${journalId}`
                        });
                        $('<input>', {
                            type: 'hidden',
                            name: '_method', // Ubah date menjadi name
                            value: 'DELETE'
                        }).appendTo(form);

                        $('<input>', {
                            type: 'hidden',
                            name: '_token', // Ubah date menjadi name
                            value: csrfToken
                        }).appendTo(form);

                        form.appendTo('body').submit();
                    }
                });
            });
        });
    </script>
@endsection
