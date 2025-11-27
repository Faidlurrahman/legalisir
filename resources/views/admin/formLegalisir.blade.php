@extends('admin.layout')

@section('content')
<style>
    /* ==== STYLE KHUSUS FORM LEGALISIR ==== */

    .legalisir-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 28px 32px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .form-title {
        color: #0b5b57;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        color: #0b5b57;
    }

    .form-control, textarea, select {
        border: none !important;
        border-bottom: 2px solid #0b5b57 !important;
        border-radius: 0;
        padding: 8px 6px;
        box-shadow: none !important;
        transition: .15s;
    }

    .form-control:focus, textarea:focus, select:focus {
        border-color: #0e736e !important;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* ====== INPUT GAMBAR ====== */

    .upload-box {
        border: 2px dashed #0b5b57;
        background: #f7fdfc;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: .2s;
    }

    .upload-box:hover {
        background: #e9f5f4;
    }

    .upload-placeholder {
        color: #0b5b57;
        font-weight: 600;
        font-size: 14px;
    }

    .upload-box img {
        max-height: 180px;
        max-width: 100%;
        object-fit: contain;
        border-radius: 8px;
    }

    .btn-remove-image {
        display: none;
        margin-top: 8px;
    }

    /* SUBMIT BUTTON */
    .btn-submit {
        background: #0b5b57;
        color: #fff;
        font-weight: 600;
        padding: 10px 28px;
        border-radius: 8px;
        border: none;
        transition: .2s;
    }

    .btn-submit:hover {
        background: #094d49;
    }
</style>

<div class="container py-3">

    <h2 class="form-title">
        <i class="fa fa-file-signature" style="color:#0b5b57;"></i>
        Form Pengajuan Legalisir Akta
    </h2>

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- ERROR --}}
    @if($errors->any())
    <div class="alert alert-danger shadow-sm">
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

            <div class="row g-4">

                {{-- Nama Pemohon --}}
                <div class="col-md-6">
                    <label>Nama Pemohon</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                {{-- Jenis Akta --}}
                <div class="col-md-6">
                    <label>Jenis Akta</label>
                    <select name="jenis_akta" class="form-control" required>
                        <option value="">-- Pilih Jenis Akta --</option>
                        <option value="kelahiran" {{ old('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                        <option value="kematian" {{ old('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
                        <option value="perkawinan" {{ old('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
                        <option value="perceraian" {{ old('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
                    </select>
                </div>

                {{-- Nomor Akta --}}
                <div class="col-md-6">
                    <label>Nomor Akta</label>
                    <input type="text" name="no_akta" class="form-control" value="{{ old('no_akta') }}" required>

                    <label class="mt-3">Alasan Legalisir</label>
                    <textarea name="alasan" class="form-control">{{ old('alasan') }}</textarea>
                </div>

                {{-- Upload Gambar --}}
                <div class="col-md-6">
                    <label>Upload Foto Akta</label>

                    <div class="upload-box mt-2" onclick="document.getElementById('gambar').click()">
                        <img id="preview" class="d-none" alt="Preview">
                        <div id="placeholder" class="upload-placeholder">
                            Klik untuk memilih foto
                        </div>
                    </div>

                    <input type="file" name="gambar" id="gambar" class="d-none" accept="image/*">

                    <button type="button" id="removeImageBtn" class="btn btn-danger btn-sm btn-remove-image">
                        Hapus Gambar
                    </button>

                    <small class="text-muted d-block mt-1">
                        Format: JPG, JPEG, PNG (maks 2MB)
                    </small>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn-submit">Submit Pengajuan</button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL PREVIEW --}}
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark p-2 border-0">
            <img id="previewModalImg" class="img-fluid rounded">
        </div>
    </div>
</div>

<script>
    const input = document.getElementById("gambar");
    const preview = document.getElementById("preview");
    const placeholder = document.getElementById("placeholder");
    const modalImg = document.getElementById("previewModalImg");
    const removeBtn = document.getElementById("removeImageBtn");

    // Preview image
    input.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                modalImg.src = e.target.result;

                preview.classList.remove("d-none");
                placeholder.style.display = "none";
                removeBtn.style.display = "inline-block";
            };

            reader.readAsDataURL(file);
        }
    });

    // Hapus gambar
    removeBtn.addEventListener("click", function () {
        input.value = "";
        preview.src = "#";
        preview.classList.add("d-none");
        placeholder.style.display = "block";
        removeBtn.style.display = "none";
    });

    // Klik preview untuk lihat modal
    preview.addEventListener("click", function () {
        if (preview.src !== "#") {
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }
    });
</script>

@endsection
