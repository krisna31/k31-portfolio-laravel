<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeCodeResource;
use App\Http\Resources\AttendeResource;
use App\Models\Attende;
use App\Models\AttendeCode;
use App\Models\AttendesHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        try {
            $addHour = env('APP_ENV') === 'local' ? 0 : 0;
            // add one more column check that if absensi is open or not based on start_date and end_date
            $absensi = AttendeCode::with(['attendeType', 'user', 'defaultApprovalStatus'])
                ->selectRaw(
                    '*,
                    (? >= start_date AND ? < end_date + INTERVAL \'1 hour\') as is_open,
                    (SELECT COUNT(*) >= 1 FROM attendes WHERE attendes.attende_code_id = attende_codes.id AND attendes.user_id = ? AND attende_time IS NOT NULL AND approval_status_id IS NOT NULL AND attende_status_id IS NOT NULL) as is_attended',
                    [now()->addHours($addHour), now()->addHours($addHour), auth()->user()->id]
                )
                ->when($request->over === 'yes', function ($query) use ($addHour) {
                    $query->whereRaw('end_date + INTERVAL \'1 hour\' < ?', [now()->addHours($addHour)]);
                })
                ->when($request->over === 'no', function ($query) use ($addHour) {
                    $query->whereRaw('end_date + INTERVAL \'1 hour\' > ?', [now()->addHours($addHour)]);
                })
                ->where(function ($query) {
                    $query->where('user_id', auth()->user()->id)
                        ->orWhere('user_id', 0);
                })
                ->orderBy('start_date', 'asc')
                ->orderBy('is_open', 'desc')
                ->get()
                ->map(function ($item) {
                    // parse to carbon date then change format to day, date month year hour:minute:second use indonesian languange
                    Carbon::setLocale('id');
                    $item->start_date = Carbon::parse($item->start_date)->format('l, d F Y H:i:s');
                    $item->end_date = Carbon::parse($item->end_date)->format('l, d F Y H:i:s');
                    return $item;
                });
            // ->paginate(10);

            return AttendeCodeResource::collection($absensi)
                ->additional([
                    'error' => false,
                    'message' => 'data presensi berhasil ditemukan',
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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image',
            'attende_status' => 'required|exists:attende_statuses,id',
        ]);

        $addHour = env('APP_ENV') === 'local' ? 0 : 0;

        $absensi = AttendeCode::query()
            ->selectRaw(
                '*,
                    (? >= start_date AND ? < end_date + INTERVAL \'1 hour\') as is_open,
                    (? > end_date) as is_late,
                    (SELECT COUNT(*) >= 1 FROM attendes WHERE attendes.attende_code_id = attende_codes.id AND attendes.user_id = ? AND attende_time IS NOT NULL AND approval_status_id IS NOT NULL AND attende_status_id IS NOT NULL) as is_attended',
                [now()->addHours($addHour), now()->addHours($addHour), now()->addHours($addHour), auth()->user()->id]
            )
            ->firstWhere('id', $request->code);

        if ($absensi->is_attended === 1) {
            return response()->json([
                'error' => true,
                'message' => 'Anda sudah melakukan presensi',
            ], 403);
        }

        // return response()->json([ 'data' => $absensi, ]);

        if ($absensi->is_open === 0) {
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
        $photo->storeAs('public/attendes-histories-photos', $photo->hashName());
        $photo->storeAs('public/attende-photos', $photo->hashName());

        try {
            DB::beginTransaction();
            AttendesHistory::query()
                ->create([
                    'user_id' => auth()->user()->id,
                    'attende_code_id' => $request->code,
                    'approval_status_id' => $absensi->default_approval_status_id,
                    'attende_status_id' => $absensi->is_late ? 2 : $request->attende_status, // 2 is for Terlambat
                    'attende_time' => now(),
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'photo' => [
                        'attendes-histories-photos/' . $photo->hashName(),
                    ],
                    'is_spoofing' => $request->is_spoofing ?? 1,
                ]);

            Attende::query()
                ->updateOrCreate([
                    'attende_code_id' => $request->code,
                    'user_id' => auth()->user()->id,
                ], [
                    'user_id' => auth()->user()->id,
                    'attende_code_id' => $request->code,
                    'approval_status_id' => $absensi->default_approval_status_id,
                    'attende_status_id' => $absensi->is_late ? 2 : $request->attende_status, // 2 is for Terlambat
                    'attende_time' => now(),
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'photo' => [
                        'attende-photos/' . $photo->hashName(),
                    ],
                ]);

            DB::commit();
            return response()->json([
                'error' => false,
                'message' => 'Presensi berhasil',
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function storeRiwayatPresensi(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:attende_codes,id',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_spoofing' => 'required|boolean',
            'photo' => 'required|image',
            'attende_status' => 'required|exists:attende_statuses,id',
        ]);

        $addHour = env('APP_ENV') === 'local' ? 0 : 0;

        $absensi = AttendeCode::query()
            ->selectRaw(
                '*,
                    (? >= start_date AND ? < end_date + INTERVAL \'1 hour\') as is_open,
                    (? > end_date) as is_late,
                    (SELECT COUNT(*) >= 1 FROM attendes WHERE attendes.attende_code_id = attende_codes.id AND attendes.user_id = ? AND attende_time IS NOT NULL AND approval_status_id IS NOT NULL AND attende_status_id IS NOT NULL) as is_attended',
                [now()->addHours($addHour), now()->addHours($addHour), now()->addHours($addHour), auth()->user()->id]
            )
            ->firstWhere('id', $request->code);

        if ($absensi->is_attended === 1) {
            return response()->json([
                'error' => true,
                'message' => 'Anda sudah melakukan presensi',
            ], 403);
        }

        if ($absensi->is_open === 0) {
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
        $photo->storeAs('public/attendes-histories-photos', $photo->hashName());

        AttendesHistory::query()
            ->create([
                'user_id' => auth()->user()->id,
                'attende_code_id' => $request->code,
                'approval_status_id' => $absensi->default_approval_status_id,
                'attende_status_id' => $absensi->is_late ? 2 : $request->attende_status, // 2 is for Terlambat
                'attende_time' => now(),
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'photo' => [
                    'attendes-histories-photos/' . $photo->hashName(),
                ],
                'is_spoofing' => $request->is_spoofing == 't' ? 1 : 0,
            ]);

        return response()->json([
            'error' => false,
            'message' => 'Riwayat Presens Berhasi Ditambahkan',
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
                    'message' => 'data riwayat presensi berhasil ditemukan',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
