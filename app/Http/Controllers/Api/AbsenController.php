<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attende;
use App\Models\AttendeCode;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index()
    {
        $absensi = AttendeCode::query()
            ->where(function ($query) {
                $query->where('user_id', auth()->user()->id)
                    ->orWhere('user_id', 0);
            })
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'data absensi berhasil ditemukan',
            'listAbsensi' => $absensi,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:attende_codes,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required|image',
            'attende_status' => 'required|exists:attende_statuses,id',
        ]);

        $existAbsensi = Attende::query()
            ->where('attende_code_id', $request->code)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($existAbsensi) {
            return response()->json([
                'error' => true,
                'message' => 'Anda sudah melakukan absensi',
            ], 403);
        }

        $absensi = AttendeCode::query()
            ->where('id', $request->code)
            ->first();

        if ($absensi->start_date > now() || $absensi->end_date < now()) {
            return response()->json([
                'error' => true,
                'message' => 'Absensi belum dimulai atau sudah berakhir silahkan kontak admin jika anda merasa ini adalah kesalahan',
            ], 403);
        }

        if ($absensi->user_id != 0 && $absensi->user_id != auth()->user()->id) {
            return response()->json([
                'error' => true,
                'message' => 'Absen ini tidak untuk anda, silahkan kontak admin jika anda merasa ini adalah kesalahan',
            ], 403);
        }

        $photo = $request->file('photo');
        $photo->storeAs('public/attende-photos', $photo->hashName());

        $absensi->attendes()->create([
            'user_id' => auth()->user()->id,
            'attende_code_id' => $request->code,
            'approval_status_id' => $absensi->default_approval_status_id,
            'attende_status_id' => $request->attende_status,
            'attende_time' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo' => [
                'attende-photos/' . $photo->hashName(),
            ],
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Absensi berhasil',
        ]);
    }
}
