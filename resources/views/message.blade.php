<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - YourBrand</title>
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
    <!-- Simple Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    YourBrand
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Post Form Section -->
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Create a New Post</h2>
                <p class="text-gray-600">Share your thoughts with the community</p>
            </div>

            <!-- Post Form -->
            <form  class="bg-white shadow-lg rounded-xl p-8 space-y-6 fade-in" action="/create_posts" method="post">
                @csrf
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm text-gray-700 mb-2">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title"
                        required
                        maxlength="200"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Enter your post title"
                    >
                    <p class="text-xs text-gray-500 mt-2">Maximum 200 characters</p>
                </div>

                <!-- Body -->
                <div>
                    <label for="body" class="block text-sm text-gray-700 mb-2">Body</label>
                    <textarea
                        id="body"
                        name="body"
                        required
                        rows="15"
                        maxlength="300"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-y"
                        placeholder="Write your post content here..."
                        oninput="updateCharacterCount()"
                    ></textarea>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-gray-500">Share your ideas, stories, or updates</p>
                        <p class="text-xs text-gray-500">
                            <span id="charCount">0</span>/200 characters
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Publish Post
                    </button>
                    {{-- <button 
                        type="button"
                        id="saveDraft"
                        class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition-all"
                    >
                        Save as Draft
                    </button> --}}
                </div>

                <!-- Cancel Link -->
                {{-- <p class="text-center text-sm text-gray-600">
                    <a href="/homepage.html" class="text-blue-600 hover:text-blue-700 transition-colors">
                        Cancel and go back
                    </a>
                </p> --}}
            </form>

            <!-- Tips Section -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6 fade-in">
                <h3 class="font-bold text-blue-900 mb-3">📝 Tips for a Great Post</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>• Use a clear and descriptive title</li>
                    <li>• Break your content into paragraphs for better readability</li>
                    <li>• Be respectful and constructive in your writing</li>
                    <li>• Proofread before publishing</li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        // Character counter for post body
        function updateCharacterCount() {
            const bodyInput = document.getElementById('body');
            const charCount = document.getElementById('charCount');
            const currentLength = bodyInput.value.length;
            
            charCount.textContent = currentLength;
            
            // Change color if approaching limit
            if (currentLength > 170) {
                charCount.classList.remove('text-gray-500');
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
                charCount.classList.add('text-gray-500');
            }
        }
        
        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCharacterCount();
        });
    </script>
</body>
</html>

