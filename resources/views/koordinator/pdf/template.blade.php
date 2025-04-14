<!DOCTYPE html> 
<html> 
<head> 
    <title>Export PDF</title> 
</head> 
<body> 
    <h2>Laporan Peminjaman</h2> 
    <table> 
        <thead> 
            <tr> 
                <th>ID Peminjaman</th> 
                <th>Judul Buku</th> 
                <th>Nama Member</th> 
                <th>Tanggal Pinjam</th> 
                <th>Tanggal Kembali</th> 
            </tr> 
        </thead> 
        <tbody> 
            @foreach($data as $p)
                <tr>
                    <td>{{ $p->id_pinjem }}</td>
                    <td>{{ $p->buku->judul}}</td>
                    <td>{{ $p->member->nama}}</td>
                    <td>{{ $p->tgl_pinjam}}</td>
                    <td>{{ $p->tgl_kembali}}</td>
                </tr>
            @endforeach
        </tbody> 
    </table> 
</body> 
</html> 