<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Car Auction')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-blue-600 p-4 text-white">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-lg font-semibold">Car Auction</a>
                <div>
                    <a href="{{ route('auctions.create') }}" class="mr-4">Sell Your Car</a>
                    <a href="{{ route('auctions.index') }}" class="mr-4">Auctions</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="mr-4">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="mr-4">Profile</a>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mr-4">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="flex flex-1 w-full justify-between">
            <!-- Sidebar -->
            <aside class="w-1/10 bg-gray-800 text-white p-4 hidden md:block">
                
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>

            <!-- Sidebar -->
            <aside class="w-1/10 bg-gray-800 text-white p-4 lg:block hidden">
                
            </aside>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white p-4">
            <div class="container mx-auto text-center">
                &copy; {{ date('Y') }} Car Auction. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
