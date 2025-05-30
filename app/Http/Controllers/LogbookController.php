<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;

class LogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::where('nim', session('user')->nim)->orderBy('tanggal')->get();
        return view('mahasiswa.logbook', compact('logbooks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian_kegiatan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'yang_terlibat' => 'required',
        ]);
        Logbook::create([
            'nim' => session('user')->nim,
            'tanggal' => $request->tanggal,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'yang_terlibat' => $request->yang_terlibat,
        ]);
        return redirect()->route('logbook.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian_kegiatan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'yang_terlibat' => 'required',
        ]);
        $logbook = Logbook::where('id_logbook', $id)->where('nim', session('user')->nim)->firstOrFail();
        $logbook->update($request->only(['tanggal', 'uraian_kegiatan', 'waktu_mulai', 'waktu_selesai', 'yang_terlibat']));
        return redirect()->route('logbook.index');
    }

    public function destroy($id)
    {
        $logbook = Logbook::where('id_logbook', $id)->where('nim', session('user')->nim)->firstOrFail();
        $logbook->delete();
        return redirect()->route('logbook.index');
    }
}
