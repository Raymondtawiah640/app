<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - YourBrand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu.open {
            max-height: 500px;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        YourBrand
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-blue-600 transition-colors">Home</a>
                    <a href="/post" class="text-gray-700 hover:text-blue-600 transition-colors">Posts</a>
                    <a href="/contact" class="text-gray-700 hover:text-blue-600 transition-colors">Contact</a>
                </div>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ auth()->user()->name }}</span>
                            </div>
                            <form action="/logout" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-blue-600 transition-colors">
                            Login
                        </a>
                        <a href="/register" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menuIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path id="closeIcon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="mobile-menu md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Home</a>
                    <a href="/post" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Posts</a>
                    <a href="/contact" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Contact</a>
                    <div class="pt-2 space-y-2">
                        @auth
                            <div class="px-3 py-2 text-center text-gray-700">
                                <div class="flex items-center justify-center space-x-2 mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ auth()->user()->name }}</span>
                                </div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="/login" class="block px-3 py-2 text-center border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                Login
                            </a>
                            <a href="/register" class="block px-3 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact Messages Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-blue-600 text-white py-8 px-6 shadow-md rounded-lg mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h1 class="text-3xl font-bold">Contact Messages</h1>
                </div>
                <p class="text-blue-100">
                    Manage and review all contact form submissions
                </p>
            </div>

            @php
                $recentCount = $contacts->filter(function($contact) {
                    return $contact->created_at->diffInDays(now()) <= 7;
                })->count();
                $uniqueEmails = $contacts->pluck('email')->unique()->count();
            @endphp

            <!-- Summary Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Messages</p>
                            <p class="text-3xl font-bold mt-1">{{ $contacts->count() }}</p>
                        </div>
                        <svg class="w-10 h-10 text-blue-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Recent (7 days)</p>
                            <p class="text-3xl font-bold mt-1">{{ $recentCount }}</p>
                        </div>
                        <svg class="w-10 h-10 text-green-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Unique Senders</p>
                            <p class="text-3xl font-bold mt-1">{{ $uniqueEmails }}</p>
                        </div>
                        <svg class="w-10 h-10 text-purple-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            @if($contacts->count() > 0)
                <!-- Messages Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($contacts as $contact)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border border-gray-200">
                            <div class="p-6">
                                <!-- Contact Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-gray-900 font-bold mb-1">{{ $contact->name }}</h3>
                                            <div class="flex items-center gap-2 text-gray-600 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $contact->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($contact->created_at->diffInDays(now()) <= 7)
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">
                                            New
                                        </span>
                                    @endif
                                </div>

                                <!-- Message Content -->
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <p class="text-gray-700 leading-relaxed">{{ $contact->message }}</p>
                                </div>

                                <!-- Footer -->
                                <div class="flex items-center gap-2 text-gray-500 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $contact->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Results Count -->
                <div class="mt-6 text-center text-gray-600 text-sm">
                    Showing {{ $contacts->count() }} message{{ $contacts->count() !== 1 ? 's' : '' }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No messages found</p>
                    <p class="text-gray-400 text-sm mt-2">
                        Contact messages will appear here once submitted
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Company -->
                <div>
                    <h4 class="font-bold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Press</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="font-bold mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="font-bold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Tutorials</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Community</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">GDPR</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 YourBrand. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    if (mobileMenu.classList.contains('open')) {
                        mobileMenu.classList.remove('open');
                        menuIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    }
                }
            });
        });

        // Auto-hide success message after 5 seconds
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html>