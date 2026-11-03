@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Kategori: "{{ $category->name }}"</h2>

        <form method="GET" action="{{ route('categories.show', $category) }}" class="row g-2 mt-3">
            <div class="col-md">
                <label for="category-search" class="visually-hidden">Cari judul atau penulis</label>
                <input id="category-search" type="search" name="q" value="{{ $query }}"
                    class="form-control" placeholder="Cari judul buku atau penulis...">
            </div>
            <div class="col-md-auto">
                <label for="category-sort" class="visually-hidden">Urutkan buku</label>
                <select id="category-sort" name="sort" class="form-select">
                    <option value="newest" @selected($sort === 'newest')>Buku terbaru</option>
                    <option value="price_asc" @selected($sort === 'price_asc')>Harga termurah</option>
                    <option value="price_desc" @selected($sort === 'price_desc')>Harga termahal</option>
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        @if ($books->isEmpty())
            <div class="alert alert-info mt-3">
                @if ($query !== '')
                    Tidak ada buku yang cocok dengan pencarian "{{ $query }}" di kategori ini.
                @else
                    Belum ada buku dalam kategori ini.
                @endif
            </div>
        @else
            <div class="row mt-3">
                @foreach ($books as $book)
                    <div class="px-2 col-6 col-md-4 col-lg-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset($book->cover) }}" alt="Card image" class="img-fluid rounded-3"
                                    style="height: 220px; width: 100%; object-fit: cover;">
                                <div class="d-flex gap-2 mt-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i> PDF</p>
                                    <p class="badge">3+</p>
                                </div>
                                <div>
                                    <h5><span style="font-size: 0.8rem" class="text-secondary">{{ $book->writer }}</span>
                                        <br><span style="font-size: 1rem">{{ $book->title }}</span>
                                    </h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp
                                        {{ number_format($book->price, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
