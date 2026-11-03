@extends('layouts.app')

@push('styles')
    <style>
        .subscription-package-page {
            min-height: calc(100vh - 62px);
            background-color: #f5f6fa;
        }

        .subscription-package-summary,
        .subscription-package-book {
            border: 1px solid #e8eaf0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgb(24 36 51 / 8%);
        }

        .subscription-package-summary {
            padding: 24px;
        }

        .subscription-package-search {
            max-width: 300px;
        }

        .subscription-package-books {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 180px));
            gap: 14px;
        }

        .subscription-package-book {
            overflow: hidden;
        }

        .subscription-package-book-cover {
            display: block;
            width: 100%;
            height: 265px;
            object-fit: cover;
        }

        .subscription-package-book-details {
            padding: 16px;
        }

        @media (max-width: 575.98px) {
            .subscription-package-summary {
                padding: 20px;
            }

            .subscription-package-books {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .subscription-package-book-cover {
                height: auto;
                aspect-ratio: 2 / 3;
            }
        }
    </style>
@endpush

@section('content')
    <div class="subscription-package-page py-4">
        <div class="container-xl">
            <a href="{{ route('home') }}" class="text-decoration-none d-inline-block mb-4">Kembali</a>

            <section class="card subscription-package-summary mb-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h1 class="h4 fw-semibold mb-2">Paket Langganan : {{ $subscriptionPackage->name_package }}</h1>
                        @if ($subscriptionPackage->description)
                            <p class="text-secondary mb-2">{{ $subscriptionPackage->description }}</p>
                        @endif
                        <p class="text-secondary mb-0">
                            Rp {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <button type="button" class="btn btn-primary px-4 py-3 fw-semibold">
                        Langganan Sekarang
                    </button>
                </div>
            </section>

            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mt-4 mb-3">
                <h2 class="h3 fw-semibold mb-0">Daftar Buku</h2>
                <form method="GET" action="{{ route('subscription-packages.show', $subscriptionPackage) }}"
                    class="subscription-package-search">
                <label for="package-book-search" class="visually-hidden">Cari judul buku</label>
                <div class="input-group">
                    <input id="package-book-search" type="search" name="q" value="{{ $query }}"
                        class="form-control" placeholder="Cari judul buku...">
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                </div>
                </form>
            </div>

            @if ($packageBooks->isEmpty())
                <div class="alert alert-info">
                    @if ($query !== '')
                        Tidak ada buku dengan judul "{{ $query }}" dalam paket ini.
                    @else
                        Belum ada buku yang tertaut pada paket ini.
                    @endif
                </div>
            @else
                <div class="subscription-package-books">
                    @foreach ($packageBooks as $packageBook)
                        <article class="card subscription-package-book">
                            <img src="{{ asset($packageBook->book->cover) }}" alt="{{ $packageBook->book->title }}"
                                class="subscription-package-book-cover">
                            <div class="subscription-package-book-details">
                                <span class="badge bg-azure-lt text-azure mb-2">PDF</span>
                                <p class="text-secondary small mb-1">{{ $packageBook->book->writer }}</p>
                                <h2 class="h4 fw-semibold mb-0">{{ $packageBook->book->title }}</h2>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
