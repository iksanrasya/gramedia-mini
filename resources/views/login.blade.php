@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login.store') }}" class="form-fieldset w-50 d-block mx-auto mt-5">
    {{-- munculin notifikasi dari register --}}
    @if(session('success'))
    {{-- tulisan session('success') diambil dari controller UserController.php bagian with --}}
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-- token : kunci agar data di form bisa diambil controller --}}
    @csrf
    <legend class="form-label">LOGIN</legend>
    <div class="mb-3">
        <label class="form-label required" for="fieldset-email">Email</label>
        <input type="email" id="fieldset-email" class="form-control" @error('email') is-invalid @enderror
         autocomplete="email" required name="email" />
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label required" for="fieldset-password ">Password</label>
        <input type="password" id="fieldset-password" class="form-control" @error('password') is-invalid @enderror
         autocomplete="new-password" required name="password" />
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn-primary" style="align-items: center">Kirim</button>
</form>
@endsection
