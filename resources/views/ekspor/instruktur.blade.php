<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Instruktur</th>
            <th>Gender</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($instruktur as $ins)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $ins->nama_instruktur }}</td>
                <td>{{ $ins->gender }}</td>
                <td>{{ $ins->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
