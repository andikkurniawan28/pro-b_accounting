@extends('template.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'activity_log')) }}
@endsection

@section('content')
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="manage">
                </div>
                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-hovered" id="activity_log_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ ucwords(str_replace('_', ' ', 'timestamp')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'user')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
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
            $('#activity_log_table').DataTable({
                layout: {
                    bottomStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                    },
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('activity_log.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'user_id',
                        name: 'user.name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                ]
            });
        });
    </script>
@endsection
