<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeCodeResource;
use App\Http\Resources\AttendeResource;
use App\Models\Attende;
use App\Models\AttendeCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        try {
            // add one more column check that if absensi is open or not based on start_date and end_date
            $absensi = AttendeCode::with(['attendeType', 'user', 'defaultApprovalStatus'])
                ->selectRaw(
                    '*,
                    (start_date < ? AND end_date > ?) as is_open,
                    (SELECT COUNT(*) >= 1 FROM attendes WHERE attendes.attende_code_id = attende_codes.id AND attendes.user_id = ?) as is_attended',
                    [now()->addHours(7), now()->addHours(7), auth()->user()->id]
                )
                ->when($request->over === 'yes', function ($query) {
                    $query->where('end_date', '<', now()->addHours(7));
                })
                ->when($request->over === 'no', function ($query) {
                    $query->where('end_date', '>', now()->addHours(7));
                })
                ->where(function ($query) {
                    $query->where('user_id', auth()->user()->id)
                        ->orWhere('user_id', 0);
                })
                ->orderBy('is_open', 'desc')
                ->get();
            // ->paginate(10);

            return AttendeCodeResource::collection($absensi)
                ->additional([
                    'error' => false,
                    'message' => 'data absensi berhasil ditemukan',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:attende_codes,id',
            'address' => 'required|string',
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

        if ($absensi->start_date > now()->addHours(7) || $absensi->end_date < now()->addHours(7)) {
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
            'attende_time' => now()->addHours(7),
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo' => [
                'attende-photos/' . $photo->hashName(),
            ],
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Absensi berhasil',
        ], 201);
    }

    public function getAbsenHistory()
    {
        try {
            $absensi = Attende::with(['user', 'attendeCode', 'approvalStatus', 'attendeStatus'])
                ->where('user_id', auth()->user()->id)
                ->orderBy('attende_time', 'desc')
                ->get();

            return AttendeResource::collection($absensi)
                ->additional([
                    'error' => false,
                    'message' => 'data riwayat absensi berhasil ditemukan',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
