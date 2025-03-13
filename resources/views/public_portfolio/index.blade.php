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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- ヒーローセクション -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="md:flex">
                <div class="md:shrink-0 md:w-1/3">
                    @php
                        // ユーザー固有のヒーロー画像を取得
                        $heroImage = App\Models\SiteSetting::getValue('hero_image', null, $user->id);
                    @endphp

                    @if($heroImage)
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('storage/' . $heroImage) }}" alt="ヒーロー画像">
                    @else
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('images/profile.jpg') }}" alt="プロフィール画像">
                    @endif
                </div>
                <div class="p-8 md:w-2/3">
                    @php
                        // ユーザー固有のタイトル・サブタイトルを取得
                        $heroTitle = App\Models\SiteSetting::getValue('hero_title', 'ようこそ、私のポートフォリオへ', $user->id);
                        $heroSubtitle = App\Models\SiteSetting::getValue('hero_subtitle', 'ウェブ開発者・デザイナーとしての作品を紹介します', $user->id);
                    @endphp

                    <h1 class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $heroTitle }}
                    </h1>
                    <p class="mt-2 text-xl text-gray-600">
                        {!! nl2br(e($heroSubtitle)) !!}
                    </p>
                </div>
            </div>
        </div>

        <!-- 注目のプロジェクト -->
        @if(isset($featuredProjects) && $featuredProjects->count() > 0)
            <style>
                .description {
                    display: -webkit-box;
                    -webkit-line-clamp: 3; /* 3行で省略 */
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    word-break: break-word; /* 単語が長すぎても折り返す */
                    white-space: normal;
                    min-height: 4.5rem; /* 高さを統一 */
                }
            </style>

            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6">注目のプロジェクト</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredProjects as $project)
                        <div class="border rounded-lg overflow-hidden shadow-sm flex flex-col">
                            @if($project->image)
                                <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">画像なし</span>
                                </div>
                            @endif
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold mb-2 truncate" title="{{ $project->title }}">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-gray-600 mb-4 description">
                                    {{ Str::limit($project->description, 150) }}
                                </p>
                                <div class="mt-auto">
                                    {{-- 公開ページでプロジェクト詳細を表示するときは 
                                         /u/{user}/projects/{project} のリンクを使うか
                                         route('public.portfolio.projects.show', [$user, $project]) 
                                       などにする --}}
<a href="{{ route('public.portfolio.projects.show', [$user, $project]) }}" class="text-blue-600 hover:underline">
    詳細を見る
</a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

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
