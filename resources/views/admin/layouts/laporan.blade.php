@extends('admin.layout')

@section('content')
<h2 class="mb-4 fw-bold text-primary">
    <i class="fa fa-file-alt me-2"></i>Laporan Data Legalisir
</h2>

<form method="GET" class="row g-2 mb-4 p-3 rounded shadow-sm bg-light">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nama / nomor akta" value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <select name="jenis_akta" class="form-select">
            <option value="">Jenis Akta</option>
            <option value="kelahiran" {{ request('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
            <option value="kematian" {{ request('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
            <option value="perkawinan" {{ request('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
            <option value="perceraian" {{ request('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100" type="submit">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>
    <div class="col-md-3 text-end">
        <a href="{{ route('admin.laporan.print', request()->all()) }}" target="_blank" class="btn btn-success me-2">
            <i class="fa fa-print"></i> Print PDF
        </a>
        <a href="{{ route('admin.laporan.export', request()->all()) }}" class="btn btn-warning">
            <i class="fa fa-file-excel"></i> Export Excel
        </a>
    </div>
</form>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered align-middle table-hover">
        <thead class="table-primary">
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
