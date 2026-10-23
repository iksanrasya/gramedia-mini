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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
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
                    <img class="d-block w-100" alt="" src="{{ asset('https://i.pinimg.com/1200x/4b/b2/4f/4bb24fdba484857fe78adfed549439bd.jpg') }}" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="{{ asset('https://i.pinimg.com/1200x/f4/9b/22/f49b2203d1888e9608af88388f92c435.jpg') }}" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="{{ asset('https://digitalsolusigrup.co.id/wp-content/uploads/2025/11/Banner-Web-EBook-Zero-Trust-101-Strategi-Keamanan-Efektif-dari-Serangan-Siber-untuk-Perusahaan.webp') }}" />
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
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0"
                        style="background: linear-gradient(135deg, #fefae0 0%, #a8dede 100%);">
                        <div class="card-body row align-items-center">
                            <div class="col-4"></div>
                            <div class="col-8 text-center" style="color: #0d3b44;">
                                <h2 style="font-weight: bold; margin-bottom: 0;">FICTION</h2>
                                <p style="font-weight: bold; margin: 0 !important; opacity: 0.7;">PACKAGE</p>
                                <div>
                                    Rp <span style="font-size: 2rem; font-weight: bold;"
                                        class="text-warning">49.000</span>
                                    <br>
                                    <span style="font-weight: bold; margin: 0 !important; opacity: 0.7;">/30 Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0"
                        style="background: linear-gradient(135deg, #ffcdd2 0%, #e57373 40%, #7b1fa2 100%);">
                        <div class="card-body row align-items-center">
                            <div class="col-4"></div>
                            <div class="col-8 text-center text-white">
                                <h2 style="font-weight: bold; margin-bottom: 0;">ALL-ACCESS</h2>
                                <p style="font-weight: bold; margin: 0 !important; opacity: 0.8;">PACKAGE</p>
                                <div>
                                    Rp <span style="font-size: 2rem; font-weight: bold;"
                                        class="text-warning">89.000</span>
                                    <br>
                                    <span style="font-weight: bold; margin: 0 !important; opacity: 0.8;">/30 Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0"
                        style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 60%, #0f2027 100%);">
                        <div class="card-body row align-items-center">
                            <div class="col-4"></div>
                            <div class="col-8 text-center text-white">
                                <h2 style="font-weight: bold; margin-bottom: 0;">NON-FICTION</h2>
                                <p style="font-weight: bold; margin: 0 !important; opacity: 0.8;">PACKAGE</p>
                                <div>
                                    Rp <span style="font-size: 2rem; font-weight: bold;"
                                        class="text-warning">79.000</span>
                                    <br>
                                    <span style="font-weight: bold; margin: 0 !important; opacity: 0.8;">/30 Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
            {{-- card 2 --}}
            <div class="col-md-4">
            </div>
        </div>
        {{-- card 3 --}}
        <div class="col-md-4">
        </div>

        {{-- buku terbaru --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark">Buku Baru Dirilis</h2>
            </div>
            <div id="wrapper-slider">

                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://gradienmediatama.com/wp-content/uploads/2025/10/COVER-DEPAN-Ayah-Ini-Arahnya-Ke-Mana-Ya.jpg"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsc19jI8Vx7H36ibGbc-TpqfcPiSjQtYD1nJeuoMTeWN9uCim8O63vzK9A&s=10"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://bukukita.com/babacms/displaybuku/86106_f.jpg"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdCkGfoJNxBI8W2XRcarhZEuqTp8Add5Wjgj4RY3nSMw&s=10"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://cdn.gramedia.com/uploads/items/9789792248616_negeri-5-menara-_cu-cover-baru_.jpg"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://cdn.gramedia.com/uploads/images/1/42420/image_highres/ID_NPB2018MTH05NPB.jpg"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFUoxjYBRKaffstrV4AZRIU--Gz_8z53mHT0-sKs2DCzeb2OI3P82UxA0&s=10"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://akcdn.detik.net.id/community/media/visual/2020/03/10/f5cba788-9277-4367-bc52-e96e0a4e76e4.jpeg?q=90&w=480"
                                class="d-block mx-auto w-75 h-50">
                            <div class="d-flex gap-2 mt-2">
                                <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                <p class="badge">3+</p>
                            </div>
                            <div>
                                <h5><span style="font-size: 0.8rem" class="text-secondary">mr. Ridho</span>
                                    <br><span style="font-size: 1rem">Card With Title</span>
                                </h5>
                                <h4 style="font-size: 1.2rem; font-weight: bold">Rp 80.000</h4>
                            </div>
                        </div>
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                    <div class="px-2">
                    </div>
                </div>
            </div>
        </div>

        {{-- buku gratis --}}

        <div class="mt-4">
            {{-- judul --}}
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">buku gratis</h2>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        JS karen
                                        <br><span class="text-dark">MELANGKAH</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-4">
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="a">
                                    <img src="https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Manokwari/o/1748392386101-9786020523316_Melangkah_UV_Spot_R4-1/1snmknq0fdzpi7v.jpeg"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i></div>
                                    </h3>
                                    <div class="text-secondary">
                                        penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="card-title">
                                            <span style="color: red; text-decoration: line-through;">Rp.999.000</span>
                                            <span class="text-dark"> Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
