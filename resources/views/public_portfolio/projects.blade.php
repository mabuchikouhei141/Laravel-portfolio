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
        <div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- ヘッダーセクション -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                {{ $user->name ?? 'ユーザー' }}のプロジェクト一覧
            </h1>
            <p class="max-w-2xl mx-auto text-xl text-gray-600">
                これまでに手がけたプロジェクトをご紹介します。
                各プロジェクトの詳細については、カードをクリックしてください。
            </p>
        </div>

        <!-- プロジェクト一覧 -->
        <div class="mt-10">
            @if($projects->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-md">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477
                                 a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21
                                 a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5
                                 c1.26 1.26.367 3.414-1.415 3.414H4.828
                                 c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    <p class="mt-4 text-lg text-gray-600">プロジェクトはまだ登録されていません。</p>
                </div>
            @else
                <div class="projects-grid">
                    @foreach($projects as $project)
                        <div class="project-card">
                            <!-- ユーザー固有のプロジェクト詳細URLを作るなら 
                                 route('public.portfolio.projects.show', [$user, $project]) 
                                 を使用 -->
                            <a href="{{ route('public.portfolio.projects.show', [$user, $project]) }}" class="block">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}"
                                         alt="{{ $project->title }}" class="project-image">
                                @else
                                    <div class="project-image flex items-center justify-center bg-gray-200">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                                     l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2
                                                     0 002-2V6a2 2 0 00-2-2H6
                                                     a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="project-content">
                                    <h2 class="project-title">{{ $project->title }}</h2>
                                    <p class="project-description">{{ Str::limit($project->description, 100) }}</p>
                                    
                                    @if($project->technologies)
                                        <div class="project-tech">
                                            @foreach(json_decode($project->technologies) as $tech)
                                                <span class="tech-tag">{{ $tech }}</span>
                                                @if(!$loop->last)
                                                    <span class="tech-tag">&middot;</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <a href="{{ route('public.portfolio.projects.show', [$user, $project]) }}" class="view-details">
                                        詳細を見る
                                    </a>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
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
