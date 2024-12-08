<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $fileName }}</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        html {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px 10px 10px 10px;
        }

        table td,
        th {
            border-color: #ededed;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        table th {
            font-weight: normal;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .user-summary {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status-count {
            font-size: 16px;
            margin: 5px 0;
        }

        .status-count span {
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        $dataGroup = $rows->groupBy(function ($item) {
            return $item['user.name'];
        });
    @endphp
    <img src="{{ public_path('assets/pictures/logo-panjang.png') }}" alt="Logo Perusahaan"
        width="100%" />
    @if ($dataGroup->count() > 1)
        <div class="header">
            <h2>Total Kehadiran: {{ count($rows) }} Presensi</h2>
        </div>
    @endif
    @foreach ($dataGroup as $userName => $userRows)
        <div class="user-summary">
            <div class="user-name">{{ $userName }}</div>
            @php
                // $disetujuiCount = $userRows
                //     ->filter(function ($row) {
                //         return $row['approvalStatus.name'] === 'Disetujui';
                //     })
                //     ->count();
                // $ditolakCount = $userRows
                //     ->filter(function ($row) {
                //         return $row['approvalStatus.name'] === 'Ditolak';
                //     })
                //     ->count();
                // $menungguPersetujuanCount = $userRows
                //     ->filter(function ($row) {
                //         return $row['approvalStatus.name'] === 'Menunggu Persetujuan';
                //     })
                //     ->count();
                $total = count($userRows);
                $hadir = $userRows
                    ->filter(function ($row) {
                        return $row['attendeStatus.name'] === 'Hadir';
                    })
                    ->count();
                $tidakHadir = $userRows
                    ->filter(function ($row) {
                        return $row['attendeStatus.name'] == 'Tidak Hadir';
                    })
                    ->count();
                $late = $userRows
                    ->filter(function ($row) {
                        return $row['attendeStatus.name'] === 'Terlambat';
                    })
                    ->count();
            @endphp
            <p class="status-count">Total Presensi: <span>{{ $total }}</span></p>
            <p class="status-count">Hadir: <span>{{ $hadir }}</span></p>
            <p class="status-count">Tidak Hadir: <span>{{ $tidakHadir }}</span></p>
            <p class="status-count">Terlambat: <span>{{ $late }}</span></p>
        </div>
    @endforeach
    <table>
        <tr>
            @foreach ($columns as $column)
                <th>
                    {{ $column->getLabel() }}
                </th>
            @endforeach
        </tr>
        @foreach ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>
                        {{ $row[$column->getName()] }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>

</html>
