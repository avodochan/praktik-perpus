<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" href="#">Dashboard Member</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" 
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          {{-- menu apa saja yang akan ditampilkan di role admin --}}
          {{-- jika requestnya sedang aktif, maka teksnya akan menggunakan class primary bold (biru cetak tebal) --}}
          {{-- jika requestnya sedang tidak aktid, maka teksnya akan menggunakan class dark (hitam) --}}
          {{-- ini untuk role member atau user --}}
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link {{ Request::is('/') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/') }}">Dashboard</a>
              <a class="nav-link {{ Request::is('user/showbuku*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/user/showbuku') }}">Buku</a>
              <a class="nav-link {{ Request::is('user/showdenda*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/user/showdenda') }}">Denda</a>
              <a class="nav-link {{ Request::is('user/showprofile*') ? 'text-primary fw-bold' : 'text-dark' }}" href="{{ url('/user/showprofile') }}">Profile</a>
              <form action="{{ route('logout') }}" method="POST">
                <a href="{{ route('logout') }}" class="nav-link text-danger fw-bold">Logout</a>
                </form>
            </div>
          </div>
        </div>
    </nav>      
</body>
</html>
