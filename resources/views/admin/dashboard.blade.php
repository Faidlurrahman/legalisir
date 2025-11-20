@extends('admin.layout')

@section('content')
<style>
    body,
    main.flex-fill {
        background: #fff !important;
    }

    .dashboard-title {
        font-weight: 700;
        color: #0b5b57;
    }

    .dashboard-clock {
        display: inline-block;
        min-width: 120px;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0b5b57;
        letter-spacing: 1px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(11,91,87,0.18);
        border-radius: 999px;
        padding: 8px 18px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
        transition: transform .18s ease, box-shadow .18s ease;
        animation: clockPulse 2.4s ease-in-out infinite;
    }

    .dashboard-clock:focus {
        outline: none;
        box-shadow: 0 8px 22px rgba(11,91,87,0.13);
    }

    @keyframes clockPulse {
        0% { transform: translateY(0);}
        50% { transform: translateY(-2px);}
        100% { transform: translateY(0);}
    }

    .stat-week-label {
        font-weight: bold;
        color: #0b5b57;
        font-size: 1.1rem;
    }

    @keyframes statPop {
        0% { transform: scale(0.85); opacity: 0.7;}
        60% { transform: scale(1.08);}
        100% { transform: scale(1); opacity: 1;}
    }

    /* Card statistik atas: kecil & warna beragam */
    .card-stat {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        transition: transform .3s, box-shadow .3s;
        padding: 1.5rem 1rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        animation: statPop .8s;
        min-height: 120px;
    }
    .card-stat:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 24px rgba(0,0,0,0.13);
    }
    .card-stat .icon-bg {
        position: absolute;
        top: -18px;
        right: -18px;
        font-size: 3.5rem;
        opacity: 0.12;
        animation: iconPop .8s;
    }
    @keyframes iconPop {
        0% { transform: scale(0.7);}
        70% { transform: scale(1.1);}
        100% { transform: scale(1);}
    }
    .card-stat.kelahiran {
        background: linear-gradient(135deg, #38b2ac 80%, #319795 100%);
    }
    .card-stat.kematian {
        background: linear-gradient(135deg, #f87171 80%, #ef4444 100%);
    }
    .card-stat.kawin {
        background: linear-gradient(135deg, #6366f1 80%, #4338ca 100%);
    }
    .card-stat.cerai {
        background: linear-gradient(135deg, #fbbf24 80%, #f7a61c 100%);
    }
    .card-stat h6 {
        color: #fff;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .card-stat h3 {
        color: #fff;
        font-weight: 700;
        font-size: 2.1rem;
        margin-bottom: 0;
        letter-spacing: 1px;
    }
    .card-stat .desc {
        font-size: 0.95rem;
        color: #ffeccc;
    }

    /* Statistik Mingguan Akta: diperbesar & animasi */
    .chart-card {
        border-radius: 20px;
        background-color: #fff;
        box-shadow: 0 4px 18px rgba(11,91,87,0.10);
        padding: 40px 32px 32px 32px;
        animation: fadeInUpBig .9s cubic-bezier(.4,2,.6,1);
        min-height: 370px;
        transition: box-shadow .3s, transform .3s;
    }
    .chart-card:hover {
        box-shadow: 0 12px 32px rgba(11,91,87,0.13);
        transform: scale(1.025);
    }
    @keyframes fadeInUpBig {
        from { opacity: 0; transform: translateY(60px);}
        to { opacity: 1; transform: translateY(0);}
    }
    .chart-card .stat-title {
        color: #0b5b57;
        font-size: 1.45rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.3rem;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 8px rgba(11,91,87,0.08);
        animation: fadeInUpBig .9s cubic-bezier(.4,2,.6,1);
    }
    .chart-card .stat-title i {
        font-size: 1.5rem;
        color: #0b5b57;
    }

    .table-card {
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        animation: fadeIn .8s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px);}
        to { opacity: 1; transform: translateY(0);}
    }

    .table thead {
        background: #0b5b57 !important;
    }

    .btn-week {
        background: #0b5b57;
        color: #fff !important;
        border-radius: 8px;
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        margin-right: 8px;
        transition: background .2s, color .2s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(11,91,87,0.08);
    }
    .btn-week:hover {
        background: #0e736e;
        color: #fff !important;
        box-shadow: 0 4px 16px rgba(11,91,87,0.13);
    }

    .card .fw-bold,
    .card .mb-2[style*="font-size:2rem"] {
        color: #0b5b57 !important;
    }
    .card .mb-2.text-muted {
        color: #0b5b57 !important;
    }
    #statusAktaRange,
    #statusAktaRange option {
        color: #0b5b57 !important;
    }
    .table-card h5,
    .table-card i.fa-list {
        color: #0b5b57 !important;
    }
    .table thead,
    .table thead tr,
    .table thead th {
        background: #f5f5f5 !important; /* Abu terang */
        color: #0b5b57 !important;      /* Hijau */
    }
    .alasan-ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        max-width: 220px;
        font-size: 0.97rem;
        line-height: 1.3;
        min-width: 80px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="dashboard-title mb-0">Dashboard Admin</h2>
        <div class="mt-2">
            <span class="stat-week-label">Minggu: {{ $startOfWeek->format('d M Y') }} - {{ $startOfWeek->copy()->addDays(4)->format('d M Y') }}</span>
        </div>
    </div>
    <div class="flex-grow-1 d-flex justify-content-center">
        <span id="dashboardClock" class="dashboard-clock" aria-live="polite"></span>
    </div>
    <div>
        <a href="?week={{ $prevWeek }}" class="btn btn-week">&laquo; Minggu Sebelumnya</a>
        <a href="?week={{ $nextWeek }}" class="btn btn-week">Minggu Berikutnya &raquo;</a>
    </div>
</div>

{{-- Card Statistik Atas --}}
<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="card-stat kelahiran text-center py-3">
            <span class="icon-bg"><i class="fa fa-baby"></i></span>
            <h6 class="mb-1">Akta Kelahiran</h6>
            <h3 class="mb-1">{{ $total_lahir }}</h3>
            <div class="desc mb-1">Total permohonan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat kematian text-center py-3">
            <span class="icon-bg"><i class="fa fa-skull-crossbones"></i></span>
            <h6 class="mb-1">Akta Kematian</h6>
            <h3 class="mb-1">{{ $total_mati }}</h3>
            <div class="desc mb-1">Total permohonan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat kawin text-center py-3">
            <span class="icon-bg"><i class="fa fa-ring"></i></span>
            <h6 class="mb-1">Akta Perkawinan</h6>
            <h3 class="mb-1">{{ $total_kawin }}</h3>
            <div class="desc mb-1">Total permohonan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat cerai text-center py-3">
            <span class="icon-bg"><i class="fa fa-heart-broken"></i></span>
            <h6 class="mb-1">Akta Perceraian</h6>
            <h3 class="mb-1">{{ $total_cerai }}</h3>
            <div class="desc mb-1">Total permohonan</div>
        </div>
    </div>
</div>

{{-- Bawahnya: Statistik & Status --}}
<div class="row mb-4 g-3">
    <div class="col-md-8">
        <div class="chart-card h-100">
            <div class="stat-title">
                <i class="fa fa-chart-bar"></i>
                Statistik Mingguan Akta
            </div>
            <canvas id="grafikAkta" height="80"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-4 p-3 h-100 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold" style="font-size:1.1rem; color:#0b5b57;">Status Pertambahan Perhari</span>
                <form method="get" id="statusAktaForm">
                    <select class="form-select form-select-sm w-auto" name="statusAktaRange" id="statusAktaRange" onchange="document.getElementById('statusAktaForm').submit()" style="color:#0b5b57;">
                        <option value="today" {{ request('statusAktaRange','today')=='today'?'selected':'' }} style="color:#0b5b57;">Hari Ini</option>
                        <option value="yesterday" {{ request('statusAktaRange')=='yesterday'?'selected':'' }} style="color:#0b5b57;">Kemarin</option>
                        <option value="3days" {{ request('statusAktaRange')=='3days'?'selected':'' }} style="color:#0b5b57;">3 Hari Lalu</option>
                        <option value="5days" {{ request('statusAktaRange')=='5days'?'selected':'' }} style="color:#0b5b57;">5 Hari Lalu</option>
                        <option value="7days" {{ request('statusAktaRange')=='7days'?'selected':'' }} style="color:#0b5b57;">7 Hari Lalu</option>
                        <option value="month" {{ request('statusAktaRange')=='month'?'selected':'' }} style="color:#0b5b57;">1 Bulan Lalu</option>
                    </select>
                </form>
            </div>
            <div class="mb-2" style="font-size:2rem;font-weight:700; color:#0b5b57;">
                {{ $status_total ?? 0 }}
            </div>
            <div class="mb-2 text-muted" style="font-size:0.98rem; color:#0b5b57;">Pertambahan permohonan akta</div>
            <div class="progress mb-3" style="height:7px;">
                <div class="progress-bar bg-info" style="width: {{ $persen_lahir ?? 0 }}%;" title="Kelahiran"></div>
                <div class="progress-bar bg-danger" style="width: {{ $persen_mati ?? 0 }}%;" title="Kematian"></div>
                <div class="progress-bar bg-primary" style="width: {{ $persen_kawin ?? 0 }}%;" title="Perkawinan"></div>
                <div class="progress-bar bg-warning" style="width: {{ $persen_cerai ?? 0 }}%;" title="Perceraian"></div>
            </div>
            <div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-info me-2" style="width:18px;height:18px;">&nbsp;</span>
                    <span class="flex-fill">Kelahiran</span>
                    <span class="badge bg-light text-info ms-2" style="font-size:0.95rem;">
                        +{{ $pertambahan_lahir ?? 0 }}
                    </span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-danger me-2" style="width:18px;height:18px;">&nbsp;</span>
                    <span class="flex-fill">Kematian</span>
                    <span class="badge bg-light text-danger ms-2" style="font-size:0.95rem;">
                        +{{ $pertambahan_mati ?? 0 }}
                    </span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2" style="width:18px;height:18px;">&nbsp;</span>
                    <span class="flex-fill">Perkawinan</span>
                    <span class="badge bg-light text-primary ms-2" style="font-size:0.95rem;">
                        +{{ $pertambahan_kawin ?? 0 }}
                    </span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-warning text-dark me-2" style="width:18px;height:18px;">&nbsp;</span>
                    <span class="flex-fill">Perceraian</span>
                    <span class="badge bg-light text-warning ms-2" style="font-size:0.95rem;">
                        +{{ $pertambahan_cerai ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Data Legalisir Terbaru --}}
<div class="table-card mb-4">
    <h5 class="mb-3 fw-bold" style="color:#0b5b57;">
        <i class="fa fa-list me-2" style="color:#0b5b57;"></i>Permohonan Terbaru
    </h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered rounded shadow-sm">
            <thead style="background:#0b5b57; color:#fff;">
                <tr>
                    <th class="text-center" style="width:40px;">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jenis Akta</th>
                    <th class="text-center">No Akta</th>
                    <th class="text-center">Alasan</th>
                    <th class="text-center">Gambar</th>
                    <th class="text-center">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest_legalisir as $i => $item)
                <tr>
                    <td class="text-center" style="font-weight: bold;">{{ $i+1 }}</td>
                    <td class="text-center">{{ $item->nama }}</td>
                    <td class="text-center">
                        <span class="badge
                            @if($item->jenis_akta == 'kelahiran') bg-info
                            @elseif($item->jenis_akta == 'kematian') bg-danger
                            @elseif($item->jenis_akta == 'perkawinan') bg-primary
                            @elseif($item->jenis_akta == 'perceraian') bg-warning text-dark
                            @else bg-secondary
                            @endif
                        ">
                            {{ ucfirst($item->jenis_akta) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $item->no_akta }}</td>
                    <td>
                        <span class="alasan-ellipsis" title="{{ $item->alasan }}">{{ $item->alasan }}</span>
                    </td>
                    <td class="text-center">
                        @if(!empty($item->gambar))
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Jam realtime
    function updateClock() {
        const now = new Date();
        const jam = now.getHours().toString().padStart(2, '0');
        const menit = now.getMinutes().toString().padStart(2, '0');
        const detik = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('dashboardClock').textContent = jam + ':' + menit + ':' + detik;
    }
    setInterval(updateClock, 1000);
    updateClock();

    var grafikAktaData = {
        labels: @json($labels),
        dataLahir: @json($data_lahir),
        dataMati: @json($data_mati),
        dataKawin: @json($data_kawin),
        dataCerai: @json($data_cerai)
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard-chart.js') }}"></script>
@endpush
@endsection