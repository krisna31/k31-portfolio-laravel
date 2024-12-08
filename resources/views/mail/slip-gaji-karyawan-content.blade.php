<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji</title>
</head>
<body>
    {{-- <img src="{{ $message->embed(asset('assets/pictures/logo-panjang.jpg')) }}" alt="Logo Perusahaan" width="100%" /> --}}
    <h2>Slip Gaji <b>{{ $user->nomor_induk_pegawai }}/{{ $user->name }}</b></h2>
    <h3 style="text-align: right">{{ $bulan }} {{ $data['tahun'] }}</h3>
    <hr />
    <table width="100%">
        <tr>
            <td>NIP/Nama</td>
            <td>:</td>
            <td><b>{{ $user->nomor_induk_pegawai }}/{{ $user->name }}</b></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $user->position->name }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $user->position->department->name }}</td>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>:</td>
            <td>{{ 'Rp ' . number_format($user->position->salary, 0, ',', '.') }} * {{ $jumlahKehadiran }} = {{ 'Rp ' . number_format($user->position->salary * $jumlahKehadiran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Uang Makan</td>
            <td>:</td>
            <td>{{ 'Rp ' . number_format($user->position->eat_allowance, 0, ',', '.') }} * {{ $jumlahKehadiran }} = {{ 'Rp ' . number_format($user->position->eat_allowance * $jumlahKehadiran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Uang Transport</td>
            <td>:</td>
            <td>{{ 'Rp ' . number_format($user->position->transport_allowance, 0, ',', '.') }} * {{ $jumlahKehadiran }} = {{ 'Rp ' . number_format($user->position->transport_allowance * $jumlahKehadiran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Gaji</td>
            <td>:</td>
            <td>{{ $totalGaji }}</td>
        </tr>
    </table>
    <hr />
    <p>
        <i>Detail slip gaji dapat dilihat pada file yang terlampir.</i>
    </p>
    <br />
    <table width="50%">
        <tr>
            <td><b>Hormat Saya,</b></td>
        </tr>
        <tr height="50px">
            <td></td>
        </tr>
        <tr>
            <td><b>HRD Perusahaan</b></td>
        </tr>
    </table>
</body>
</html>
