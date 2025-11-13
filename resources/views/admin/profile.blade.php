@extends('admin.layout')

@section('content')
<style>
    .profile-container {
        max-width: 880px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .profile-header {
        background: #0b5b57; /* hijau layout */
        color: #fff;
        padding: 14px 20px;
        font-size: 1.2rem;
        font-weight: 600;
        border-bottom: 3px solid #0e736e; /* hijau layout */
    }

    .profile-body {
        display: flex;
        flex-wrap: wrap;
        padding: 24px 30px;
        background: #f9fafb;
    }

    .profile-left {
        flex: 0 0 240px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* 1. Ganti gambar profile ke inisial admin, latar oranye */
    .profile-initial {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f7a61c;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 auto 10px auto;
        border: 3px solid #f7a61c;
        user-select: none;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .profile-left h4 {
        margin-top: 12px;
        font-size: 1.1rem;
        color: #212529;
        font-weight: 600;
    }

    .profile-left small {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .profile-right {
        flex: 1;
        padding-left: 30px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 10px 8px;
        vertical-align: top;
        font-size: 0.98rem;
    }

    .info-label {
        color: #0b5b57; /* hijau layout */
        font-weight: 600;
        width: 32%;
    }

    .info-value {
        color: #212529;
        font-weight: 500;
    }

    @media(max-width: 768px) {
        .profile-body {
            flex-direction: column;
            padding: 18px;
        }
        .profile-left {
            flex: 1 1 100%;
        }
        .profile-right {
            padding-left: 0;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        Informasi Admin
    </div>

    <div class="profile-body">
        <div class="profile-left">
            <div class="profile-initial">
                {{ strtoupper(substr(session('admin_name', 'A'),0,1)) }}
            </div>
            <h4>{{ strtoupper($admin->name) }}</h4>
            <small>{{ $admin->email }}</small>
        </div>

        <div class="profile-right">
            <table class="info-table">
                <tr>
                    <td class="info-label">ID Pengguna</td>
                    <td class="info-value">{{ $admin->id }}</td>
                </tr>
                <tr>
                    <td class="info-label">NIP</td>
                    <td class="info-value">{{ $admin->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tempat Lahir</td>
                    <td class="info-value">{{ $admin->tempat_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanggal Lahir</td>
                    <td class="info-value">
                        {{ $admin->tanggal_lahir ? \Carbon\Carbon::parse($admin->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Jenis Kelamin</td>
                    <td class="info-value">
                        @if($admin->jenis_kelamin == 'L') Laki-laki
                        @elseif($admin->jenis_kelamin == 'P') Perempuan
                        @else - @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">No Telepon</td>
                    <td class="info-value">{{ $admin->no_telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Email</td>
                    <td class="info-value">{{ $admin->email }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
