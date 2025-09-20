<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Шинэ кино оруулах</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (!$uploadComplete)
        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Киноны нэр *</label>
                <input
                    wire:model="title"
                    type="text"
                    id="title"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Киноны нэр оруулах"
                >
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Тайлбар</label>
                <textarea
                    wire:model="description"
                    id="description"
                    rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Киноны тайлбар оруулах"
                ></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">Үнэлгээ (1-5)</label>
                <select
                    wire:model="rating"
                    id="rating"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                    <option value="1">1 ⭐</option>
                    <option value="2">2 ⭐⭐</option>
                    <option value="3">3 ⭐⭐⭐</option>
                    <option value="4">4 ⭐⭐⭐⭐</option>
                    <option value="5">5 ⭐⭐⭐⭐⭐</option>
                </select>
                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="video" class="block text-sm font-medium text-gray-700">Видео файл *</label>
                <input
                    wire:model="video"
                    type="file"
                    id="video"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    accept=".mp4,.mov,.avi"
                >
                @error('video') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if ($video)
                    <div class="mt-2 text-sm text-green-600">
                        Файл сонгогдсон: {{ $video->getClientOriginalName() }}
                        ({{ number_format($video->getSize() / 1024 / 1024, 2) }} MB)
                    </div>
                @endif
            </div>

            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail зураг</label>
                <input
                    wire:model="thumbnail"
                    type="file"
                    id="thumbnail"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    accept=".jpg,.jpeg,.png"
                >
                @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if ($thumbnail)
                    <div class="mt-2">
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-32 h-32 object-cover rounded border">
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $thumbnail->getClientOriginalName() }}
                        </div>
                    </div>
                @endif
            </div>

            @if ($isUploading)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Боловсруулж байна...</span>
                        <span class="text-sm font-medium text-blue-600">{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                             style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            @endif

            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="save">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Хадгалах
                    </span>
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Боловсруулж байна...
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="resetForm"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Цуцлах
                </button>
            </div>
        </form>
    @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <div class="text-green-600 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-green-800 mb-2">Амжилттай!</h2>
            <p class="text-green-600 mb-4">Кино амжилттай орууллаа. Тун удахгүй боловсруулагдана.</p>

            <div class="flex gap-3 justify-center">
                <a
                    href="{{ route('movies.show', $movieId) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700"
                >
                    Киноны хуудас үзэх
                </a>

                <button
                    wire:click="resetForm"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700"
                >
                    Шинэ кино оруулах
                </button>
            </div>
        </div>
    @endif
</div>
