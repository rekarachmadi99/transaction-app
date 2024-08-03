@extends('layouts.main-layout')

@section('title', 'Update Kategori')

@section('content')
    <div class="mb-6">
        <a href="{{ route('category') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">

            <h1 class="text-2xl font-semibold mb-6 text-gray-800">Update Kategori</h1>

            <form action="{{ route('updatecategory.put', $categoryData->category_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="categoryName" id="categoryName"
                        value="{{ old('categoryName', $categoryData->category_name) }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Save
                </button>
            </form>
        </div>
    </div>
@endsection
