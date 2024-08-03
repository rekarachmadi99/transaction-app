@extends('layouts.main-layout')

@section('title', 'History Transaction')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <h1 class="text-2xl font-semibold mb-4">Histori Transaksi</h1>
            <div class="px-4 py-3  flex items-center justify-between">
                <input type="text" id="search" placeholder="Search..."
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <div class="ml-4 flex space-x-2">
                    <select id="sortBy"
                        class="mt-1 block px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="product_id">Id Produk</option>
                        <option value="product_name">Nama Produk</option>
                        <option value="quantity">Quantity</option>
                        <option value="price">Harga</option>
                        <option value="category_name">Kategori</option>
                        <option value="discount">Diskon</option>
                    </select>
                    <select id="sortOrder"
                        class="mt-1 block px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table id="transactionTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTableBody" class="bg-white divide-y divide-gray-200">
                        @foreach ($trxList as $index => $data)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                    {{ number_format($data->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('historytransactiondetail', $data->trx_id) }}"
                                        class="text-blue-500 hover:underline">View Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactions = @json($trxList);
            const tableBody = document.getElementById('transactionTableBody');
            const searchInput = document.getElementById('search');
            const sortBySelect = document.getElementById('sortBy');
            const sortOrderSelect = document.getElementById('sortOrder');

            function renderTable(data) {
                tableBody.innerHTML = '';
                data.forEach((transaction, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${new Date(transaction.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp ${transaction.total_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="/transactionhistory/detail/${transaction.trx_id}" class="text-blue-500 hover:underline">View Detail</a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            function updateTable() {
                let filteredTransactions = transactions;

                // Filter
                const searchQuery = searchInput.value.toLowerCase();
                filteredTransactions = filteredTransactions.filter(transaction =>
                    transaction.created_at.toLowerCase().includes(searchQuery) ||
                    transaction.total_amount.toString().includes(searchQuery)
                );

                // Sort
                const sortBy = sortBySelect.value;
                const sortOrder = sortOrderSelect.value;
                filteredTransactions.sort((a, b) => {
                    if (a[sortBy] < b[sortBy]) return sortOrder === 'asc' ? -1 : 1;
                    if (a[sortBy] > b[sortBy]) return sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });

                renderTable(filteredTransactions);
            }

            searchInput.addEventListener('input', updateTable);
            sortBySelect.addEventListener('change', updateTable);
            sortOrderSelect.addEventListener('change', updateTable);

            updateTable(); // Initial call
        });
    </script>
@endsection
