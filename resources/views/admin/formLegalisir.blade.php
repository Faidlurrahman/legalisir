@extends('admin.layout')

@section('content')
<style>
    /* ===== CARD UTAMA ===== */
    .legalisir-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        padding: 40px 50px;
        margin-top: 15px;
    }

    /* ===== JUDUL ===== */
    .form-title {
        color: #0b5b57;
        font-weight: 700;
        margin-bottom: 25px;
        margin-top: -10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ===== INPUT & LABEL ===== */
    .form-group label {
        font-weight: 500;
        color: #0b5b57;
    }

    .form-control, select, textarea {
        border: none;
        border-bottom: 2px solid #d0d0d0;
        border-radius: 0;
        box-shadow: none;
        transition: all 0.3s ease;
        padding: 8px 5px;
    }

    .form-control:focus, textarea:focus {
        border-color: #0b5b57;
        box-shadow: none;
    }

    /* Biar textarea tidak melebar ke kanan */
    .form-textarea-limited {
        min-height: 180px;
        resize: vertical;
        width: 95%; /* samakan lebar dengan input lainnya */
    }

    /* ===== Upload Image Container ===== */
    .upload-container {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        flex-wrap: wrap;
    }

    .upload-container img {
        max-width: 120px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 5px;
        cursor: pointer;
    }

    /* ===== BUTTON ===== */
    .btn-submit {
        background: #0b5b57;
        color: #fff;
        font-weight: 600;
        padding: 10px 35px;
        border-radius: 8px;
        border: none;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #0a4c48;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .legalisir-card {
            padding: 25px;
        }
        .form-textarea-limited {
            width: 100%;
        }
        .upload-container {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container py-4">
    {{-- Judul tetap di kiri atas --}}
    <h2 class="form-title">
        <i class="fa fa-file-signature" style="color:#0b5b57;"></i>
        Form Pengajuan Legalisir Akta
    </h2>

    {{-- Notifikasi --}}
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

    {{-- CARD FORM --}}
    <div class="legalisir-card">
        <form action="{{ route('formLegalisir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                {{-- Nama Pemohon --}}
                <div class="col-md-6 form-group">
                    <label for="nama">Nama Pemohon</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                {{-- Jenis Akta --}}
                <div class="col-md-6 form-group">
                    <label for="jenis_akta">Jenis Akta</label>
                    <select name="jenis_akta" id="jenis_akta" class="form-control" required>
                        <option value="">-- Pilih Jenis Akta --</option>
                        <option value="kelahiran" {{ old('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                        <option value="kematian" {{ old('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
                        <option value="perkawinan" {{ old('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
                        <option value="perceraian" {{ old('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
                    </select>
                </div>

                {{-- Nomor Akta --}}
                <div class="col-md-6 form-group">
                    <label for="no_akta">Nomor Akta</label>
                    <input type="text" name="no_akta" id="no_akta" class="form-control" value="{{ old('no_akta') }}" required>
                </div>

                {{-- Upload Foto Akta + Preview --}}
                <div class="col-md-6 form-group">
                    <label for="gambar">Upload Foto Akta</label>
                    <div class="upload-container">
                        <div>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Format: jpg, jpeg, png (Maks 2MB)</small>
                        </div>
                        <img id="preview" src="#" alt="Preview" class="d-none"
                            data-bs-toggle="modal" data-bs-target="#previewModal">
                    </div>
                </div>

                {{-- Alasan Legalisir (panjang ke bawah, tidak terdorong gambar) --}}
                <div class="col-md-6 form-group">
                    <label for="alasan">Alasan Legalisir</label>
                    <textarea name="alasan" id="alasan" class="form-control form-textarea-limited">{{ old('alasan') }}</textarea>
                </div>
            </div>

            {{-- Tombol Submit (rata kanan) --}}
            <div class="text-end mt-4">
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

{{-- Script Preview Gambar --}}
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
