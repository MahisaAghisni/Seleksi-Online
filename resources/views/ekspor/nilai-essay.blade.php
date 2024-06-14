<table>
        <thead>
            <tr class="text-center">
                <th>Nama Siswa</th>
                <th>Soal Dijawab</th>
                <th>Tidak dijawab</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ujian->waktuujian as $s)
                @if ($s->selesai == null)
                    <tr class="text-center">
                        <td>{{ $s->siswa->nama_siswa }}</td>
                        <td colspan="3">Belum Mengerjakan Ujian</td>
                    </tr>
                @else
                    <tr class="text-center">
                        @php
                            $soalDijawab = 0;
                            $tidakDijawab = 0;
                        @endphp
                        @foreach ($s->essaysiswa as $soal)
                            @if ($soal->kode == $ujian->kode)
                                @if ($soal->jawaban === null)
                                    @php $tidakDijawab++ @endphp
                                @endif
                                @if ($soal->jawaban !== null)
                                    @php $soalDijawab++ @endphp
                                @endif
                            @endif
                        @endforeach
                        <td>{{ $s->siswa->nama_siswa }}</td>
                        <td>{{ $soalDijawab }}</td>
                        <td>{{ $tidakDijawab }}</td>
                        <td>{{ $s->essaysiswa->sum('nilai') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>