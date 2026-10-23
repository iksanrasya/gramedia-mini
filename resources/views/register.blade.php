@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register.store') }}" class="form-fieldset w-50 d-block mx-auto mt-5">
    {{-- token : kunci agar data di form bisa diambil controller --}}
    @csrf
    <legend class="form-label">REGISTER</legend>
    <div class="mb-3">
        <label class="form-label required" for="fieldset-name">nama lengkap</label>
        <input type="text" id="fieldset-name" class="form-control" @error('name') is-invalid @enderror
        autocomplete="name" required name="name" />
        {{-- munculin error validasi : @error('name_input') --}}
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
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
    <button type="submit" class="btn-primary">Kirim</button>
</form>
@endsection
