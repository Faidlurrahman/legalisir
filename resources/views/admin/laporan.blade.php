@extends('admin.layout')  
@section('content')  

<style>
    :root {
        --green: #0b5b57;
        --light-gray: #f8f9fa;
        --border-soft: #e5e7eb;
        --text-dark: #222;
    }

    /* ================= PAGE TITLES ================= */
    .page-title {
        color: var(--green);
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: .3px;
        margin-bottom: 14px;
    }

    /* ================= BUTTON THEME ================= */
    .btn-green {
        background: var(--green) !important;
        border-color: var(--green) !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 8px;
        font-size: 0.97rem;
        padding: 7px 14px;
        transition: background .2s, color .2s;
    }

    .btn-green:hover {
        opacity: .9;
        background: #094d49 !important;
    }

    /* ================= FILTER FORM ================= */
    form.row.g-2 {
        font-size: 0.97rem;
        gap: 8px;
        margin-bottom: 18px;
    }

    .form-select, .form-control {
        font-size: 0.97rem;
        border-radius: 8px;
        padding: 6px 10px;
        height: 32px;
    }

    /* ================= TABLE ================= */
    .table-responsive {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(11,91,87,0.07);
        background: #fff;
        margin-bottom: 18px;
    }

    .table {
        font-size: 0.97rem;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .table th, .table td {
        padding: 8px 6px;
        vertical-align: middle;
        border-color: var(--border-soft) !important;
    }

    .table-header th {
        background: var(--light-gray) !important;
        color: var(--green) !important;
        font-weight: 600;
        text-align: center;
        font-size: 1rem;
        border-bottom: 2px solid var(--green) !important;
    }

    .table tbody tr:first-child {
        background: var(--green) !important;
        color: #fff;
    }

    .alasan-ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 180px;
        font-size: .95rem;
        line-height: 1.3;
        word-break: break-word;
    }

    /* ================= BADGE ================= */
    .badge {
        font-size: 0.95rem;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
    }

    .bg-info { background-color: #0dcaf0 !important; color: #fff !important; }
    .bg-danger { background-color: #dc3545 !important; color: #fff !important; }
    .bg-primary { background-color: #0d6efd !important; color: #fff !important; }
    .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .bg-secondary { background-color: #6c757d !important; color: #fff !important; }

    /* ================= IMAGE ================= */
    .table img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    /* ================= PRINT ================= */
    @media print { 
        body {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        form,
        .btn,
        .pagination,
        .page-title,
        header,
        nav,
        footer,
        .sidebar,
        .pagination-info-screen { /* HILANG SAAT PRINT */
            display: none !important;
        }

        .print-header {
            display: block !important;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        @page { margin: 0 !important; }

        .table { font-size: 12px !important; }
        .table-responsive { box-shadow: none !important; border: none !important; }

        .badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            padding: 4px 8px !important;
            border-radius: 4px !important;
        }
    }

    .print-header { display: none; }

    /* ================= PAGINATION WRAPPER ================= */
    .pagination-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

</style>

<h2 class="page-title mb-4">
    <i class="fa fa-clipboard-list me-2"></i>
    Laporan Data Legalisir
</h2>

<form method="GET" class="row g-2 mb-4 p-3 rounded shadow-sm bg-light align-items-end flex-nowrap" style="flex-wrap:nowrap;">
    <!-- FILTERS -->
    <div class="col-md-3" style="min-width:180px;">
        <select name="jenis_akta" class="form-select">
            <option value="">Jenis Akta</option>
            <option value="kelahiran" {{ request('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
            <option value="kematian" {{ request('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
            <option value="perkawinan" {{ request('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
            <option value="perceraian" {{ request('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
        </select>
    </div>

    <div class="col-md-2" style="min-width:150px;">
        <input type="date" name="tanggal" id="tanggalInput" class="form-control" value="{{ request('tanggal') }}">
    </div>

    <div class="col-md-3" style="min-width:180px;">
        <select name="rentang" id="rentangInput" class="form-select">
            <option value="">Rentang Waktu</option>
            <option value="today" {{ request('rentang')=='today'?'selected':'' }}>Hari Ini</option>
            <option value="7days" {{ request('rentang')=='7days'?'selected':'' }}>7 Hari Terakhir</option>
            <option value="month" {{ request('rentang')=='month'?'selected':'' }}>Bulan Ini</option>
        </select>
    </div>

    <div class="col-md-2" style="min-width:160px;">
        <button class="btn btn-green w-100" type="submit">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>

    <div class="col-md-2" style="min-width:180px;">
        <button type="button" class="btn btn-green w-100" onclick="window.print()">
            <i class="fa fa-print"></i> Cetak Laporan
        </button>
    </div>
</form>

<script>
    const tanggalInput = document.getElementById('tanggalInput');
    const rentangInput = document.getElementById('rentangInput');

    tanggalInput.addEventListener('change', () => {
        rentangInput.disabled = tanggalInput.value !== "";
        if (tanggalInput.value) rentangInput.value = "";
    });

    rentangInput.addEventListener('change', () => {
        tanggalInput.disabled = rentangInput.value !== "";
        if (rentangInput.value) tanggalInput.value = "";
    });

    window.addEventListener('DOMContentLoaded', () => {
        if (tanggalInput.value) rentangInput.disabled = true;
        if (rentangInput.value) tanggalInput.disabled = true;
    });
</script>

<div class="print-header">
    <h2><b>LAPORAN DATA LEGALISIR</b></h2>
    <div>DISDUKCAPIL KOTA CIREBON</div>
    <div>Tanggal Cetak: {{ date('d M Y') }}</div>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-header">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Akta</th>
                <th>Nomor Akta</th>
                <th>Tanggal Permohonan</th>
                <th>Alasan</th>
                <th>Gambar</th>
            </tr>
        </thead>

        <tbody>
        @forelse($data as $row)
            <tr>
                <td class="text-center fw-bold">
                    {{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}
                </td>

                <td>{{ $row->nama }}</td>

                <td class="text-center">
                    <span class="badge
                        @if($row->jenis_akta == 'kelahiran') bg-info
                        @elseif($row->jenis_akta == 'kematian') bg-danger
                        @elseif($row->jenis_akta == 'perkawinan') bg-primary
                        @elseif($row->jenis_akta == 'perceraian') bg-warning text-dark
                        @else bg-secondary
                        @endif
                    ">
                        {{ ucfirst($row->jenis_akta) }}
                    </span>
                </td>

                <td class="text-center">{{ $row->no_akta }}</td>

                <td class="text-center">{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>

                <td><span class="alasan-ellipsis">{{ $row->alasan }}</span></td>

                <td class="text-center">
                    @if($row->gambar)
                        <a href="{{ asset('storage/'.$row->gambar) }}" target="_blank">
                            <img src="{{ asset('storage/'.$row->gambar) }}" >
                        </a>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">Tidak ada data ditemukan.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
@if ($data->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">

        <!-- Teks Menampilkan (Hanya tampil di layar, hilang saat print) -->
        <div class="pagination-info-screen text-muted small mb-2 mb-md-0">
            Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $data->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif

@endsection
