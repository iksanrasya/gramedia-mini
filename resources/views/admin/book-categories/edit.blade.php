@extends('layouts.app')
@section('content')
    <div class="card mt-5 w-50 d-block mx-auto">
        <div class="card-header">
            <h1>Edit kategori buku </h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.book-categories.update',$bookCategory->id)}}" method="POST">
                @method('PUT')
                @csrf
                {{-- @scrf untuk mencegah request yang tidak sah --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama kategori</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name',$bookCategory->name)}}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
@endsection