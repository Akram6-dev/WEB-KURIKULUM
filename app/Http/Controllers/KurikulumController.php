<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KurikulumController extends Controller
{
    public function index()
    {
        $programs = DB::connection('mysql')->table('jurusan')->orderBy('id_jurusan')->get();
        return view('kurikulum.index', compact('programs'));
    }
    
    public function jurusanDetail($id)
    {
        $jurusan = DB::table('jurusan')->where('id_jurusan', $id)->first();
        $tingkat = request('tingkat');
        $kelasList = [];
        
        if ($tingkat) {
            $kelasList = DB::table('kelas as k')
                ->leftJoin(DB::raw('(SELECT id_kelas, COUNT(*) as jumlah_siswa FROM siswa GROUP BY id_kelas) as s'), 'k.id_kelas', '=', 's.id_kelas')
                ->select('k.*', DB::raw('COALESCE(s.jumlah_siswa, 0) as jumlah_siswa'))
                ->where('k.id_jurusan', $id)
                ->where('k.tingkat', $tingkat)
                ->orderBy('k.nama_kelas')
                ->get();
        }
        
        return view('kurikulum.jurusan_detail', compact('jurusan', 'tingkat', 'kelasList'));
    }
    
    public function kelasDetail($id)
    {
        $kelas = DB::table('kelas as k')
            ->leftJoin('jurusan as j', 'k.id_jurusan', '=', 'j.id_jurusan')
            ->leftJoin(DB::raw('(SELECT id_kelas, COUNT(*) as jumlah_siswa, SUM(jk="L") as laki, SUM(jk="P") as perempuan FROM siswa GROUP BY id_kelas) as s'), 'k.id_kelas', '=', 's.id_kelas')
            ->select('k.*', 'j.nama_jurusan', DB::raw('COALESCE(s.jumlah_siswa, 0) as jumlah_siswa'), DB::raw('COALESCE(s.laki, 0) as laki'), DB::raw('COALESCE(s.perempuan, 0) as perempuan'))
            ->where('k.id_kelas', $id)
            ->first();
        
        $siswa = DB::table('siswa')->where('id_kelas', $id)->orderBy('nama_siswa')->get();
        
        return view('kurikulum.kelas_detail', compact('kelas', 'siswa'));
    }
    
    public function absensiIndex()
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        
        $query = DB::table('absensi as a')
            ->leftJoin('kelas as k', 'a.id_kelas', '=', 'k.id_kelas')
            ->select('a.*', 'k.nama_kelas');
        
        if (request('kelas')) {
            $query->where('a.id_kelas', request('kelas'));
        }
        if (request('tgl')) {
            $query->where('a.tanggal', request('tgl'));
        }
        
        $absensi = $query->orderBy('a.tanggal', 'desc')->orderBy('a.nama')->get();
        $editData = null;
        
        return view('kurikulum.absensi', compact('canEdit', 'kelas', 'absensi', 'editData'));
    }
    
    public function absensiEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        
        $query = DB::table('absensi as a')
            ->leftJoin('kelas as k', 'a.id_kelas', '=', 'k.id_kelas')
            ->select('a.*', 'k.nama_kelas');
        
        if (request('kelas')) {
            $query->where('a.id_kelas', request('kelas'));
        }
        if (request('tgl')) {
            $query->where('a.tanggal', request('tgl'));
        }
        
        $absensi = $query->orderBy('a.tanggal', 'desc')->orderBy('a.nama')->get();
        $editData = DB::table('absensi')->where('id_absen', $id)->first();
        
        return view('kurikulum.absensi', compact('canEdit', 'kelas', 'absensi', 'editData'));
    }
    
    public function absensiStore(Request $request)
    {
        if (!session('admin')) abort(403);
        
        DB::table('absensi')->insert([
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'status' => $request->status
        ]);
        
        return redirect()->route('kurikulum.absensi.index');
    }
    
    public function absensiUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('absensi')->where('id_absen', $id)->update([
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'status' => $request->status
        ]);
        
        return redirect()->route('kurikulum.absensi.index');
    }
    
    public function absensiDestroy($id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('absensi')->where('id_absen', $id)->delete();
        
        return redirect()->route('kurikulum.absensi.index');
    }
    
    public function siswaIndex()
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $siswa = DB::table('siswa as s')
            ->leftJoin('kelas as k', 's.id_kelas', '=', 'k.id_kelas')
            ->select('s.*', 'k.nama_kelas')
            ->orderBy('s.id_siswa', 'desc')
            ->get();
        $editData = null;
        
        return view('kurikulum.siswa', compact('canEdit', 'kelas', 'siswa', 'editData'));
    }
    
    public function siswaEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $siswa = DB::table('siswa as s')
            ->leftJoin('kelas as k', 's.id_kelas', '=', 'k.id_kelas')
            ->select('s.*', 'k.nama_kelas')
            ->orderBy('s.id_siswa', 'desc')
            ->get();
        $editData = DB::table('siswa as s')
            ->leftJoin('kelas as k', 's.id_kelas', '=', 'k.id_kelas')
            ->select('s.*', 'k.nama_kelas as kelas_nama')
            ->where('s.id_siswa', $id)
            ->first();
        
        return view('kurikulum.siswa', compact('canEdit', 'kelas', 'siswa', 'editData'));
    }
    
    public function siswaStore(Request $request)
    {
        if (!session('admin')) abort(403);
        
        DB::table('siswa')->insert([
            'nama_siswa' => $request->nama,
            'nis' => $request->nis,
            'id_kelas' => $request->id_kelas,
            'jk' => $request->jk
        ]);
        
        return redirect()->route('kurikulum.siswa.index');
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('siswa')->where('id_siswa', $id)->update([
            'nama_siswa' => $request->nama,
            'nis' => $request->nis,
            'id_kelas' => $request->id_kelas,
            'jk' => $request->jk
        ]);
        
        return redirect()->route('kurikulum.siswa.index');
    }
    
    public function siswaDestroy($id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('siswa')->where('id_siswa', $id)->delete();
        
        return redirect()->route('kurikulum.siswa.index');
    }
    
    public function jadwalIndex()
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $mapel = DB::table('mata_pelajaran')->orderBy('kategori')->orderBy('nama_mapel')->get();
        $jadwal = DB::table('jadwal')
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        $editData = null;
        return view('kurikulum.jadwal', compact('canEdit', 'kelas', 'mapel', 'jadwal', 'editData'));
    }

    public function jadwalEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $mapel = DB::table('mata_pelajaran')->orderBy('kategori')->orderBy('nama_mapel')->get();
        $jadwal = DB::table('jadwal')
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        $editData = DB::table('jadwal as j')
            ->leftJoin('kelas as k', 'j.id_kelas', '=', 'k.id_kelas')
            ->select('j.*', 'k.nama_kelas as kelas_nama', 'k.nama_kelas')
            ->where('j.id_jadwal', $id)
            ->first();
        return view('kurikulum.jadwal', compact('canEdit', 'kelas', 'mapel', 'jadwal', 'editData'));
    }
    
    public function jadwalStore(Request $request)
    {
        if (!session('admin')) abort(403);
        
        $kelasNama = DB::table('kelas')->where('id_kelas', $request->id_kelas)->value('nama_kelas');
        
        DB::table('jadwal')->insert([
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mapel' => $request->mapel,
            'guru_pengampu' => $request->guru,
            'kelas' => $kelasNama
        ]);
        
        return redirect()->route('kurikulum.jadwal.index');
    }
    
    public function jadwalUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        
        $kelasNama = DB::table('kelas')->where('id_kelas', $request->id_kelas)->value('nama_kelas');
        
        DB::table('jadwal')->where('id_jadwal', $id)->update([
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mapel' => $request->mapel,
            'guru_pengampu' => $request->guru,
            'kelas' => $kelasNama
        ]);
        
        return redirect()->route('kurikulum.jadwal.index');
    }
    
    public function jadwalDestroy($id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('jadwal')->where('id_jadwal', $id)->delete();
        
        return redirect()->route('kurikulum.jadwal.index');
    }
    

    public function guruIndex()
    {
        $canEdit = session('admin') ? true : false;
        $mapel = DB::table('mata_pelajaran')->orderBy('kategori')->orderBy('nama_mapel')->get();
        $guru = DB::table('guru')->orderBy('id_guru', 'desc')->get();
        $editData = null;
        
        return view('kurikulum.guru', compact('canEdit', 'guru', 'editData', 'mapel'));
    }
    
    public function guruEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $mapel = DB::table('mata_pelajaran')->orderBy('kategori')->orderBy('nama_mapel')->get();
        $guru = DB::table('guru')->orderBy('id_guru', 'desc')->get();
        $editData = DB::table('guru')->where('id_guru', $id)->first();
        
        return view('kurikulum.guru', compact('canEdit', 'guru', 'editData', 'mapel'));
    }
    
    public function guruStore(Request $request)
    {
        if (!session('admin')) abort(403);
        
        DB::table('guru')->insert([
            'nama_guru' => $request->nama,
            'nip' => $request->nip,
            'mapel' => $request->mapel
        ]);
        
        return redirect()->route('kurikulum.guru.index');
    }
    
    public function guruUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('guru')->where('id_guru', $id)->update([
            'nama_guru' => $request->nama,
            'nip' => $request->nip,
            'mapel' => $request->mapel
        ]);
        
        return redirect()->route('kurikulum.guru.index');
    }
    
    public function guruDestroy($id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('guru')->where('id_guru', $id)->delete();
        
        return redirect()->route('kurikulum.guru.index');
    }
    
    public function kelasIndex()
    {
        $canEdit = session('admin') ? true : false;
        $guru = DB::table('guru')->orderBy('nama_guru')->get();
        $kelas = DB::table('kelas as k')
            ->leftJoin('jurusan as j', 'k.id_jurusan', '=', 'j.id_jurusan')
            ->select('k.*', 'j.nama_jurusan')
            ->orderBy('k.tingkat')
            ->orderBy('k.nama_kelas')
            ->get();

        $acakan = session('wali_kelas_acak');
        if ($acakan) {
            $kelas = $kelas->map(function ($k) use ($acakan) {
                if (isset($acakan[$k->id_kelas])) {
                    $k->wali_kelas = $acakan[$k->id_kelas];
                }
                return $k;
            });
        }

        $editData = null;
        return view('kurikulum.wali_kelas', compact('canEdit', 'guru', 'kelas', 'editData'));
    }

    public function kelasEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $guru = DB::table('guru')->orderBy('nama_guru')->get();
        $kelas = DB::table('kelas as k')
            ->leftJoin('jurusan as j', 'k.id_jurusan', '=', 'j.id_jurusan')
            ->select('k.*', 'j.nama_jurusan')
            ->orderBy('k.tingkat')
            ->orderBy('k.nama_kelas')
            ->get();
        $editData = DB::table('kelas')->where('id_kelas', $id)->first();
        return view('kurikulum.wali_kelas', compact('canEdit', 'guru', 'kelas', 'editData'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        DB::table('kelas')->where('id_kelas', $id)->update([
            'wali_kelas' => $request->wali_kelas
        ]);
        return redirect()->route('kurikulum.kelas.index');
    }

    public function kelasAcak()
    {
        if (!session('admin')) abort(403);

        $kelasList = DB::table('kelas')->orderBy('tingkat')->orderBy('nama_kelas')->get(['id_kelas', 'wali_kelas']);

        $guruList = $kelasList->pluck('wali_kelas')->filter()->values()->toArray();
        if (empty($guruList)) {
            return redirect()->route('kurikulum.kelas.index')->with('error', 'Belum ada data wali kelas.');
        }

        shuffle($guruList);

        $acakan = [];
        foreach ($kelasList as $i => $k) {
            $acakan[$k->id_kelas] = $guruList[$i % count($guruList)];
        }

        session(['wali_kelas_acak' => $acakan]);
        return redirect()->route('kurikulum.kelas.index');
    }

    public function kelasReset()
    {
        if (!session('admin')) abort(403);
        session()->forget('wali_kelas_acak');
        return redirect()->route('kurikulum.kelas.index');
    }

    public function loginForm()
    {
        return view('kurikulum.login', ['error' => '']);
    }
    
    public function loginPost(Request $request)
    {
        $user = DB::table('admin')->where('username', $request->username)->first();
        
        if ($user && $request->password === $user->password) {
            session(['admin' => $request->username]);
            return redirect()->route('kurikulum.index');
        }
        
        $error = $user ? 'Password salah' : 'User tidak ditemukan';
        return view('kurikulum.login', compact('error'));
    }
    
    public function logout()
    {
        session()->forget('admin');
        return redirect()->route('kurikulum.index');
    }
}
