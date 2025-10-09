<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Asrama')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 fixed h-full z-40">
            <div class="p-4">
                <h1 class="text-2xl font-bold text-white">
                    <i class="fas fa-home mr-2"></i>
                    Sistem Asrama
                </h1>
            </div>

            <nav class="mt-6">
                <div class="px-4 py-2 text-blue-200 text-sm font-semibold">
                    MENU UTAMA
                </div>

                <a href="{{ route('dormfunds.index') }}"
                   class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('dormfunds.*') ? 'bg-blue-900 border-r-4 border-yellow-400' : '' }}">
                    <i class="fas fa-wallet mr-3"></i>
                    <span>Kas Asrama</span>
                </a>

                <a href="{{ route('infractions.index') }}"
                   class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('infractions.*') ? 'bg-blue-900 border-r-4 border-yellow-400' : '' }}">
                    <i class="fas fa-exclamation-triangle mr-3"></i>
                    <span>Pelanggaran</span>
                </a>

                <!-- Menu tambahan bisa ditambahkan di sini -->
                <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-users mr-3"></i>
                    <span>Data Penghuni</span>
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4 border-t border-blue-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-semibold">Administrator</p>
                        <p class="text-blue-200 text-sm">admin@asrama.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('page-title', 'Dashboard')
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifikasi -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">
                                3
                            </span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="hidden md:block">Admin</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle mr-2"></i>Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Pengaturan
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <!-- Breadcrumb -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                    @yield('breadcrumb', 'Dashboard')
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Content Section -->
                <div class="bg-white rounded-lg shadow-sm min-h-[calc(100vh-200px)]">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        &copy; {{ date('Y') }} Sistem Asrama. All rights reserved.
                    </div>
                    <div class="flex space-x-4 mt-2 md:mt-0">
                        <a href="#" class="text-gray-500 hover:text-gray-700 text-sm">
                            <i class="fas fa-shield-alt mr-1"></i>Privacy Policy
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 text-sm">
                            <i class="fas fa-file-contract mr-1"></i>Terms of Service
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 text-sm">
                            <i class="fas fa-headset mr-1"></i>Support
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('mobile-overlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('hidden');
        });

        // Close mobile menu when clicking overlay
        document.getElementById('mobile-overlay').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.remove('mobile-open');
            this.classList.add('hidden');
        });

        // User Menu Toggle
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Auto-hide success messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessages = document.querySelectorAll('.bg-green-100');
            successMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
