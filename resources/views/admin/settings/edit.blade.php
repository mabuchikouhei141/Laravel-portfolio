<x-app-layout>
@section('title', 'サイト管理 | マイポートフォリオ')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('サイト設定') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">ヒーローセクション</h3>
                            <p class="text-sm text-gray-600 mb-4">ポートフォリオのトップページに表示される内容を設定します</p>
                            
                            <div class="mb-4">
                                <label for="hero_title" class="block text-sm font-medium text-gray-700">タイトル</label>
                                <input type="text" name="hero_title" id="hero_title" 
                                       value="{{ old('hero_title', $settings['hero_title']) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('hero_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="hero_subtitle" class="block text-sm font-medium text-gray-700">サブタイトル</label>
                                <textarea name="hero_subtitle" id="hero_subtitle" rows="2"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
                                @error('hero_subtitle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="hero_image" class="block text-sm font-medium text-gray-700">ヒーロー画像</label>
                                
                                @if($settings['hero_image'])
                                    <div class="mt-2 mb-3">
                                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="ヒーロー画像" class="max-w-lg h-auto rounded">
                                    </div>
                                @endif
                                
                                <input type="file" name="hero_image" id="hero_image" class="mt-1 block w-full">
                                <p class="mt-1 text-sm text-gray-500">最適な画像サイズ: 1200px × 600px</p>
                                @error('hero_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
