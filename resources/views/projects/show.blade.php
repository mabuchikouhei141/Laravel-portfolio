@extends('layouts.portfolio')

@section('title', $project->title . ' | マイポートフォリオ')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-auto rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">画像なし</span>
                            </div>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-2">
                            @if($project->technologies)
                                @foreach(json_decode($project->technologies) as $tech)
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="md:w-2/3">
                        <h1 class="text-2xl font-bold mb-4">{{ $project->title }}</h1>

                        <div class="prose max-w-none">
                            <p>{{ $project->description }}</p>
                        </div>

                        <div class="mt-6 space-y-2">
                            @if($project->url)
                                <div>
                                    <span class="text-gray-700 font-medium">URL:</span>
                                    <a href="{{ $project->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 ml-2">{{ $project->url }}</a>
                                </div>
                            @endif

                            @if($project->github_url)
                                <div>
                                    <span class="text-gray-700 font-medium">GitHub:</span>
                                    <a href="{{ $project->github_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 ml-2">{{ $project->github_url }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900">
                ← プロジェクト一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection
