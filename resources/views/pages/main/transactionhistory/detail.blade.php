@extends('layouts.main-layout')

@section('title', 'Transaction Detail')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <div class="mb-6">
                <a href="{{ route('historytransaction') }}"
                    class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <h1 class="text-2xl font-semibold mb-4">Histori Transaksi Detail</h1>

            <div class="bg-white shadow-md rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600"><strong>Date:</strong>
                    {{ \Carbon\Carbon::parse($trxList->created_at)->format('d F Y') }}</p>
                <p class="text-sm text-gray-600"><strong>Total:</strong>
                    Rp. {{ number_format($trxList->total_amount, 0, ',', '.') }}</p>
            </div>

            <h2 class="text-xl font-semibold mb-4">List Produk Dibeli</h2>

            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Diskon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                                Harga</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($trxDetailList as $index => $data)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->product_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->category_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($data->price, 0, ',', '.') }} IDR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->discount }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp. {{ number_format($data->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
