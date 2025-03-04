<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('スキル編集') }}: {{ $skill->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">スキル名</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="level" class="block text-sm font-medium text-gray-700">レベル (0-100)</label>
                            <input type="range" name="level" id="level" min="0" max="100" value="{{ old('level', $skill->level) }}" class="mt-1 block w-full" oninput="levelOutput.value = level.value">
                            <output id="levelOutput" class="mt-1 block">{{ $skill->level }}</output>
                            @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                       <div class="mb-4">
    <label for="category" class="block text-sm font-medium text-gray-700">カテゴリー</label>
    <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">カテゴリーを選択</option>
        <option value="フロントエンド" {{ old('category', $skill->category ?? '') == 'フロントエンド' ? 'selected' : '' }}>フロントエンド</option>
        <option value="バックエンド" {{ old('category', $skill->category ?? '') == 'バックエンド' ? 'selected' : '' }}>バックエンド</option>
        <option value="データベース" {{ old('category', $skill->category ?? '') == 'データベース' ? 'selected' : '' }}>データベース</option>
        <option value="インフラ" {{ old('category', $skill->category ?? '') == 'インフラ' ? 'selected' : '' }}>インフラ</option>
        <option value="ツール" {{ old('category', $skill->category ?? '') == 'ツール' ? 'selected' : '' }}>ツール</option>
        <option value="その他" {{ old('category', $skill->category ?? '') == 'その他' ? 'selected' : '' }}>その他</option>
    </select>
    @error('category')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> 
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                キャンセル
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ページ読み込み時にレンジスライダーの値を出力に反映
        document.addEventListener('DOMContentLoaded', function() {
            const level = document.getElementById('level');
            const levelOutput = document.getElementById('levelOutput');
            levelOutput.value = level.value;
        });
    </script>
</x-app-layout>
