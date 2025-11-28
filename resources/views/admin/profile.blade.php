@extends('admin.layout')

@section('content')
<style>
.profile-fullpage {
    max-width: 900px;
    margin: 24px auto 0 auto;
    padding: 0 16px;
}
.profile-header-row {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 18px;
}
.profile-header-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.profile-initial {
    width: 54px; height: 54px;
    border-radius: 50%;
    background: #0b5b57;
    color: #fff;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    box-shadow: 0 2px 8px #0b5b5733;
}
.profile-header-info .profile-name {
    font-weight: 700;
    font-size: 1.08rem;
    color: #222;
    letter-spacing: .2px;
}
.profile-header-info .profile-email {
    font-size: 0.98rem;
    color: #0b5b57;
    font-weight: 500;
}
.profile-header-info .profile-role {
    color: #0b5b57;
    font-size: 0.95rem;
    font-weight: 500;
}
.profile-gender-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
    align-items: center;
}
.profile-gender-row label {
    font-weight: 600;
    color: #0b5b57;
    margin-right: 8px;
    font-size: 0.98rem;
}
.profile-gender-row .form-check {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-right: 10px;
}
.profile-form-row {
    display: flex;
    gap: 14px;
    margin-bottom: 8px;
}
.profile-form-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.profile-form-col label {
    font-weight: 600;
    color: #0b5b57;
    margin-bottom: 2px;
    font-size: 0.98rem;
}
.profile-form-col input {
    background: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-radius: 7px;
    padding: 5px 10px;
    font-size: 0.95rem;
    color: #222;
}
.profile-form-col input:disabled {
    background: #f3f3f3;
    color: #888;
}
@media (max-width: 900px) {
    .profile-fullpage {
        padding: 0 4px;
    }
    .profile-header-row {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    .profile-form-row {
        flex-direction: column;
        gap: 8px;
    }
    .profile-initial {
        width: 38px; height: 38px;
        font-size: 1rem;
    }
}
</style>

<div class="profile-fullpage">
    <div class="profile-header-row">
        <div class="profile-initial">
            {{ strtoupper(substr($admin->name,0,1)) }}
        </div>
        <div class="profile-header-info">
            <div class="profile-name">{{ $admin->name }}</div>
            <div class="profile-email">{{ $admin->email }}</div>
        </div>
        
    </div>
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
@endsection
