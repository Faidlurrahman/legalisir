@extends('admin.layout')

@section('content')
<style>
    .legalisir-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        padding: 30px 36px;
        margin-top: 0 !important; /* Pastikan tidak ada margin-top */
    }

    .form-title {
        color: #0b5b57;
        font-weight: 700;
        margin-bottom: 10px; /* Kurangi jika perlu */
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group label,
    .upload-panel label {
        font-weight: 600;
        color: #0b5b57; /* hijau */
    }

    .form-control, select, textarea {
        border: none;
        border-bottom: 2px solid #0b5b57; /* hijau */
        border-radius: 0;
        box-shadow: none;
        transition: all 0.18s ease;
        padding: 8px 6px;
    }

    .form-control:focus, textarea:focus {
        border-color: #0b5b57;
        box-shadow: none;
    }

    .form-textarea-limited {
        min-height: 120px;
        max-height: 220px;
        resize: vertical;
        width: 100%;
    }

    /* kanan: upload + preview */
    .upload-panel {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .preview-wrapper {
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #fafafa;
        border: 1px dashed #e0e0e0;
        border-radius: 10px;
        padding: 10px;
    }

    .preview-wrapper img {
        max-width: 100%;
        max-height: 120px;
        object-fit: contain;
        border-radius: 8px;
        display: block;
    }

    .preview-placeholder {
        color: #9a9a9a;
        font-size: 14px;
    }

    .btn-submit {
        background: #0b5b57;
        color: #fff;
        font-weight: 600;
        padding: 10px 28px;
        border-radius: 8px;
        border: none;
    }

    @media (max-width: 768px) {
        .legalisir-card { padding: 20px; }
        .preview-wrapper { min-height: 100px; }
    }

    .row.g-4.align-items-end > .col-md-6 .form-control {
        margin-bottom: 0;
    }
</style>

<div class="container py-4">
    <h2 class="form-title">
        <i class="fa fa-file-signature" style="color:#0b5b57;"></i>
        Form Pengajuan Legalisir Akta
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="legalisir-card">
        <form action="{{ route('formLegalisir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4 align-items-end">
                <!-- BARIS 1: Nama Pemohon | Jenis Akta -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama">Nama Pemohon</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_akta">Jenis Akta</label>
                        <select name="jenis_akta" id="jenis_akta" class="form-control" required>
                            <option value="">-- Pilih Jenis Akta --</option>
                            <option value="kelahiran" {{ old('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                            <option value="kematian" {{ old('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
                            <option value="perkawinan" {{ old('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
                            <option value="perceraian" {{ old('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
                        </select>
                    </div>
                </div>

                <!-- BARIS 2: Nomor Akta | Upload Foto Akta -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_akta">Nomor Akta</label>
                        <input type="text" name="no_akta" id="no_akta" class="form-control" value="{{ old('no_akta') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan Legalisir</label>
                        <textarea name="alasan" id="alasan" class="form-control form-textarea-limited">{{ old('alasan') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="upload-panel">
                        <label for="gambar">Upload Foto Akta</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Format: jpg, jpeg, png (Maks 2MB)</small>
                        <div class="preview-wrapper mt-2">
                            <img id="preview" src="#" alt="Preview" class="d-none" data-bs-toggle="modal" data-bs-target="#previewModal">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-start mt-4">
                <button type="submit" class="btn-submit">Submit Pengajuan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark border-0">
      <div class="modal-body text-center p-2">
        <img id="previewModalImg" src="#" class="img-fluid rounded" alt="Preview Besar">
      </div>
    </div>
  </div>
</div>

<script>
    const inputFile = document.getElementById('gambar');
    const preview = document.getElementById('preview');
    const modalImg = document.getElementById('previewModalImg');

    inputFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                modalImg.src = event.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            modalImg.src = "#";
            preview.classList.add('d-none');
        }
    });
</script>
@endsection
