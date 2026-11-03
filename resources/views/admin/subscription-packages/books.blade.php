@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Buku dalam Paket Langganan: {{ $subscriptionPackage->name_package }}</h2>
            <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-secondary"> Kembali </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="addBooksForm" action="{{ route('admin.subscription-packages-books.store', $subscriptionPackage->id) }}"
            method="POST">
            @csrf
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Daftar Buku</span>
                    <input type="hidden" name="book_ids" id="bookIdsInput" value="">
                    <button type="submit" id="btnSubmitBooks" class="btn btn-primary d-none">
                        <i class="fas fa-plus me-1"></i> Tambah ke Paket Langganan (<span id="selectedCount">0</span>)
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="booksTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Cover</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#booksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscription-packages-books', $subscriptionPackage->id) }}",
                columns: [{
                        // data null agar data yang diambil oleh render function, seluruh data dari baris yang diproses, bukan hanya data dari satu kolom
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        // menentukan output pada column ini, yaitu checkbox dengan value id buku
                        render: function(data) {
                            if (data['checkAdded'] === 'Ya') {
                                return ''; // Jika buku sudah ditambahkan, tidak menampilkan checkbox
                            }
                            // Tampilkan checkbox jika buku belum ditambahkan
                            return `<input type="checkbox" name="book_ids[]" value="${data.id}" class="book-checkbox">`;
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'cover',
                        name: 'cover',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function updateButtonVisibility() {
                let checkedCount = $('.book-checkbox:checked').length;
                $('#selectedCount').text(checkedCount);

                if (checkedCount > 0) {
                    $('#btnSubmitBooks').removeClass('d-none');
                } else {
                    $('#btnSubmitBooks').addClass('d-none');
                }
            }

            $('#booksTable tbody').on('change', '.book-checkbox', function() {
                updateButtonVisibility();
            });
        });
    </script>
@endpush
