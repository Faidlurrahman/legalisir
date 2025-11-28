@extends('admin.layout')

@section('content')
<style>
.profile-main-card {
    display: flex;
    gap: 38px;
    max-width: 820px;
    margin: 40px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(44,62,80,0.07);
    padding: 38px 38px 28px 38px;
    align-items: flex-start;
}
.profile-sidebar {
    width: 180px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.profile-initial {
    width: 74px; height: 74px;
    border-radius: 50%;
    background: #0b5b57;
    color: #fff;
    font-size: 2.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px #0b5b5733;
}
.profile-name {
    font-weight: 700;
    font-size: 1.15rem;
    color: #222;
    letter-spacing: .2px;
    text-align: center;
}
.profile-main-content {
    flex: 1;
}
.profile-main-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0b5b57;
    margin-bottom: 22px;
    letter-spacing: .2px;
    text-align: left;
}
.profile-gender-row {
    display: flex;
    gap: 18px;
    margin-bottom: 24px;
    align-items: center;
}
.profile-gender-row label {
    font-weight: 600;
    color: #0b5b57;
    margin-right: 10px;
}
.profile-gender-row .form-check {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-right: 18px;
}
.profile-form-row {
    display: flex;
    gap: 32px;
    margin-bottom: 18px;
}
.profile-form-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.profile-form-col label {
    font-weight: 600;
    color: #0b5b57;
    margin-bottom: 6px;
}
.profile-form-col input {
    background: #f8f9fa;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 1rem;
    color: #222;
}
.profile-form-col input:disabled {
    background: #f3f3f3;
    color: #888;
}
@media (max-width: 900px) {
    .profile-main-card {
        flex-direction: column;
        padding: 22px 10px 18px 10px;
        max-width: 100%;
        gap: 18px;
    }
    .profile-sidebar {
        width: 100%;
        margin-bottom: 12px;
    }
}
</style>

<div class="profile-main-card">
    <!-- Sidebar: Logo & Nama -->
    <div class="profile-sidebar">
        <div class="profile-initial">
            {{ strtoupper(substr($admin->name,0,1)) }}
        </div>
        <div class="profile-name">{{ $admin->name }}</div>
        <div style="font-size:0.98rem; color:#0b5b57; margin-bottom:18px; text-align:center;">
            {{ $admin->email }}
        </div>
    </div>
    <!-- Main Content: Informasi -->
    <div class="profile-main-content">
        <h3>Informasi Pribadi</h3>
        <form>
            <div class="profile-gender-row">
                <label>Jenis Kelamin:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" disabled {{ $admin->jenis_kelamin == 'L' ? 'checked' : '' }}>
                    <label class="form-check-label" style="margin-bottom:0;">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" disabled {{ $admin->jenis_kelamin == 'P' ? 'checked' : '' }}>
                    <label class="form-check-label" style="margin-bottom:0;">Perempuan</label>
                </div>
            </div>
            <div class="profile-form-row">
                <div class="profile-form-col">
                    <label>Nama</label>
                    <input type="text" value="{{ $admin->name }}" disabled>
                    <label>Email</label>
                    <input type="text" value="{{ $admin->email }}" disabled>
                    <label>No. Telepon</label>
                    <input type="text" value="{{ $admin->no_telepon ?? '-' }}" disabled>
                </div>
                <div class="profile-form-col">
                    <label>Tanggal Lahir</label>
                    <input type="text" value="{{ $admin->tanggal_lahir ? \Carbon\Carbon::parse($admin->tanggal_lahir)->format('d M, Y') : '-' }}" disabled>
                    <label>Alamat</label>
                    <input type="text" value="{{ $admin->alamat ?? '-' }}" disabled>
                    <label>NIP</label>
                    <input type="text" value="{{ $admin->nip ?? '-' }}" disabled>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
