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
                    @php $permissionsNeeded = ['journal.create']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
                    @if ($hasAccess)
                    <a href="{{ route('journal.create') }}" class="btn btn-sm btn-primary">Create</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-hovered" id="journal_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ strtoupper(str_replace('_', ' ', 'id')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'date')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'debit')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
                                <th>{{ ucwords(str_replace('_', ' ', 'credit')) }}<sub>({{ $setting->currency->symbol }})</sub></th>
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
        const permissions = @json($setting->list_of_permission);
        $(document).ready(function() {
            $('#journal_table').DataTable({
                dom: 'Bfrtip', // Menambahkan elemen tombol ke dalam DOM
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
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
                        render: $.fn.dataTable.render.number('{{ $setting->thousand_separator }}', '{{ $setting->decimal_separator }}', 2, '')
                    },
                    {
                        data: 'credit',
                        name: 'credit',
                        render: $.fn.dataTable.render.number('{{ $setting->thousand_separator }}', '{{ $setting->decimal_separator }}', 2, '')
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
                        name: 'actions',
                        render: function(data, type, row) {
                            let actions = '<div class="btn-group" role="group" aria-label="manage">';
                            if (permissions.includes('journal.edit')) {
                                actions += `<a href="{{ url('journal') }}/${row.id}/edit" class="btn btn-secondary btn-sm">Edit</a>`;
                            }
                            if (permissions.includes('journal.show')) {
                                actions += `<a href="{{ url('journal') }}/${row.id}" class="btn btn-info btn-sm" target="_blank">View</a>`;
                            }
                            if (permissions.includes('journal.destroy')) {
                                actions += `<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" data-name="${row.id}">Delete</button>`;
                            }
                            actions += '</div>';
                            return actions;
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
