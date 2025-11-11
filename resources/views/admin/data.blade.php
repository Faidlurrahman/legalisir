@extends('admin.layout')

@section('content')
<h2 class="mb-4 fw-bold" style="color:rgb(0,119,62)">
    <i class="fa fa-database me-2" style="color:rgb(0,119,62)"></i>Data Permohonan Legalisir
</h2>

{{-- Form Filter --}}

<style>
#editModal .modal-dialog {
    max-width: 350px !important;
    width: 95vw;
    margin: 0 auto;
}
#editModal .modal-content {
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(56,178,172,0.10);
    padding: 0.5rem 0.5rem;
    /* Hapus max-height dan overflow agar tidak scroll */
}
#editModal .modal-body {
    padding: 0.5rem 0.5rem;
}
#editModal .form-label {
    font-weight: 500;
    font-size: 0.97rem;
    margin-bottom: 2px;
}
#editModal .form-control, #editModal .form-select {
    font-size: 0.97rem;
    border-radius: 8px;
    padding: 6px 10px;
    height: 32px;
}
#editModal textarea.form-control {
    min-height: 32px;
    height: 48px;
    resize: none;
}
#editModal .modal-footer {
    border-top: none;
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding-top: 0;
}
#editModal .btn {
    min-width: 110px;
}
#editModal #edit_preview {
    max-width: 60px;
    max-height: 45px;
    margin-top: 4px;
}
.btn-filter-green {
    background: rgb(0,119,62) !important;
    border-color: rgb(0,119,62) !important;
    color: #fff !important;
}
.table-header-green th {
    background: rgb(0,119,62) !important;
    color: #fff !important;
}
.table-header-green th:first-child {
    background: rgb(0,119,62) !important;
    color: #fff !important;
}
.table-green-row {
    background: rgb(220,245,235) !important;
}
</style>
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
        <button class="btn btn-filter-green w-100" type="submit">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>
</form>

{{-- Tabel Data --}}
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
                <th class="text-center" style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr @if($loop->first) class="table-green-row" @endif>
                <td style="background:#fff;color:#222;font-weight:bold;">{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
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
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-info btn-edit"
                       data-id="{{ $row->id }}"
                       data-nama="{{ $row->nama }}"
                       data-jenis_akta="{{ $row->jenis_akta }}"
                       data-no_akta="{{ $row->no_akta }}"
                       data-alasan="{{ $row->alasan }}"
                       data-gambar="{{ $row->gambar ? asset('storage/'.$row->gambar) : '' }}"
                       title="Edit" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete" 
                        data-id="{{ $row->id }}" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </button>
                    <form id="deleteForm{{ $row->id }}" action="{{ route('admin.data.delete', $row->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    Tidak ada data ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Navigasi Halaman (Pagination) --}}
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

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form id="editForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_nama" class="form-label">Nama Pemohon</label>
            <input type="text" name="nama" id="edit_nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_jenis_akta" class="form-label">Jenis Akta</label>
            <select name="jenis_akta" id="edit_jenis_akta" class="form-select" required>
              <option value="">-- Pilih Jenis Akta --</option>
              <option value="kelahiran">Akta Kelahiran</option>
              <option value="kematian">Akta Kematian</option>
              <option value="perkawinan">Akta Perkawinan</option>
              <option value="perceraian">Akta Perceraian</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_no_akta" class="form-label">Nomor Akta</label>
            <input type="text" name="no_akta" id="edit_no_akta" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_alasan" class="form-label">Alasan Legalisir</label>
            <textarea name="alasan" id="edit_alasan" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_gambar" class="form-label">Upload Foto Akta (Opsional)</label>
            <input type="file" name="gambar" id="edit_gambar" class="form-control" accept="image/*">
            <div class="mt-2">
              <img id="edit_preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width:120px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center p-3">
      <div class="modal-body">
        <div class="mb-2 fw-semibold">Apakah Anda Yakin?</div>
        <div class="mb-3 small text-muted">Data Ini Akan Dihapus?</div>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-danger btn-sm" id="btnDeleteYes">YA</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">BATAL</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan modal dan isi data
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            const id = this.dataset.id;
            document.getElementById('edit_nama').value = this.dataset.nama;
            document.getElementById('edit_jenis_akta').value = this.dataset.jenis_akta;
            document.getElementById('edit_no_akta').value = this.dataset.no_akta;
            document.getElementById('edit_alasan').value = this.dataset.alasan;
            const gambar = this.dataset.gambar;
            const preview = document.getElementById('edit_preview');
            if(gambar) {
                preview.src = gambar;
                preview.classList.remove('d-none');
            } else {
                preview.src = "#";
                preview.classList.add('d-none');
            }
            document.getElementById('editForm').action = '/admin/data/' + id;
        });
    });

    // Preview gambar baru
    document.getElementById('edit_gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('edit_preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Konfirmasi hapus
    let deleteId = null;
    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function() {
            deleteId = this.dataset.id;
            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });
    });
    document.getElementById('btnDeleteYes').addEventListener('click', function() {
        if(deleteId) {
            document.getElementById('deleteForm'+deleteId).submit();
        }
    });
});
</script>

@endpush
