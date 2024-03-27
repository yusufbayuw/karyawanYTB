@php    
use App\Models\Penilaian;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penilaian {{ $periode_aktif }}</title>
</head>
<body>
    <div>
        <table>
            <thead>
                <tr>
                    <th>
                        Periode
                    </th>
                    <th>
                        Unit
                    </th>
                    <th>
                        NIP
                    </th>
                    <th>
                        Pegawai
                    </th>
                    <th colspan="5">
                        Parameter
                    </th>
                    <th>
                        Angka Kredit
                    </th>
                    <th>
                        Kuantitas
                    </th>
                    <th>
                        Hasil Kerja
                    </th>
                    <th>
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaians as $penilaian)
                <tr>
                    <td>
                        {{ $penilaian->nama }}
                    </td>
                    <td>
                        {{ $penilaian->unit }}
                    </td>
                    <td>
                        {{ $penilaian->username }}
                    </td>
                    <td>
                        {{ $penilaian->name }}
                    </td>
                    @php
                        $ancestors = array_reverse(Penilaian::find($penilaian->id)->parameter->ancestorsAndSelf->toArray());
                        $ancestors_length = count($ancestors);
                    @endphp
                    @foreach ($ancestors as $ancestor)
                        <td>
                            {{$ancestor["title"]}}
                        </td>
                    @endforeach
                    @if ($ancestors_length === 4)
                        <td></td>
                    @elseif ($ancestors_length === 3)
                        <td></td>
                        <td></td>
                    @elseif ($ancestors_length === 2)
                        <td></td>
                        <td></td>
                        <td></td>
                    @elseif ($ancestors_length === 1)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td>
                        {{ $penilaian->angka_kredit }}
                    </td>
                    <td>
                        {{ $penilaian->nilai }}
                    </td>
                    <td>
                        {{ $penilaian->hasil_kerja }}
                    </td>
                    <td>
                        {{ $penilaian->jumlah }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>