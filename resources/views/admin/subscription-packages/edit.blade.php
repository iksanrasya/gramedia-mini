@extends('layouts.app')
@section('content')
    <div class="container py-5">

    <h2 class="fw-bold mb-4">
        Edit Paket Langganan
    </h2>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('admin.subscription-packages.update', $package->id) }}"
                method="POST">

                @csrf
                @method('PUT')


                {{-- Nama Paket --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nama Paket Langganan
                    </label>

                    <input
                        type="text"
                        name="name_package"
                        class="form-control"
                        value="{{ old('name_package', $package->name_package) }}"
                        required>

                </div>


                {{-- Harga --}}
                <div class="mb-3">

                    <label class="form-label">
                        Harga
                    </label>

                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        value="{{ old('price', $package->price) }}"
                        min="0"
                        required>

                </div>


                {{-- Warna --}}
                <div class="mb-3">

                    <label class="form-label">
                        Warna
                    </label>

                    <input
                        type="color"
                        name="color"
                        class="form-control form-control-color"
                        value="{{ old('color', $package->color) }}"
                        required>

                    <small class="text-muted">
                        Klik kotak warna untuk mengganti warna.
                    </small>

                </div>


                {{-- Deskripsi --}}
                <div class="mb-3">

                    <label class="form-label">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4">{{ old('description', $package->description) }}</textarea>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan Perubahan

                </button>


                <a
                    href="{{ route('admin.subscription-packages.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>
@endsection