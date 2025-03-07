@extends('layouts.portfolio')

@section('title', '自己紹介 | マイポートフォリオ')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- ヒーローセクション -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
    <div class="md:flex">
        <div class="md:shrink-0 md:w-1/3">
            @if(App\Models\ProfileSetting::getDefault()->profile_image)
                <img class="h-auto w-full object-cover md:h-full" src="{{ asset('storage/' . App\Models\ProfileSetting::getDefault()->profile_image) }}" alt="プロフィール画像">
            @else
                <img class="h-auto w-full object-cover md:h-full" src="{{ asset('images/profile.jpg') }}" alt="プロフィール画像">
            @endif
        </div>
        <div class="p-8 md:w-2/3">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">私について</div>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ App\Models\ProfileSetting::getDefault()->name }}</h1>
            <p class="mt-2 text-xl text-gray-600">{{ App\Models\ProfileSetting::getDefault()->title }}</p>

            <div class="mt-6 text-gray-700">
                {!! nl2br(e(App\Models\ProfileSetting::getDefault()->bio)) !!}
            </div>

            <div class="mt-6 flex space-x-4">
                @if(App\Models\ProfileSetting::getDefault()->github_url)
                    <a href="{{ App\Models\ProfileSetting::getDefault()->github_url }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
                @if(App\Models\ProfileSetting::getDefault()->twitter_url)
                    <a href="{{ App\Models\ProfileSetting::getDefault()->twitter_url }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
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
            <h3 class="text-xl font-semibold text-gray-900 mb-3 border-b-2 border-blue-300 pb-2 mb-2">{{ $category ?: 'その他' }}</h3>

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
                        <!-- タイムライン線 -->
                        @if(!$loop->last)
                            <div class="absolute top-5 left-5 h-full w-0.5 bg-gray-200"></div>
                        @endif
                        
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 text-white shrink-0 mr-4">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-3.076 0-5.982-.56-8-1.308z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $experience->title }}</h3>
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
                        <!-- タイムライン線 -->
                        @if(!$loop->last)
                            <div class="absolute top-5 left-5 h-full w-0.5 bg-gray-200"></div>
                        @endif
                        
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 text-white shrink-0 mr-4">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $edu->institution }}</h3>
                                @if($edu->degree)
    <p class="text-gray-600">{{ $edu->degree }}@if($edu->field) - {{ $edu->field }}@endif</p>
@endif<p class="text-sm text-gray-500">
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
@endsection
