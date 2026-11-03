@extends('layouts.app')

@push('styles')
    <style>
        .slick-prev:before,
        .slick-next::before {
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" aria-label="Slide 1"
                    aria-current="true" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt=""
                        src="{{ asset('https://i.pinimg.com/1200x/4b/b2/4f/4bb24fdba484857fe78adfed549439bd.jpg') }}" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="{{ asset('https://i.pinimg.com/1200x/f4/9b/22/f49b2203d1888e9608af88388f92c435.jpg') }}" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="{{ asset('https://i.pinimg.com/1200x/4b/b2/4f/4bb24fdba484857fe78adfed549439bd.jpg') }}" />
                </div>
            </div><button class="carousel-control-prev" type="button" data-bs-target="#carousel-sample"
                data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true">
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-sample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="mt-4">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
                <h2 class="mt-3 text-dark">Paket Langganan</h2>
            </div>
            <div class="row g-4">
                @forelse ($subscriptionPackages as $package)
                    <div class="col-md-4">
                        <a href="{{ route('subscription-packages.show', $package) }}"
                            class="text-decoration-none text-reset">
                            <div class="card h-100 shadow-sm border-0"
                                style="background-color: {{ $package->color }};">
                                <div class="card-body text-center text-dark">
                                    <h2 class="fw-bold">{{ $package->name_package }}</h2>
                                    @if ($package->description)
                                        <p>{{ $package->description }}</p>
                                    @endif
                                    <p class="fs-3 fw-bold mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada paket langganan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- buku terbaru --}}
        <div class="d-flex align-items-center gap-2 mb-4">
            <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Baru Dirilis</h2>
        </div>
        <div id="wrapper-slider">
            @forelse($latestBooks as $book)
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ asset($book->cover) }}" alt="Card image" class="img-fluid rounded-3"
                                style="height: 350px; width: 100%; object-fit: cover;">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">{{ $book->author }}</span>
                                    <br><span style="font-size: 1rem">{{ $book->title }}</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold;">Rp
                                    {{ number_format($book->price, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Tidak ada buku terbaru.</p>
            @endforelse
        </div>


        {{-- buku gratis --}}

        <div class="mt-4">
            {{-- judul --}}
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">buku gratis</h2>
            </div>
            <div class="row">
                @forelse($freeBooks as $book)
                    <div class="col-4">
                        <div class="card d-flex flex-column">
                            <div class="row row-0 flex-fill">
                                <div class="col-md-3">
                                    <a href="#">
                                        <img src="{{ asset($book->cover) }}" class="w-100 h-100 object-cover"
                                            alt="Card side image" />
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="card-body h-full d-flex flex-column">
                                        <h3 class="card-title">
                                            <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                        </h3>
                                        <div class="text-secondary">
                                            Penulis
                                            <br><span class="text-dark">{{ $book->writer }}</span>
                                        </div>
                                        <div class="d-flex align-items-center pt-4 mt-auto">
                                            <h3><span class="text-decoration-line-through text-secondary">Rp 50.000</span>
                                                <span class="text-dark">Rp 0</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada buku gratis.</p>
                @endforelse
            </div>
        @endsection


        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#wrapper-slider').slick({
                        dots: true,
                        infinite: false,
                        speed: 300,
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        responsive: [{
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3,
                                    infinite: true,
                                    dots: true
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                });
            </script>
        @endpush
