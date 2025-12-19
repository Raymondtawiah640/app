<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schools Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    YourBrand
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors">
                        Home
                    </a>
                    <a href="/post" class="text-gray-600 hover:text-gray-900 transition-colors">
                        Posts
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Schools Management</h1>
                <p class="text-gray-600">Upload Excel files or add schools manually</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded fade-in">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded fade-in">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Excel Upload Form -->
                <div class="bg-white shadow-lg rounded-xl p-6 fade-in">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Upload CSV File</h2>
                    <form action="{{ route('schools.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                                CSV File
                            </label>
                            <input
                                type="file"
                                id="excel_file"
                                name="excel_file"
                                accept=".csv"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p class="text-xs text-gray-500 mt-1">
                                CSV file should have headers: name, location, contact, status, website
                            </p>
                        </div>
                        <button
                            type="submit"
                            id="uploadBtn"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            Upload CSV
                        </button>
                    </form>
                </div>

                <!-- Manual Entry Form -->
                <div class="bg-white shadow-lg rounded-xl p-6 fade-in">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Add School Manually</h2>
                    <form action="{{ route('schools.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                                <input
                                    type="text"
                                    id="contact"
                                    name="contact"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <input
                                    type="text"
                                    id="status"
                                    name="status"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                <input
                                    type="url"
                                    id="website"
                                    name="website"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <button
                                type="submit"
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors"
                            >
                                Add School
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Schools List -->
            <div class="mt-8 bg-white shadow-lg rounded-xl p-6 fade-in">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Schools List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($schools ?? [] as $school)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $school->name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $school->location }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $school->contact }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $school->status }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-blue-600">
                                    <a href="{{ $school->website }}" target="_blank" class="hover:underline">{{ $school->website }}</a>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $school->created_at->format('M j, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    No schools found. Upload an Excel file or add schools manually.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('uploadBtn').addEventListener('click', function(e) {
            const fileInput = document.getElementById('excel_file');
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Please select a CSV file to upload.');
                fileInput.click(); // Open file dialog
                return false;
            }
        });

        // Also validate on form submit
        document.querySelector('form[action*="schools.upload"]').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('excel_file');
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Please select a CSV file to upload.');
                return false;
            }
        });
    </script>
</body>
</html>
