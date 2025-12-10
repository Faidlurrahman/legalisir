@extends('admin.layout')

@section('content')
<h2 class="mb-4 fw-bold" style="color:#0b5b57">
    <i class="fa fa-folder-open me-2" style="color:#0b5b57"></i>Data Permohonan Legalisir
</h2>


@php
    $type = session('alert_type', 'success');
@endphp

{{-- Alert Berwarna --}}
@if(session('success'))
<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert" id="successAlert">
    @if($type == 'success')
        <i class="fa fa-check-circle me-2"></i>
    @elseif($type == 'warning')
        <i class="fa fa-exclamation-triangle me-2"></i>
    @elseif($type == 'danger')
        <i class="fa fa-trash-alt me-2"></i>
    @endif
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Form Filter --}}

<style>
#editModal .modal-dialog {
    max-width: 420px !important;
    width: 98vw;
    margin: 0 auto;
}
#editModal .modal-content {
    max-height: 80vh; /* Batasi tinggi modal */
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(11,91,87,0.10); /* hijau layout */
    padding: 0.5rem 0.5rem;
}
@media (max-width: 700px) {
    #editModal .modal-dialog {
        max-width: 98vw !important;
    }
}
#editModal .modal-body {
    max-height: 60vh; /* Batasi tinggi isi modal */
    overflow-y: auto;
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
/* Perbaikan CSS Data Legalisir agar lebih ringkas, responsif, dan konsisten */
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
    border-color: #e0e0e0 !important;
}

.table-header-green th {
    background: #f5f5f5 !important;
    color: #0b5b57 !important;
    font-weight: 700;
    font-size: 1rem;
    border-bottom: 2px solid #0b5b57 !important;
}

.table-green-row {
    background: #d5eae9 !important;
}

.alasan-ellipsis {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
    max-width: 180px;
    font-size: 0.97rem;
    line-height: 1.3;
    min-width: 80px;
}

.badge {
    font-size: 0.95rem;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
}

.btn {
    font-size: 0.97rem;
    border-radius: 8px;
    padding: 6px 12px;
    font-weight: 600;
}

.btn-info {
    background: #38b2ac !important;
    border-color: #319795 !important;
    color: #fff !important;
}

.btn-danger {
    background: #ef4444 !important;
    border-color: #dc2626 !important;
    color: #fff !important;
}

.btn-success {
    background: #0b5b57 !important;
    border-color: #0b5b57 !important;
    color: #fff !important;
}

.btn-filter-green {
    background: #0b5b57 !important;
    border-color: #0b5b57 !important;
    color: #fff !important;
    font-weight: bold;
}

.form-control, .form-select {
    font-size: 0.97rem;
    border-radius: 8px;
    padding: 6px 10px;
    height: 32px;
}

.img-thumbnail {
    border-radius: 8px;
    border: 1px solid #ddd;
    object-fit: cover;
}

@media (max-width: 900px) {
    .table th, .table td {
        font-size: 0.93rem;
        padding: 6px 3px;
    }
    .alasan-ellipsis {
        max-width: 110px;
        font-size: 0.92rem;
    }
    .table-responsive {
        padding: 0;
        box-shadow: none;
    }
}

