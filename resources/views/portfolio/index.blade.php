@extends('layouts.portfolio')

@section('title', 'ホーム | マイポートフォリオ')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- ヒーローセクション -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="md:flex">
                <div class="md:shrink-0 md:w-1/3">
                    @if(App\Models\SiteSetting::getValue('hero_image'))
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('storage/' . App\Models\SiteSetting::getValue('hero_image')) }}" alt="ヒーロー画像">
                    @else
                        <img class="h-auto w-full object-cover md:h-full" src="{{ asset('images/profile.jpg') }}" alt="プロフィール画像">
                    @endif
                </div>
                <div class="p-8 md:w-2/3">
                    <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ App\Models\SiteSetting::getValue('hero_title', 'ようこそ、私のポートフォリオへ') }}</h1>
                <p class="mt-2 text-xl text-gray-600">{!! nl2br(e(App\Models\SiteSetting::getValue('hero_subtitle', 'ウェブ開発者・デザイナーとしての作品を紹介します'))) !!}</p></div> 
            </div>
        </div>
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
                    <h3 class="text-xl font-bold mb-2 truncate" title="{{ $project->title }}">{{ $project->title }}</h3>
                    <p class="text-gray-600 mb-4 description">
                        {{ Str::limit($project->description, 150) }}
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">詳細を見る</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

    </div>
</div>
@endsection
