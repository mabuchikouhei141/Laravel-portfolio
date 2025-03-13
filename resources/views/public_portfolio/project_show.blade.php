<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{-- $userが渡ってくる想定なら、ユーザーの名前を表示するのも良い --}}
        @yield('title', ($user->name ?? 'ユーザー') . 'のポートフォリオ')
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- 独自CSSやViteなど -->
    <link href="{{ asset('portfolio.css') }}" rel="stylesheet">    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- ナビゲーション -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- ロゴ部分 -->
                        <div class="shrink-0 flex items-center">
                            <!-- ユーザートップへのリンク -->
                            <a href="{{ route('public.portfolio.index', $user) }}" class="font-bold text-xl">
                                {{-- 例: ユーザー名のポートフォリオ --}}
                                {{ $user->name ?? 'ポートフォリオ' }}のポートフォリオ
                            </a>
                        </div>

                        <!-- ナビゲーションリンク -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <!-- ホーム(= ユーザートップ) -->
                            <a href="{{ route('public.portfolio.index', $user) }}"
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium 
                                      leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 
                                      focus:outline-none focus:text-gray-700 focus:border-gray-300 
                                      transition duration-150 ease-in-out">
                                ホーム
                            </a>

                            <!-- 自己紹介 -->
                            <a href="{{ route('public.portfolio.about', $user) }}"
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium 
                                      leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 
                                      focus:outline-none focus:text-gray-700 focus:border-gray-300 
                                      transition duration-150 ease-in-out">
                                自己紹介
                            </a>

                            <!-- プロジェクト一覧 -->
                            <a href="{{ route('public.portfolio.projects', $user) }}"
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium 
                                      leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 
                                      focus:outline-none focus:text-gray-700 focus:border-gray-300 
                                      transition duration-150 ease-in-out">
                                プロジェクト
                            </a>
                        </div>
                    </div>

                    <!-- 右側メニュー(ログイン/登録など) -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="text-sm text-gray-700 hover:text-gray-900 mr-4">
                                ダッシュボード
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">
                                    ログアウト
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-sm text-gray-700 hover:text-gray-900 mr-4">
                                ログイン
                            </a>
                            <a href="{{ route('register') }}" 
                               class="text-sm text-gray-700 hover:text-gray-900">
                                登録
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- コンテンツエリア -->
        <main>
        <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-auto rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">画像なし</span>
                            </div>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-2">
                            @if($project->technologies)
                                @foreach(json_decode($project->technologies) as $tech)
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 
                                                 text-sm font-medium text-blue-700 ring-1 
                                                 ring-inset ring-blue-700/10">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="md:w-2/3">
                        <h1 class="text-2xl font-bold mb-4">{{ $project->title }}</h1>
                        <div class="prose max-w-none">
                            <p>{!! nl2br(e($project->description)) !!}</p>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            @if($project->url)
                                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white 
                                          text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5 mr-2" fill="none" 
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2
                                                 0 002 2h10a2 2 0 002-2v-4M14 4h6m0
                                                 0v6m0-6L10 14" />
                                    </svg>
                                    ウェブサイトを見る
                                </a>
                            @endif
                            
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white 
                                          text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 
                                          transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" 
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                              d="M12 2C6.477 2 2 6.484 
                                                 2 12.017c0 4.425 2.865 8.18 
                                                 6.839 9.504.5.092.682-.217
                                                 .682-.483 0-.237-.008-.868-.013-1.703
                                                 ...省略..."
                                              clip-rule="evenodd" />
                                    </svg>
                                    GitHubリポジトリ
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <!-- ユーザー固有のプロジェクト一覧ページへ戻るリンク -->
            <a href="{{ route('public.portfolio.projects', $user) }}" 
               class="text-indigo-600 hover:text-indigo-900">
                ← プロジェクト一覧に戻る
            </a>
        </div>

    </div>
</div>
        </main>
        
        <!-- フッター -->
        <footer class="bg-white mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-500">
                    &copy; {{ date('Y') }} {{ $user->name ?? 'ポートフォリオ' }}
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
