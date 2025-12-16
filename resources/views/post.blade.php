<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - YourBrand</title>
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

        .post-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/homepage.html" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    YourBrand
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors">
                        Home
                    </a>
                    <a href="/message" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Post
                    </a>
                    <a href="/posts" class="text-gray-600 hover:text-gray-900 transition-colors">
                        All Posts
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Posts Section -->
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">All Posts</h1>
                <p class="text-gray-600">Discover what the community is sharing</p>
            </div>

            <!-- Filter/Sort Options -->
            <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center fade-in">
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Latest
                    </button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Popular
                    </button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Trending
                    </button>
                </div>
                <div class="w-full sm:w-auto">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Search posts..."
                        class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>

            <!-- Posts List -->
            <div class="space-y-6">
                @foreach ($posts as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 post-card">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $post->user->name ?? 'Unknown User' }}</h3>
                                <p class="text-sm text-gray-500">{{ $post->created_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ $post->title }} by {{ $post->user->name ?? 'Unknown User' }}
                    </h2>

                    <p class="text-gray-700 mb-4 line-clamp-3">
                        {{ $post->body }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3 mb-4">
                        <a href="/edit/{{$post->id}}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>

                        <form action="/delete/{{$post->id}}" method="post" class="inline">
                            @CSRF
                            @method('Delete')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>

                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Read more →
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-12">
                <div class="text-6xl mb-4">📝</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-600 mb-6">Be the first to create a post!</p>
                <a href="/message" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Create Post
                </a>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button id="loadMoreBtn" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Load More Posts
                </button>
            </div>
        </div>
    </div>
</body>
</html>
