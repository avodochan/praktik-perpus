<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" href="#">Dashboard Admin</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" 
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          {{-- menu apa saja yang akan ditampilkan di role admin --}}
          {{-- jika requestnya sedang aktif, maka teksnya akan menggunakan class primary bold (biru cetak tebal) --}}
          {{-- jika requestnya sedang tidak aktid, maka teksnya akan menggunakan class dark (hitam) --}}
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link {{ Request::is('/') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/') }}">Dashboard</a>
              <a class="nav-link {{ Request::is('admin/kategori*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/admin/kategori') }}">Kategori</a>
              <a class="nav-link {{ Request::is('admin/buku*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/admin/buku') }}">Buku</a>
              <a class="nav-link {{ Request::is('admin/peminjaman*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/admin/peminjaman') }}">Peminjaman</a>
              <a class="nav-link {{ Request::is('admin/denda*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/admin/denda') }}">Denda</a>
              <a class="nav-link {{ Request::is('admin/member*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/admin/member') }}">Member</a>
              {{-- fungsi logout dengan teks bercetak warna merah --}}
              <form action="{{ route('logout') }}" method="POST">
                <a href="{{ route('logout') }}" class="nav-link text-danger fw-bold">Logout</a>
                </form>
            </div>
          </div>
        </div>
    </nav>      
</body>
</html>
