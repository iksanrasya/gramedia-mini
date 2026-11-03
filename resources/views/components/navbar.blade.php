<div>
    <header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl"><button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <!-- BEGIN NAVBAR LOGO -->
            <a href="{{ route('home') }}" aria-label="Ebooks" class="navbar-brand navbar-brand-autodark me-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTfj9hp3HOViAnrg8F47GnaATetdnm8YezaWv_o_dMSjg&s=10"
                    width="110" height="32" alt="Tabler" class="navbar-brand-image"> Ebooks
            </a>
            <!-- END NAVBAR LOGO -->
            {{-- search bar --}}
            <div class="navbar-nav mx-auto w-50 py-2 d-flex flex-row align-items-center gap-2">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/book-categories*') ? 'active' : '' }}">
                        <a href="{{ route('admin.book-categories.index') }}" class="nav-link">Kategori Buku</a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/subscription-packages*') ? 'active' : '' }}">
                        <a href="{{ route('admin.subscription-packages.index') }}" class="nav-link">Paket Langganan</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.books.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.books.index') }}" class="nav-link">Buku</a>
                    </li>
                @else
                    {{-- Kategori --}}
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Kategori
                            </button>

                            <div class="dropdown-menu p-3 shadow"
                                style="width: 840px; max-width: 90vw; border-radius: 12px;">

                                <div class="row row-cols-4 g-2">
                                    @forelse ($navbarCategories as $category)
                                        <div class="col">
                                            <a href="{{ route('categories.show', $category) }}"
                                                class="card h-100 text-decoration-none text-dark shadow-sm">
                                                <div class="card-body text-center py-4">
                                                    {{ $category->name }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-center mb-0">
                                                Belum ada kategori.
                                            </p>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    {{-- search bar --}}
                    <form method="GET" action="{{ route('search') }}" class="input-icon flex-fill py-0">
                        <input type="text" name="q" value="{{ request('q') }}"
                            class="form-control form-control-rounded"
                            placeholder="Cari judul, produk, buku, penulis..." />
                        <button type="submit" class="input-icon-addon btn border-0 p-0 bg-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </button>
                    </form>

                    {{-- icon keranjang --}}
                    <div class="flex-shrink-0">
                        <button class="btn btn-light rounded-circle" type="button" aria-label="Keranjang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" focusable="false">
                                <circle cx="9" cy="19" r="2"></circle>
                                <circle cx="17" cy="19" r="2"></circle>
                                <path d="M3 4h2l2.5 10h9.5l2-7H7"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            {{-- button login --}}
            <div class="flex-row order-md-last ms-auto">
                @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Daftar</a>
                @endif
            </div>
        </div>
    </header>
</div>
