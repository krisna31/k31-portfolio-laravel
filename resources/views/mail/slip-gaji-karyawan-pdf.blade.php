<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji</title>
</head>
<body>
    <img src="{{ public_path('assets/pictures/logo-panjang.jpg') }}"
    alt="Logo PT Anugerah Alam Konstruksi" width="100%" />
    <hr>
    <p style="text-align: right">{{ $bulan }} {{ $data['tahun'] }}</p>
    <br />
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
            <td>{{ $user->position->salary }} * {{ $jumlahKehadiran }} = {{ $user->position->salary * $jumlahKehadiran }}</td>
        </tr>
        <tr>
            <td>Uang Makan</td>
            <td>:</td>
            <td>{{ $user->position->eat_allowance }} * {{ $jumlahKehadiran }} = {{ $user->position->eat_allowance * $jumlahKehadiran }}</td>
        </tr>
        <tr>
            <td>Uang Transport</td>
            <td>:</td>
            <td>{{ $user->position->transport_allowance }} * {{ $jumlahKehadiran }} = {{ $user->position->transport_allowance * $jumlahKehadiran }}</td>
        </tr>
        <tr>
            <td>Total Gaji</td>
            <td>:</td>
            <td>{{ $totalGaji }}</td>
        </tr>
    </table>
    <hr />
    <table width="50%">
        <tr style="margin-bottom: 50px">
            <td><b>Disetujui Oleh</b></td>
            <td><b>Diterima Oleh</b></td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    <table width="50%">
        <tr>
            <td><b>Direktur Finance</b></td>
            <td><b>{{ $user->name }}</b></td>
        </tr>
    </table>
</body>
</html>
