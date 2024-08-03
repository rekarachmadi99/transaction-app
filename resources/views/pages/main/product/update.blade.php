@extends('layouts.main-layout')

@section('title', 'Update Produk')

@section('content')
    <div class="mb-6">
        <a href="{{ route('product') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Update Produk</h1>
            </div>

            <form action="{{ route('updateproduct.put', $productData->product_id) }}" method="POST" class="px-6 py-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="productName" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="productName" id="productName" value="{{ $productData->product_name }}"
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantitas</label>
                    <input type="number" name="quantity" id="quantity" value="{{ $productData->quantity }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                    <input type="number" name="price" id="price" value="{{ $productData->price }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category" id="category" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach ($categoryList as $category)
                            <option value="{{ $category->category_id }}"
                                {{ $category->category_id == $productData->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="discount" class="block text-sm font-medium text-gray-700">Diskon (%)</label>
                    <input type="text" name="discount" id="discount" value="{{ $productData->discount }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
