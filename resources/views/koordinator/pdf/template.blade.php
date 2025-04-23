<!DOCTYPE html> 
<html> 
<head> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> <!-- Link ke Bootstrap Icons -->

    <title>Export PDF</title> 
</head> 
<body> 
    <h2>Laporan Peminjaman</h2> 
    <table class="table table-bordered"> 
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