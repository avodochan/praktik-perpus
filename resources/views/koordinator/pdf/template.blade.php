<!DOCTYPE html> 
<html> 
<head> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> <!-- Link ke Bootstrap Icons -->

    <title>Export PDF</title> 
</head> 
<body> 
    {{-- judul di laporan --}}
    <h2>Laporan Peminjaman</h2> 
    <table border="1"> 
        <thead> 
            {{-- data yang akan ditampilkan di laporan --}}
            <tr> 
                <th>ID</th> 
                <th>Judul Buku</th> 
                <th>Nama Member</th> 
                <th>Tanggal Pinjam</th> 
                <th>Tanggal Pengembalian</th> 
                <th>Status</th> 
            </tr> 
        </thead> 
        <tbody> 
            {{-- looping untuk menampilkan data --}}
            @foreach($data as $p)
                <tr>
                    <td>{{ $p->id_pinjem }}</td>
                    <td>{{ $p->buku->judul}}</td>
                    <td>{{ $p->member->nama}}</td>
                    {{-- tgl_pinjam dan tgl_kembali sudah didefinisikan di model (ini adalah attribute) --}}
                    <td>{{ $p->tgl_pinjam_formatted}}</td>
                    <td>{{ $p->tgl_kembali_sebenarnya ?? '-'}}</td>
                    <td>
                        <span class="badge bg-{{ $p['status_class'] }}">{{ $p['status_text'] }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody> 
    </table> 
</body> 
</html> 