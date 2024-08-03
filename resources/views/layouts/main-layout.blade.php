<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-60 bg-gray-800 text-white">
        <div class="h-full flex flex-col">
            <div class="p-4 text-center font-bold text-lg">Transaksi Penjualan</div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="{{ route('product') }}" class="block px-4 py-2 m-2 rounded-md hover:bg-gray-600">List
                            Produk</a></li>
                    <li><a href="{{ route('category') }}"
                            class="block px-4 py-2 m-2 rounded-md hover:bg-gray-600">Kategori Produk</a>
                    </li>
                    <li><a href="{{ route('transaction') }}"
                            class="block px-4 py-2 m-2 rounded-md hover:bg-gray-600">Transaksi</a></li>
                    <li><a href="{{ route('historytransaction') }}"
                            class="block px-4 py-2 m-2 rounded-md hover:bg-gray-600">Histori Transaksi</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <header class="bg-white shadow-md flex items-center justify-between p-4">
            <div class="text-lg font-semibold cursor-pointer"><i class="fa-solid fa-bars"></i></div>
            <a href="{{ route('logout.post') }}" class="text-blue-500 hover:underline">Logout</a>
        </header>

        <!-- Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
