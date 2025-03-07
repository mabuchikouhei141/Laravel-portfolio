<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'マイポートフォリオ')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link href="{{ asset('portfolio.css') }}" rel="stylesheet">    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- ロゴ -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="font-bold text-xl">
                                マイポートフォリオ
                            </a>
                        </div>

                        <!-- ナビゲーションリンク -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                ホーム
                            </a>
                            <a href="{{ route('about') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                自己紹介
                            </a>
                            <a href="{{ route('projects') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                プロジェクト
                            </a>
                        </div>
                    </div>

                    <!-- 右側メニュー -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-white hover:text-gray-900 mr-4">ダッシュボード</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-white hover:text-gray-900">
                                    ログアウト
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-white hover:text-gray-900 mr-4">ログイン</a>
                            <a href="{{ route('register') }}" class="text-sm text-white hover:text-gray-900">登録</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- コンテンツエリア -->
        <main>
            @yield('content')
        </main>
        
        <!-- フッター -->
        <footer class="bg-white mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-500">
                    &copy; {{ date('Y') }} マイポートフォリオ
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
