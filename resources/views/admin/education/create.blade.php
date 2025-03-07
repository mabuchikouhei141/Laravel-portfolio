<x-app-layout>
@section('title', '学歴管理 | マイポートフォリオ')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('学歴追加') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.education.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="institution" class="block text-sm font-medium text-gray-700">学校名</label>
                            <input type="text" name="institution" id="institution" value="{{ old('institution') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('institution')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="degree" class="block text-sm font-medium text-gray-700">学位</label>
                            <input type="text" name="degree" id="degree" value="{{ old('degree') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('degree')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                       <div class="mb-4">
    <label for="field" class="block text-sm font-medium text-gray-700">専攻</label>
    <input type="text" name="field" id="field" value="{{ old('field') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('field')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> 
                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">開始日</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="current" id="current" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="1" {{ old('current') ? 'checked' : '' }}>
                                <label for="current" class="ml-2 block text-sm text-gray-700">現在も在学中</label>
                            </div>
                        </div>
                        
                        <div class="mb-4" id="end_date_container">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">終了日</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">説明・業績</label>
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.education.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                キャンセル
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 現在在学中チェックボックスの状態によって終了日フィールドの表示/非表示を切り替え
        document.addEventListener('DOMContentLoaded', function() {
            const currentCheckbox = document.getElementById('current');
            const endDateContainer = document.getElementById('end_date_container');
            
            function updateEndDateVisibility() {
                if (currentCheckbox.checked) {
                    endDateContainer.style.display = 'none';
                } else {
                    endDateContainer.style.display = 'block';
                }
            }
            
            // 初期状態を設定
            updateEndDateVisibility();
            
            // チェックボックスの状態が変わったとき
            currentCheckbox.addEventListener('change', updateEndDateVisibility);
        });
    </script>
</x-app-layout>
