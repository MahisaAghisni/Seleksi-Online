<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIP/NIK</th>
            <th>Nama Siswa</th>
            <th>Tanggal Lahir</th>
            <th>Gender</th>
            <th>Pelatihan</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->nama_peserta }}</td>
                <td>{{ $p->tanggal_lahir }}</td>
                <td>{{ $p->gender }}</td>
                <td>{{ $p->pelatihan->nama_pelatihan }}</td>
                <td>{{ $p->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
