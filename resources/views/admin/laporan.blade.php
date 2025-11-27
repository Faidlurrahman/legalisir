@extends('admin.layout')  
@section('content')  

<style>
    :root {
        --green: #0b5b57;
        --light-gray: #f8f9fa;
        --border-soft: #e5e7eb;
        --text-dark: #222;
    }

    body, main.flex-fill {
        background: #fff !important;
        font-family: "Inter", sans-serif;
    }

    /* ================= PAGE TITLES ================= */
    .page-title {
        color: var(--green);
        font-weight: 700;
        font-size: 1.7rem;
        letter-spacing: .3px;
    }

    /* ================= BUTTON THEME ================= */
    .btn-green {
        background: var(--green) !important;
        border-color: var(--green) !important;
        color: #fff !important;
        font-weight: 600;
    }

    .btn-green:hover {
        opacity: .9;
    }

    /* ================= TABLE ================= */
    .table-header th {
        background: var(--light-gray) !important;
        color: var(--green) !important;
        font-weight: 600;
        text-align: center;
    }

    .table-bordered > :not(caption) > * > * {
        border-color: var(--border-soft) !important;
    }

    /* FIRST DATA ROW */
    .table tbody tr:first-child {
        background: var(--green) !important;
        color: #fff;
    }

    .alasan-ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 240px;
        font-size: .95rem;
        line-height: 1.3;
    }

    /* ================= PRINT ================= */
    @media print { 
        body {
            background: #fff !important;
        }

        /* Hide all controls */
        form,
        .btn,
        .pagination,
        .page-title,
        header,
        nav,
        footer,
        .sidebar {
            display: none !important;
        }

        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
        }

        .print-header h2 {
            font-size: 20px;
            margin-bottom: 3px;
            font-weight: 700;
        }

        .print-header div {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .table {
            font-size: 12px !important;
        }

        .table-responsive {
            box-shadow: none !important;
            border: none !important;
        }

        /* ================= Badge Colors on Print ================= */
        .badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;

            padding: 4px 8px !important;
            border-radius: 4px !important;
            font-weight: 600 !important;
        }

        .bg-info { background-color: #0dcaf0 !important; color: #fff !important; }
        .bg-danger { background-color: #dc3545 !important; color: #fff !important; }
        .bg-primary { background-color: #0d6efd !important; color: #fff !important; }
        .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
        .bg-secondary { background-color: #6c757d !important; color: #fff !important; }

        /* Make table borders print properly */
        table, th, td {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }

    .print-header {
        display: none;
    }
</style>

{{-- ================= TITLE ================= --}}
<h2 class="page-title mb-4">
    <i class="fa fa-clipboard-list me-2"></i>
    Laporan Data Legalisir
</h2>

{{-- ================= FILTER FORM ================= --}}
<form method="GET" class="row g-2 mb-4 p-3 rounded shadow-sm bg-light">
    <div class="col-md-3">
        <select name="jenis_akta" class="form-select">
            <option value="">Jenis Akta</option>
            <option value="kelahiran" {{ request('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
            <option value="kematian" {{ request('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
            <option value="perkawinan" {{ request('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
            <option value="perceraian" {{ request('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
        </select>
    </div>

    <div class="col-md-2">
        <input type="date" name="tanggal" id="tanggalInput"
               class="form-control" value="{{ request('tanggal') }}">
    </div>

    <div class="col-md-3">
        <select name="rentang" id="rentangInput" class="form-select">
            <option value="">Rentang Waktu</option>
            <option value="today" {{ request('rentang')=='today'?'selected':'' }}>Hari Ini</option>
            <option value="7days" {{ request('rentang')=='7days'?'selected':'' }}>7 Hari Terakhir</option>
            <option value="month" {{ request('rentang')=='month'?'selected':'' }}>Bulan Ini</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-green w-100" type="submit">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>

    <div class="col-md-2">
        <button type="button" class="btn btn-green w-100" onclick="window.print()">
            <i class="fa fa-print"></i> Cetak Laporan
        </button>
    </div>
</form>

{{-- DISABLE AUTOMATIC INPUT --}}
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

{{-- ================= PRINT HEADER ================= --}}
<div class="print-header">
    <h2><b>LAPORAN DATA LEGALISIR</b></h2>
    <div>DISDUKCAPIL KOTA CIREBON</div>
    <div>Tanggal Cetak: {{ date('d M Y') }}</div>
</div>

{{-- ================= TABLE ================= --}}
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
                            <img src="{{ asset('storage/'.$row->gambar) }}"
                                 style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
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

{{-- ================= PAGINATION ================= --}}
@if ($data->hasPages())
<div class="d-flex flex-column flex-md-row justify-content-between mt-3">
    <div class="text-muted small mb-2 mb-md-0">
        Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
    </div>

    <div>
        {{ $data->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endif

@endsection
