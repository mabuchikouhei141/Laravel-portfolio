@extends('layouts.portfolio')

@section('title', 'プロジェクト一覧 | マイポートフォリオ')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- ヘッダーセクション -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">プロジェクト一覧</h1>
            <p class="max-w-2xl mx-auto text-xl text-gray-600">
                これまでに手がけたプロジェクトをご紹介します。
                各プロジェクトの詳細については、カードをクリックしてください。
            </p>
        </div>

        <!-- プロジェクト一覧 -->
        <div class="mt-10">
            @if($projects->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-md">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <p class="mt-4 text-lg text-gray-600">プロジェクトはまだ登録されていません。</p>
                </div>
            @else
                <div class="projects-grid">
                    @foreach($projects as $project)
                        <div class="project-card">
                            <a href="{{ route('projects.show', $project) }}" class="block">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="project-image">
                                @else
                                    <div class="project-image flex items-center justify-center bg-gray-200">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                                    
                                    <a href="{{ route('projects.show', $project) }}" class="view-details">詳細を見る</a>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
