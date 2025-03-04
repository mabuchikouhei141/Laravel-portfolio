@extends('layouts.portfolio')

@section('title', 'ホーム | マイポートフォリオ')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold mb-4">ようこそ、私のポートフォリオへ</h1>
            <p class="text-lg text-gray-600">ウェブ開発者・デザイナーとしての作品を紹介します</p>
        </section>

        @if(isset($featuredProjects) && $featuredProjects->count() > 0)
        <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-6">注目のプロジェクト</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredProjects as $project)
                    <div class="border rounded-lg overflow-hidden shadow-sm">
                        @if($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">画像なし</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2">{{ $project->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">詳細を見る</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection
