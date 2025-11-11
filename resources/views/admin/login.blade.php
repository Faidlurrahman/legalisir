@php($isLoginPage = true)
@extends('admin.layouts.app')
@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100" style="background: #d2f6f6;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #4fd1c5 60%, #b2f7ef 100%);">
                        <div class="text-center w-100">
                            <h4 class="fw-bold text-white mt-4">Selamat Datang</h4>
                            <img src="https://img.icons8.com/ios-filled/100/38b2ac/combo-chart--v2.png" alt="illustration" class="my-4" style="width:80px;">
                            <p class="text-white mb-4">LEGALISIR AKTA PENDUDUK DISDUKCAPIL KOTA CIREBON</p>
                        </div>
                    </div>
                    <div class="col-md-7 bg-white p-4">
                        <h3 class="fw-bold text-center mb-4" style="color:#38b2ac;">LOGIN</h3>
                        <form method="POST" action="{{ route('admin.login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                            @endif
                            <button type="submit" class="btn w-100 text-white fw-bold" style="background:#38b2ac;">Login</button>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="#" class="small text-decoration-none" style="color:#38b2ac;">Forgot</a>
                                <a href="#" class="small text-decoration-none" style="color:#38b2ac;">Help</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
