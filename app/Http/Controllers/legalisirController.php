<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_legalisir;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LegalisirController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $latest_legalisir = data_legalisir::orderBy('created_at', 'desc')->limit(10)->get();

        return view('dashboard', [
            'latest_legalisir' => $latest_legalisir,
        ]);
    }
    public function adminDashboard(Request $request)
    {
        // Hitung total masing-masing akta
        $total_lahir = data_legalisir::where('jenis_akta', 'kelahiran')->count();
        $total_mati = data_legalisir::where('jenis_akta', 'kematian')->count();
        $total_kawin = data_legalisir::where('jenis_akta', 'perkawinan')->count();
        $total_cerai = data_legalisir::where('jenis_akta', 'perceraian')->count();

        // Minggu aktif (default: minggu ini, bisa diganti dengan ?week=YYYY-MM-DD)
        $startOfWeek = $request->week ? Carbon::parse($request->week)->startOfWeek() : Carbon::now()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays(4); // Senin-Jumat

        // Ambil statistik per hari dan per akta
        $labels = [];
        $data_lahir = [];
        $data_mati = [];
        $data_kawin = [];
        $data_cerai = [];
        $dateIter = $startOfWeek->copy();
        while ($dateIter <= $endOfWeek) {
            $labels[] = $dateIter->format('D, d M');
            $data_lahir[] = data_legalisir::where('jenis_akta', 'kelahiran')->whereDate('created_at', $dateIter)->count();
            $data_mati[] = data_legalisir::where('jenis_akta', 'kematian')->whereDate('created_at', $dateIter)->count();
            $data_kawin[] = data_legalisir::where('jenis_akta', 'perkawinan')->whereDate('created_at', $dateIter)->count();
            $data_cerai[] = data_legalisir::where('jenis_akta', 'perceraian')->whereDate('created_at', $dateIter)->count();
            $dateIter->addDay();
        }

        // Navigasi minggu
        $prevWeek = $startOfWeek->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $startOfWeek->copy()->addWeek()->format('Y-m-d');

        // 10 data terakhir ditambahkan
        $latest_legalisir = data_legalisir::orderBy('created_at', 'desc')->limit(10)->get();

        // Status Pertambahan (filter waktu)
        $range = $request->input('statusAktaRange', 'today');
        $baseQuery = data_legalisir::query();

        // Filter waktu
        switch ($range) {
            case 'today':
                $baseQuery->whereDate('created_at', Carbon::today());
                break;
            case 'yesterday':
                $baseQuery->whereDate('created_at', Carbon::yesterday());
                break;
            case '3days':
                $baseQuery->whereBetween('created_at', [Carbon::now()->subDays(3)->startOfDay(), Carbon::now()->endOfDay()]);
                break;
            case '5days':
                $baseQuery->whereBetween('created_at', [Carbon::now()->subDays(5)->startOfDay(), Carbon::now()->endOfDay()]);
                break;
            case '7days':
                $baseQuery->whereBetween('created_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()]);
                break;
            case 'month':
                $baseQuery->whereMonth('created_at', Carbon::now()->subMonth()->month);
                break;
        }

        // Hitung total dan per jenis
        $status_total = $baseQuery->count();
        $status_lahir = (clone $baseQuery)->where('jenis_akta', 'kelahiran')->count();
        $status_mati = (clone $baseQuery)->where('jenis_akta', 'kematian')->count();
        $status_kawin = (clone $baseQuery)->where('jenis_akta', 'perkawinan')->count();
        $status_cerai = (clone $baseQuery)->where('jenis_akta', 'perceraian')->count();

        // Persentase progress bar
        $total = $status_total ?: 1;
        $persen_lahir = round($status_lahir / $total * 100, 2);
        $persen_mati = round($status_mati / $total * 100, 2);
        $persen_kawin = round($status_kawin / $total * 100, 2);
        $persen_cerai = round($status_cerai / $total * 100, 2);

        // Hitung pertambahan per jenis
        $pertambahan_lahir = (clone $baseQuery)->where('jenis_akta', 'kelahiran')->count();
        $pertambahan_mati = (clone $baseQuery)->where('jenis_akta', 'kematian')->count();
        $pertambahan_kawin = (clone $baseQuery)->where('jenis_akta', 'perkawinan')->count();
        $pertambahan_cerai = (clone $baseQuery)->where('jenis_akta', 'perceraian')->count();

        return view('admin.dashboard', compact(
            'total_lahir', 'total_mati', 'total_kawin', 'total_cerai',
            'labels', 'data_lahir', 'data_mati', 'data_kawin', 'data_cerai',
            'prevWeek', 'nextWeek', 'startOfWeek', 'latest_legalisir',
            'status_total', 'persen_lahir', 'persen_mati', 'persen_kawin', 'persen_cerai',
            'pertambahan_lahir', 'pertambahan_mati', 'pertambahan_kawin', 'pertambahan_cerai'
        ));
    }
    // Halaman Form Legalisir
    public function formLegalisir()
    {
        return view('admin.formLegalisir');
    }

    // Proses Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            "nama"       => "required|string|max:255",
            "jenis_akta" => "required|string",
            "no_akta"    => "required|string|max:255",
            "alasan"     => "required|string",
            "gambar"     => "required|image|mimes:jpg,jpeg,png|max:2048"
        ]);

        // Upload file
        $filePath = null;
        if ($request->hasFile("gambar")) {
            $filePath = $request->file("gambar")->store("legalisir", "public");
        }

        // Simpan ke database
        $data = data_legalisir::create([
            "nama"       => $request->nama,
            "jenis_akta" => $request->jenis_akta,
            "no_akta"    => $request->no_akta,
            "alasan"     => $request->alasan,
            "gambar"     => $filePath
        ]);

        // Redirect ke data legalisir dengan pesan sukses
        return redirect()->route('admin.data')
            ->with('success', 'Berhasil menambah data dengan Nomor Akta '.$data->no_akta)
            ->with('alert_type', 'success');
    }

    // Tampilkan semua data legalisir (opsional untuk daftar pengajuan)
    public function index()
    {
        $data = data_legalisir::latest()->paginate(10);
        return view("legalisir.index", compact("data"));
    }
   
    public function data(Request $request)
    {
        $query = \App\Models\data_legalisir::query();

        // Pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                  ->orWhere('no_akta', 'like', '%'.$request->search.'%');
            });
        }

        // Filter jenis akta
        if ($request->jenis_akta) {
            $query->where('jenis_akta', $request->jenis_akta);
        }

        // Filter tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.data', compact('data'));
    }

    public function edit($id)
    {
        $data = data_Legalisir::findOrFail($id);
        return view('admin.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = data_Legalisir::findOrFail($id);

        $request->validate([
            "nama"       => "required|string|max:255",
            "jenis_akta" => "required|string",
            "no_akta"    => "required|string|max:255",
            "alasan"     => "required|string",
            "gambar"     => "nullable|image|mimes:jpg,jpeg,png|max:2048"
        ]);

        if ($request->hasFile("gambar")) {
            $filePath = $request->file("gambar")->store("legalisir", "public");
            $data->gambar = $filePath;
        }

        $data->nama = $request->nama;
        $data->jenis_akta = $request->jenis_akta;
        $data->no_akta = $request->no_akta;
        $data->alasan = $request->alasan;
        $data->save();

        return redirect()->route('admin.data')
            ->with('success', 'Data dengan Nomor Akta '.$data->no_akta.' berhasil diupdate!')
            ->with('alert_type', 'warning');
    }

    public function delete($id)
    {
        $data = data_Legalisir::findOrFail($id);
        $no_akta = $data->no_akta;
        $data->delete();
        return redirect()->route('admin.data')
            ->with('success', 'Data dengan Nomor Akta '.$no_akta.' berhasil dihapus!')
            ->with('alert_type', 'danger');
    }

    // Halaman Laporan Legalisir
    public function laporan(Request $request)
    {
        $query = data_legalisir::query();
        // Filter jenis akta
        if ($request->jenis_akta) {
            $query->where('jenis_akta', $request->jenis_akta);
        }
        // Filter tanggal dan rentang waktu saling eksklusif
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        } elseif ($request->rentang) {
            switch ($request->rentang) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case '7days':
                    $query->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }
        $data = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.laporan', compact('data'));
    }
}

