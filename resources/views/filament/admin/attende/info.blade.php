@if ($record->attende_time != null && $record->attende_status_id != null && $record->approval_status_id != null)
    <div>
        <h1>Pegawai ini <b>{{ str()->upper("belum melakukan presensi") }}</b>
        </h1>
        <span style="font-size: .88rem; color: gray">Yang artinya status persetujuan belum bisa diubah, silahkan hubungi administrator
            anda jika ada kesalahan</span>
    </div>
@else
    <div>
        <h1>Data Status Persetujuan Presensi ini sudah berstatus <b>{{ str()->upper($record->approvalStatus->name) }}</b>
        </h1>
        <span style="font-size: .88rem; color: gray">Yang artinya sudah tidak bisa diubah lagi, silahkan hubungi administrator
            anda jika ada kesalahan</span>
    </div>
@endif
