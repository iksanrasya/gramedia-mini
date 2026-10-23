@extends('layouts.app')
@section('content')
    <div class="container-fluid py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Paket Langganan</h2>

            <a href="{{ route('admin.subscription-packages.create') }}" class="btn btn-primary">
                Tambah Paket Langganan
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="subscription-packages-table">
                        <thead class="table-light">
                            <tr>
                                <th>NO</th>
                                <th>NAMA PAKET LANGGANAN</th>
                                <th>HARGA</th>
                                <th>WARNA</th>
                                <th>DESKRIPSI</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#subscription-packages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscription-packages.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_package',
                        name: 'name_package'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'color',
                        name: 'color',
                        render: function(data) {
                            return '<div style="background-color: ' + $('<div>').text(data).html() +
                                '; width: 40px; height: 25px; border: 1px solid #ccc; border-radius: 4px;"></div>';
                        }
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
