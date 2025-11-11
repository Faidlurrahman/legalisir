@extends('admin.layout')

@section('content')
<style>
    body, main.flex-fill {
        background: #fff !important;
    }
    .table-header-green th {
    background: rgb(0,119,62) !important;
    color: #fff !important;
    }
      .table-header-green th:first-child {
    background: rgb(0,119,62) !important;
    color: #fff !important;
    }
</style>
<h2 class="mb-4 fw-bold" style="color:rgb(0,119,62)">
    <i class="fa fa-file-alt me-2" style="color:rgb(0,119,62)"></i>Laporan Data Legalisir
</h2>

<form method="GET" class="row g-2 mb-4 p-3 rounded shadow-sm bg-light" id="filterForm">
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
        <input type="date" name="tanggal" id="tanggalInput" class="form-control" value="{{ request('tanggal') }}">
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
        <button class="btn w-100" type="submit" style="background:rgb(0,119,62);border-color:rgb(0,119,62);color:#fff;">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>
    <div class="col-md-2 text-end">
        <button type="button" class="btn btn-success me-2" onclick="window.print()" style="background:rgb(0,119,62);border-color:rgb(0,119,62);color:#fff;">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</form>
<script>
    const tanggalInput = document.getElementById('tanggalInput');
    const rentangInput = document.getElementById('rentangInput');
    tanggalInput.addEventListener('change', function() {
        if (this.value) {
            rentangInput.value = '';
            rentangInput.disabled = true;
        } else {
            rentangInput.disabled = false;
        }
    });
    rentangInput.addEventListener('change', function() {
        if (this.value) {
            tanggalInput.value = '';
            tanggalInput.disabled = true;
        } else {
            tanggalInput.disabled = false;
        }
    });
    // Inisialisasi saat reload
    window.addEventListener('DOMContentLoaded', function() {
        if (tanggalInput.value) {
            rentangInput.disabled = true;
        }
        if (rentangInput.value) {
            tanggalInput.disabled = true;
        }
    });
</script>

<style>
@media print {
    body {
        background: #fff !important;
        color: #222 !important;
    }
    .sidebar, .btn, .navbar, .logout, .filter-form, .pagination, .alert, .print-header, h2, form, .d-flex, .mb-4, .fw-bold, .text-primary {
        display: none !important;
    }
    .table-card, .table-responsive, .shadow-sm, .rounded {
        box-shadow: none !important;
        border-radius: 0 !important;
        background: #fff !important;
    }
    .table {
        font-size: 12px;
    }
}
.print-header {
    display: none;
}
</style>

<div class="print-header">
    <h3>LAPORAN DATA LEGALISIR</h3>
    <div>DISDUKCAPIL KOTA CIREBON</div>
    <div>Tanggal Cetak: {{ date('d M Y') }}</div>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered align-middle table-hover">
        <thead class="table-header-green">
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
            <tr @if($loop->first) style="background:rgb(0,119,62);color:#fff;" @endif>
                <td>{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
                <td>{{ $row->nama }}</td>
                <td>
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
                <td>{{ $row->no_akta }}</td>
                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                <td>{{ $row->alasan ?? '-' }}</td>
                <td>
                    @if($row->gambar)
                        <a href="{{ asset('storage/'.$row->gambar) }}" target="_blank">
                            <img src="{{ asset('storage/'.$row->gambar) }}" 
                                 alt="Gambar" 
                                 style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                        </a>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    Tidak ada data ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($data->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
        <div class="text-muted small mb-2 mb-md-0">
            Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
        </div>
        <div>
            {{ $data->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
@endsection
