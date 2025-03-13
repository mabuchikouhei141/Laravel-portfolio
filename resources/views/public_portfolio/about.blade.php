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
        <!-- ヒーローセクション -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="md:flex">
                <div class="md:shrink-0 md:w-1/3">
                    @if($profile && $profile->profile_image)
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('storage/' . $profile->profile_image) }}" alt="プロフィール画像">
                    @else
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('images/profile.jpg') }}" alt="プロフィール画像">
                    @endif
                </div>
                <div class="p-8 md:w-2/3">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">私について</div>

                    <h1 class="mt-2 text-3xl font-bold text-gray-900">
                        {{-- $profile->name があれば表示、それ以外は $user->nameなど --}}
                        {{ $profile->name ?? ($user->name ?? '匿名ユーザー') }}
                    </h1>

                    <p class="mt-2 text-xl text-gray-600">
                        {{ $profile->title ?? 'ウェブ開発者 / デザイナー' }}
                    </p>

                    <div class="mt-6 text-gray-700">
                        {{-- プロフィール文があれば改行付きで表示 --}}
                        @if($profile && $profile->bio)
                            {!! nl2br(e($profile->bio)) !!}
                        @else
                            <p>自己紹介文はまだ設定されていません。</p>
                        @endif
                    </div>

                    <div class="mt-6 flex space-x-4">
                        @if($profile && $profile->github_url)
                            <a href="{{ $profile->github_url }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                                <!-- GitHubアイコン -->
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2...省略..." clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        @if($profile && $profile->twitter_url)
                            <a href="{{ $profile->twitter_url }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                                <!-- Twitterアイコン -->
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0...省略..." />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- スキルセクション -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">スキル</h2>

        <div class="bg-gray-50 rounded-lg shadow-xl overflow-hidden mb-12 p-8">
            @forelse($skillsByCategory as $category => $skills)
                <div class="mb-8 last:mb-0">
                    <!-- カテゴリタイトル -->
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 border-b-2 border-blue-300 pb-2 mb-2">
                        {{ $category ?: 'その他' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($skills as $skill)
                            <div class="p-4 bg-white rounded-lg shadow-md transition transform hover:scale-105 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-lg font-medium text-gray-900">{{ $skill->name }}</span>
                                    <span class="text-sm font-semibold text-gray-600">{{ $skill->level }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full transition-all"
                                         style="width: {{ $skill->level }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-6">スキル情報はまだ登録されていません。</p>
            @endforelse
        </div>

        <!-- 職歴セクション -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">職歴</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12 p-6">
            <div class="space-y-8">
                @forelse($experiences as $experience)
                    <div class="relative">
                        @if(!$loop->last)
                            <div class="absolute top-5 left-5 h-full w-0.5 bg-gray-200"></div>
                        @endif
                        
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 text-white shrink-0 mr-4">
                                <!-- アイコン -->
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3..." clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2..." />
                                </svg>
                            </div>
                            <div>
                                <!-- 注意: カラム名は 'position' にしたなら $experience->position -->
                                <h3 class="text-lg font-bold text-gray-900">{{ $experience->position }}</h3>
                                <p class="text-gray-600">{{ $experience->company }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('Y年m月') }} - 
                                    @if($experience->current)
                                        現在
                                    @else
                                        {{ \Carbon\Carbon::parse($experience->end_date)->format('Y年m月') }}
                                    @endif
                                </p>
                                <div class="mt-2 text-gray-700">
                                    {!! nl2br(e($experience->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">職歴情報はまだ登録されていません。</p>
                @endforelse
            </div>
        </div>
        
        <!-- 学歴セクション -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">学歴</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
            <div class="space-y-8">
                @forelse($education as $edu)
                    <div class="relative">
                        @if(!$loop->last)
                            <div class="absolute top-5 left-5 h-full w-0.5 bg-gray-200"></div>
                        @endif
                        
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 text-white shrink-0 mr-4">
                                <!-- アイコン -->
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08...略" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $edu->institution }}</h3>
                                @if($edu->degree)
                                    <p class="text-gray-600">{{ $edu->degree }}@if($edu->field) - {{ $edu->field }}@endif</p>
                                @endif
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('Y年m月') }} -
                                    @if($edu->current)
                                        現在
                                    @else
                                        {{ \Carbon\Carbon::parse($edu->end_date)->format('Y年m月') }}
                                    @endif
                                </p>
                                @if($edu->description)
                                    <div class="mt-2 text-gray-700">
                                        {!! nl2br(e($edu->description)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">学歴情報はまだ登録されていません。</p>
                @endforelse
            </div>
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
