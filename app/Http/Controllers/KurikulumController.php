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
        $jadwal = DB::table('jadwal')
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        $editData = null;
        
        return view('kurikulum.jadwal', compact('canEdit', 'kelas', 'jadwal', 'editData'));
    }
    
    public function jadwalEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $jadwal = DB::table('jadwal')
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        $editData = DB::table('jadwal as j')
            ->leftJoin('kelas as k', 'j.id_kelas', '=', 'k.id_kelas')
            ->select('j.*', 'k.nama_kelas as kelas_nama')
            ->where('j.id_jadwal', $id)
            ->first();
        
        return view('kurikulum.jadwal', compact('canEdit', 'kelas', 'jadwal', 'editData'));
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
    
    public function materiIndex()
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $materi = DB::table('materi as m')
            ->leftJoin('kelas as k', 'm.id_kelas', '=', 'k.id_kelas')
            ->select('m.*', 'k.nama_kelas')
            ->orderBy('m.tanggal_upload', 'desc')
            ->get();
        $editData = null;
        
        return view('kurikulum.materi', compact('canEdit', 'kelas', 'materi', 'editData'));
    }
    
    public function materiEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $materi = DB::table('materi as m')
            ->leftJoin('kelas as k', 'm.id_kelas', '=', 'k.id_kelas')
            ->select('m.*', 'k.nama_kelas')
            ->orderBy('m.tanggal_upload', 'desc')
            ->get();
        $editData = DB::table('materi as m')
            ->leftJoin('kelas as k', 'm.id_kelas', '=', 'k.id_kelas')
            ->select('m.*', 'k.nama_kelas as kelas_nama')
            ->where('m.id_materi', $id)
            ->first();
        
        return view('kurikulum.materi', compact('canEdit', 'kelas', 'materi', 'editData'));
    }
    
    public function materiStore(Request $request)
    {
        if (!session('admin')) abort(403);
        
        DB::table('materi')->insert([
            'id_kelas' => $request->id_kelas,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_upload' => date('Y-m-d')
        ]);
        
        return redirect()->route('kurikulum.materi.index');
    }
    
    public function materiUpdate(Request $request, $id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('materi')->where('id_materi', $id)->update([
            'id_kelas' => $request->id_kelas,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ]);
        
        return redirect()->route('kurikulum.materi.index');
    }
    
    public function materiDestroy($id)
    {
        if (!session('admin')) abort(403);
        
        DB::table('materi')->where('id_materi', $id)->delete();
        
        return redirect()->route('kurikulum.materi.index');
    }
    
    public function guruIndex()
    {
        $canEdit = session('admin') ? true : false;
        $guru = DB::table('guru')->orderBy('id_guru', 'desc')->get();
        $editData = null;
        
        return view('kurikulum.guru', compact('canEdit', 'guru', 'editData'));
    }
    
    public function guruEdit($id)
    {
        $canEdit = session('admin') ? true : false;
        $guru = DB::table('guru')->orderBy('id_guru', 'desc')->get();
        $editData = DB::table('guru')->where('id_guru', $id)->first();
        
        return view('kurikulum.guru', compact('canEdit', 'guru', 'editData'));
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
