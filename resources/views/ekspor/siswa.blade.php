<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIP/NIK</th>
            <th>Nama Siswa</th>
            <th>Gender</th>
            <th>Kelas</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->gender }}</td>
                <td>{{ $s->kelas->nama_kelas }}</td>
                <td>{{ $s->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
