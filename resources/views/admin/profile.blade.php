@extends('admin.layout')

@section('content')
<style>
    .profile-card {
        max-width: 480px;
        margin: 40px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(99,102,241,0.08);
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .profile-avatar {
        width: 90px; height: 90px;
        border-radius: 50%;
        background: rgb(0, 119, 62);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.8rem; color: #fff;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(56,178,172,0.12);
    }
    .profile-label { font-weight: 500; color: rgb(0, 119, 62); margin-bottom: 4px; }
    .profile-value { font-size: 1.08rem; color: #23272f; font-weight: 500; margin-bottom: 16px; }
</style>
<div class="profile-card">
    <div class="profile-avatar mb-2">
        <i class="fa fa-user"></i>
    </div>
    <div class="mb-2 w-100 text-center">
        <div class="profile-label">Nama Admin</div>
        <div class="profile-value">{{ $admin->name }}</div>
    </div>
    <div class="mb-2 w-100 text-center">
        <div class="profile-label">Email</div>
        <div class="profile-value">{{ $admin->email }}</div>
    </div>
</div>
@endsection