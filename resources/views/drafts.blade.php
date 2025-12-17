<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drafts - YourBrand</title>
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
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    YourBrand
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors">
                        Home
                    </a>
                    <a href="/message" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Post
                    </a>
                    <a href="/post" class="text-gray-600 hover:text-gray-900 transition-colors">
                        All Posts
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Drafts Section -->
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Your Drafts</h1>
                <p class="text-gray-600">Continue working on your saved drafts</p>
            </div>

            <!-- Drafts List -->
            <div class="space-y-6">
                @forelse ($drafts as $draft)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center text-white font-bold">
                                D
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Draft</h3>
                                <p class="text-sm text-gray-500">{{ $draft->created_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">
                        {{ $draft->title }}
                    </h2>

                    <p class="text-gray-700 mb-4">
                        {{ Str::limit($draft->body, 200) }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('drafts.edit', ['post' => $draft->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Draft
                        </a>

                        <form action="/delete/{{$draft->id}}" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this draft?')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📝</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No drafts yet</h3>
                    <p class="text-gray-600 mb-6">Start writing and save as draft to continue later.</p>
                    <a href="/message" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Draft
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($drafts->hasPages())
            <div class="mt-8">
                {{ $drafts->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
