@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'account')) }}
@endsection

@section('content')
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="manage">
                    @php $permissionsNeeded = ['account.create']; $hasAccess = array_intersect($permissionsNeeded, $setting->list_of_permission); @endphp
                    @if ($hasAccess)
                    <a href="{{ route('account.create') }}" class="btn btn-sm btn-primary">Create</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-hovered" id="account_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ ucwords(str_replace('_', ' ', 'code')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'account_group')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'normal_balance')) }}</th>
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
            $('#account_table').DataTable({
                layout: {
                    bottomStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                    },
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('account.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'account_group_id',
                        name: 'account_group.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'normal_balance',
                        name: 'normal_balance'
                    },
                    {
                        data: null,
                        name: 'actions',
                        render: function(data, type, row) {
                            let actions = '<div class="btn-group" role="group" aria-label="manage">';
                            if (permissions.includes('account.edit')) {
                                actions += `<a href="{{ url('account') }}/${row.id}/edit" class="btn btn-secondary btn-sm">Edit</a>`;
                            }
                            if (permissions.includes('account.destroy')) {
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
                const accountId = $(this).data('id');
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

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
                            action: `{{ url('account') }}/${accountId}`
                        });

                        $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }).appendTo(form);

                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: csrfToken
                        }).appendTo(form);

                        form.appendTo('body').submit();
                    }
                });
            });
        });
    </script>
@endsection
