<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 240px;
            padding: 20px;
            flex-grow: 1;
            width: 100%;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mb-4">💼 Aplikasi Limbah</h4>
        <a href="/dashboard">Dashboard</a>
        <a href="/laporan-harian">Laporan Harian</a>
        <a href="/sampah-b3">Pengelolaan Sampah B3</a>
        <a href="/penyimpanan">Manajemen Penyimpanan</a>
        <a href="/jenis-material">Jenis Material</a>
        <a href="/pengguna">Manajemen User</a>
        <a href="/logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand navbar-light bg-light shadow-sm p-3 rounded">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h5">Selamat Datang 👋</span>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
</html>
