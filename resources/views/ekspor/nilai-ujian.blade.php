<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>Benar</th>
            <th>Salah</th>
            <th>Tidak Dijawab</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ujian->waktuujian as $p)
            @if ($p->selesai == null)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->peserta->firstname }}</td>
                    <td colspan="4">Belum Mengerjakan Ujian</td>
                </tr>
            @else
                @php
                    $salah = 0;
                    $benar = 0;
                    $tidakDijawab = 0;
                @endphp
                @foreach ($p->pgpeserta as $jawaban)
                    @if ($jawaban->kode == $ujian->kode)
                        @if ($jawaban->benar == '0')
                            @php $salah++ @endphp
                        @endif
                        @if ($jawaban->benar == '1')
                            @php $benar++ @endphp
                        @endif
                        @if ($jawaban->benar === null)
                            @php $tidakDijawab++ @endphp
                        @endif
                    @endif
                @endforeach
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->peserta->firstname }}</td>
                    <td>{{ $benar }}</td>
                    <td>{{ $salah }}</td>
                    <td>{{ $tidakDijawab }}</td>
                    <td>
                        @php
                            $nilai = ($benar / $ujian->detailujian->count()) * 100;
                        @endphp
                        {{ round($nilai) }}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
