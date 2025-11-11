@extends('admin.layout')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold" style="color:rgb(0,119,62)"><i class="fa fa-file-alt me-2" style="color:rgb(0,119,62)"></i>Form Pengajuan Legalisir Akta</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formLegalisir.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-white">
        @csrf
        <div class="form-group mb-3">
            <label for="nama" style="color:rgb(0,119,62);font-weight:500;">Nama Pemohon</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="jenis_akta" style="color:rgb(0,119,62);font-weight:500;">Jenis Akta</label>
            <select name="jenis_akta" id="jenis_akta" class="form-control" required style="border-color:rgb(0,119,62);color:rgb(0,119,62)">
                <option value="">-- Pilih Jenis Akta --</option>
                <option value="kelahiran" {{ old('jenis_akta')=='kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                <option value="kematian" {{ old('jenis_akta')=='kematian'?'selected':'' }}>Akta Kematian</option>
                <option value="perkawinan" {{ old('jenis_akta')=='perkawinan'?'selected':'' }}>Akta Perkawinan</option>
                <option value="perceraian" {{ old('jenis_akta')=='perceraian'?'selected':'' }}>Akta Perceraian</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="no_akta" style="color:rgb(0,119,62);font-weight:500;">Nomor Akta</label>
            <input type="text" name="no_akta" id="no_akta" class="form-control" value="{{ old('no_akta') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="alasan" style="color:rgb(0,119,62);font-weight:500;">Alasan Legalisir</label>
            <textarea name="alasan" id="alasan" class="form-control" rows="3">{{ old('alasan') }}</textarea>
        </div>
        <div class="form-group mb-4">
            <label for="gambar" style="color:rgb(0,119,62);font-weight:500;">Upload Foto Akta</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
            <small class="form-text text-muted">Format: jpg, jpeg, png. Maksimal 2MB.</small>

            {{-- Thumbnail Preview --}}
            <div class="mt-3 text-start">
                <img id="preview" src="#" alt="Preview Gambar"
                     class="img-thumbnail d-none"
                     style="max-width:150px; cursor:pointer;"
                     data-bs-toggle="modal" data-bs-target="#previewModal">
            </div>
        </div>
        <button type="submit" class="btn w-100" style="background:rgb(0,119,62);color:#fff;font-weight:bold;">Submit Pengajuan</button>
    </form>
</div>

{{-- Modal Pop-up --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark border-0">
      <div class="modal-body text-center p-2">
        <img id="previewModalImg" src="#" class="img-fluid rounded" alt="Preview Besar">
      </div>
    </div>
  </div>
</div>

{{-- Script Preview --}}
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