/* --- FILTER FORM --- */
.filter-form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: end;
    margin-bottom: 18px;
}
.filter-form-row .filter-group {
    flex: 1 1 140px;
    min-width: 140px;
    max-width: 220px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.filter-form-row .filter-group label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #0b5b57;
    margin-bottom: 2px;
}
.filter-form-row .filter-group .form-control,
.filter-form-row .filter-group .form-select {
    font-size: 0.82rem;
    border-radius: 6px;
    padding: 5px 10px;
    height: 30px;
}
.filter-form-row .btn {
    font-size: 0.82rem;
    border-radius: 6px;
    padding: 5px 14px;
    font-weight: 600;
    background: #0b5b57 !important;
    border-color: #0b5b57 !important;
    color: #fff !important;
    min-width: 90px;
    margin-left: 2px;
}
@media (max-width: 900px) {
    .filter-form-row {
        flex-direction: column;
        gap: 8px;
    }
    .filter-form-row .filter-group {
        min-width: 100%;
        max-width: 100%;
    }
}
</style>
<div class="filter-form-row mb-4" style="align-items: flex-end;">
    <form method="GET" class="d-flex flex-wrap gap-2 flex-grow-1 filter-form-row" id="filterForm" style="align-items: flex-end; width:100%;">
        <div class="filter-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Nama / Nomor Akta" value="{{ request('search') }}">
        </div>
        <div class="filter-group">
            <select name="jenis_akta" id="jenis_akta" class="form-select">
                <option value="">--- Pilihan Akta ---</option>
                <option value="kelahiran" {{ request('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                <option value="kematian" {{ request('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
                <option value="perkawinan" {{ request('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
                <option value="perceraian" {{ request('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
            </select>
        </div>
        <div class="filter-group">
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <button class="btn btn-filter-green align-self-end" type="submit">
            <i class="fa fa-search"></i> Filter
        </button>
        <div class="ms-auto">
            <a href="{{ route('formLegalisir') }}" class="btn btn-success align-self-end">
                <i class="fa fa-plus"></i> Tambah Data
            </a>
        </div>
    </form>
</div>

{{-- Tabel Data --}}
<div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered align-middle table-hover" id="dataTable">
        <thead class="table-header-green">
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama</th>
                <th style="text-align: center;">Jenis Akta</th>
                <th style="text-align: center;">Nomor Akta</th>
                <th style="text-align: center;">Tanggal Permohonan</th>
                <th style="text-align: center;">Alasan</th>
                <th style="text-align: center;">Gambar</th>
                <th class="text-center" style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody id="dataTableBody">
            @forelse($data as $row)
            <tr @if($loop->first && $type == 'success' && session('success')) class="table-green-row" @endif>
                <td style="background:#fff;color:#222;font-weight:bold;text-align:center;">{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
                <td class="searchable">{{ $row->nama }}</td>
                <td style="text-align: center;">
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
                <td class="searchable" style="text-align: center;">{{ $row->no_akta }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                <td><span class="alasan-ellipsis" title="{{ $row->alasan }}">{{ $row->alasan }}</span></td>
                <td style="text-align: center;">
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
                        data-id="{{ $row->id }}" 
                        data-nama="{{ $row->nama }}" 
                        title="Hapus">
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
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
    <div class="text-muted small mb-2 mb-md-0" id="infoScreen">
        Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
    </div>
    <div class="ms-md-auto">
        {{ $data->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
        <div class="mb-2 fw-semibold">Konfirmasi Hapus Data</div>
        <div class="mb-1">
          <span class="fw-bold text-danger" id="deleteNama"></span>
        </div>
        <div class="mb-3 small text-muted">
          Apakah anda yakin akan hapus data tersebut?
        </div>
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
    let deleteNama = '';
    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function() {
            deleteId = this.dataset.id;
            deleteNama = this.dataset.nama;
            const noAkta = this.closest('tr').querySelector('td:nth-child(4)')?.textContent?.trim() || '';
            document.getElementById('deleteNama').textContent = `${deleteNama}${noAkta ? ' (' + noAkta + ')' : ''}`;
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

// Live search filter for Nama & Nomor Akta
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('dataTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const infoScreen = document.getElementById('infoScreen');
    const paginationWrapper = document.querySelector('.ms-md-auto');

    // Buat baris "tidak ada data ditampilkan" jika belum ada
    let noDataRow = tableBody.querySelector('.no-data-row');
    if (!noDataRow) {
        noDataRow = document.createElement('tr');
        noDataRow.className = 'no-data-row';
        noDataRow.innerHTML = `<td colspan="8" class="text-center text-muted py-4">Tidak ada data ditampilkan.</td>`;
        noDataRow.style.display = 'none';
        tableBody.appendChild(noDataRow);
    }

    searchInput.addEventListener('input', function() {
        const keyword = this.value.trim().toLowerCase();
        let visibleRows = 0;
        rows.forEach(row => {
            // Gabungkan isi kolom nama dan nomor akta
            const searchableCells = row.querySelectorAll('.searchable');
            const text = Array.from(searchableCells).map(cell => cell.textContent.trim().toLowerCase()).join(' ');
            if (text.includes(keyword) || keyword === '') {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });
        // Tampilkan baris "Tidak ada data ditampilkan" jika tidak ada hasil
        noDataRow.style.display = (keyword.length > 0 && visibleRows === 0) ? '' : 'none';

        // Sembunyikan info "Menampilkan ..." dan pagination saat sedang search
        if (infoScreen) {
            infoScreen.style.display = keyword.length > 0 ? 'none' : '';
        }
        if (paginationWrapper) {
            paginationWrapper.style.display = keyword.length > 0 ? 'none' : '';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    function removeHighlight() {
        var firstRow = document.querySelector('.table-green-row');
        if(firstRow) firstRow.classList.remove('table-green-row');
    }

    var alert = document.getElementById('successAlert');
    if(alert) {
        // Auto-hide alert setelah 3.5 detik
        setTimeout(function(){
            // Trigger close (Bootstrap akan animasi dan trigger event hidden.bs.alert)
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 3500);

        // Saat alert benar-benar hilang (baik auto maupun manual close)
        alert.addEventListener('hidden.bs.alert', function () {
            removeHighlight();
            // Scroll ke atas tabel jika perlu
            var table = document.querySelector('.table-responsive');
            if(table) table.scrollIntoView({behavior: "smooth", block: "start"});
        });
    }
});
</script>

@endpush
