@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h1 class="mb-4">Daftar Buku</h1>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-4">Tambah Buku</a>
        </div>
        <table class="table table-bordered" id="data-buku">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sampul</th>
                    <th>Judul</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="modal modal-blur fade" id="modalDetailBook" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- header --}}
                <div class="modal-header">
                    <h5 class="modal-title">Detail Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- body --}}
                <div class="modal-body">
                    <div class="row">
                        <!-- Column Cover -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img id="detail-cover" src="" class="rounded shadow-sm border img-fluid"
                                alt="Cover Buku" style="max-height: 300px; width: 100%; object-fit: cover;">
                        </div>
                        <!-- Column Info -->
                        <div class="col-md-8">
                            <h3 id="detail-title" class="mb-1 text-primary fw-bold"></h3>
                            <div class="mb-3">
                                <span id="detail-category" class="badge bg-blue-lt"></span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pt-2">Harga</div>
                                    <div class="text-success fw-bold" id="detail-price"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Penulis</div>
                                    <div class="text-dark" id="detail-writer"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Penerbit</div>
                                    <div class="text-dark" id="detail-publisher"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Bahasa</div>
                                    <div class="text-dark" id="detail-language"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Tanggal Rilis</div>
                                    <div class="text-dark" id="detail-release"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-2">Jumlah Halaman</div>
                                    <div class="text-dark" id="detail-pages"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div>
                        <h4 class="subheader mb-2">Deskripsi Buku</h4>
                        <div id="detail-description" class="p-3 bg-body-tertiary rounded border"
                            style="max-height: 200px; overflow-y: auto;">
                            <span class="text-secondary">Tidak ada deskripsi.</span>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer"><a href="#" class="btn btn-link link-secondary"
                        data-bs-dismiss="modal">tutup</a><a href="#" class="btn btn-primary ms-auto"
                        data-bs-dismiss="modal"> <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon">
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg> Create new report </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-***"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#data-buku').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
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

        $('#data-buku').on('click', '#btn-detail', function() {
            const btn = $(this);

            // Ambil data dari data-* attributes
            const cover = btn.attr('data-cover');
            const title = btn.attr('data-title');
            const category = btn.attr('data-category');
            const price = btn.attr('data-price');
            const writer = btn.attr('data-writer');
            const publisher = btn.attr('data-publisher');
            const language = btn.attr('data-language');
            const release = btn.attr('data-release-date');
            const pages = btn.attr('data-page-of-book');
            const description = btn.attr('data-description');

            // Isi elemen Modal
            $('#detail-cover').attr('src', cover);
            $('#detail-title').text(title);
            $('#detail-category').text(category);
            $('#detail-price').text('Rp ' + Number(price).toLocaleString('id-ID'));
            $('#detail-writer').text(writer);
            $('#detail-publisher').text(publisher);
            $('#detail-language').text(language);
            $('#detail-release').text(release);
            $('#detail-pages').text(pages + ' halaman');
            $('#detail-description').html(description || 'Tidak ada deskripsi.');

            // Tampilkan Modal
            const modalElement = document.getElementById('modalDetailBook');
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        });
    </script>
@endpush
