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
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                    {{ request('search') ? 'Search Results' : 'All Posts' }}
                </h1>
                <p class="text-gray-600">
                    @if(request('search'))
                        Found {{ $posts->total() }} result{{ $posts->total() !== 1 ? 's' : '' }} for "{{ request('search') }}"
                    @else
                        Discover what the community is sharing
                    @endif
                </p>
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
                    <form id="searchForm" method="GET" action="{{ route('posts') }}" class="flex">
                        <div class="relative">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                placeholder="Search posts..."
                                value="{{ request('search') }}"
                                class="w-full sm:w-64 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                        @if(request('search'))
                            <a href="{{ route('posts') }}" class="ml-2 px-3 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Posts List -->
            <div class="space-y-6" id="postsContainer">
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

                    <p class="text-gray-700 mb-4 post-content" data-full-content="{{ $post->body }}">
                        {{ Str::limit($post->body, 150) }}
                    </p>
                    <button class="show-more-btn text-blue-600 hover:text-blue-700 font-medium text-sm mb-4"
                            data-post-id="{{ $post->id }}">
                        Show more →
                    </button>

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
                                    onclick="return confirm('Are you sure you want to delete this post {{$post->title}}?')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="{{ $posts->count() == 0 ? '' : 'hidden' }} text-center py-12">
                <div class="text-6xl mb-4">{{ request('search') ? '🔍' : '�' }}</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    {{ request('search') ? 'No posts found' : 'No posts yet' }}
                </h3>
                <p class="text-gray-600 mb-6">
                    {{ request('search') ? 'Try adjusting your search terms or clear the search to see all posts.' : 'Be the first to create a post!' }}
                </p>
                @if(request('search'))
                    <div class="space-x-4">
                        <a href="{{ route('posts') }}" class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                            Clear Search
                        </a>
                        <a href="/message" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Create Post
                        </a>
                    </div>
                @else
                    <a href="/message" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Post
                    </a>
                @endif
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                @if ($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->hasMorePages())
                <button id="loadMoreBtn"
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        data-current-page="1"
                        data-total-pages="{{ $posts->lastPage() }}">
                    Load More Posts
                </button>
                @endif
            </div>
        </div>
    </div>
    <script>
        // Show more/less functionality for post content
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreButtons = document.querySelectorAll('.show-more-btn');

            showMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const postContent = this.previousElementSibling;
                    const fullContent = postContent.getAttribute('data-full-content');
                    const isExpanded = postContent.classList.contains('expanded');

                    if (isExpanded) {
                        // Show less
                        postContent.textContent = "{{ Str::limit('', 150) }}".substring(0, 150) + (fullContent.length > 150 ? '...' : '');
                        postContent.classList.remove('expanded');
                        this.textContent = 'Show more →';
                    } else {
                        // Show more
                        postContent.textContent = fullContent;
                        postContent.classList.add('expanded');
                        this.textContent = 'Show less ↑';
                    }
                });
            });

            // Search functionality with debounce
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        if (searchInput.value.length >= 2 || searchInput.value.length === 0) {
                            searchForm.submit();
                        }
                    }, 500); // Wait 500ms after user stops typing
                });

                // Clear search on Escape key
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        searchInput.value = '';
                        searchForm.submit();
                    }
                });
            }
        });
        
        // Load More functionality
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const currentPage = parseInt(this.getAttribute('data-current-page'));
                    const totalPages = parseInt(this.getAttribute('data-total-pages'));
                    const nextPage = currentPage + 1;
                    
                    if (nextPage > totalPages) {
                        this.style.display = 'none';
                        return;
                    }
                    
                    // Show loading state
                    this.textContent = 'Loading...';
                    this.disabled = true;
                    
                    // Fetch more posts via AJAX
                    fetch(`/posts?page=${nextPage}`)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newPosts = doc.querySelectorAll('#postsContainer .post-card');
                            
                            // Append new posts to the container
                            const postsContainer = document.getElementById('postsContainer');
                            newPosts.forEach(post => {
                                postsContainer.appendChild(post);
                            });
                            
                            // Update button state
                            this.setAttribute('data-current-page', nextPage);
                            this.textContent = 'Load More Posts';
                            this.disabled = false;
                            
                            // Hide button if no more pages
                            if (nextPage >= totalPages) {
                                this.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading more posts:', error);
                            this.textContent = 'Load More Posts';
                            this.disabled = false;
                        });
                });
            }
        });
    </script>
</body>
</html>
