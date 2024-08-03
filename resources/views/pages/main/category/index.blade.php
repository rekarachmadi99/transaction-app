@extends('layouts.main-layout')

@section('title', 'Kategori Produk')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Kategori Produk</h1>
                <a href="{{ route('addcategory') }}"
                    class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Kategori</a>
            </div>

            @if (session('success'))
                <div id="successMessage" class="mb-4">
                    <div class="bg-green-500 text-white p-3 rounded">
                        <ul>
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Search and Sort -->
                <div class="px-4 py-3 bg-gray-50 flex items-center justify-between">
                    <input type="text" id="search" placeholder="Search..."
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <div class="ml-4 flex space-x-2">
                        <select id="sortBy"
                            class="mt-1 block px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="category_id">Id Kategori</option>
                            <option value="category_name">Nama Kategori</option>
                        </select>
                        <select id="sortOrder"
                            class="mt-1 block px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="categoryTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody" class="bg-white divide-y divide-gray-200">
                            @foreach ($categoryList as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $i++ }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->category_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('updatecategory', $category->category_id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('deletecategory.destroy', $category->category_id) }}"
                                            method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 px-4 py-3 bg-gray-50 flex items-center justify-between">
                    <div id="pagination" class="flex items-center space-x-2">
                        <!-- Pagination buttons will be added here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categories = @json($categoryList);
            const tableBody = document.getElementById('categoryTableBody');
            const searchInput = document.getElementById('search');
            const sortBySelect = document.getElementById('sortBy');
            const sortOrderSelect = document.getElementById('sortOrder');
            const paginationDiv = document.getElementById('pagination');
            const successMessage = document.getElementById('successMessage');

            let currentPage = 1;
            const rowsPerPage = 10;

            function renderTable(data) {
                tableBody.innerHTML = '';
                data.forEach(category => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${currentPage * rowsPerPage - rowsPerPage + data.indexOf(category) + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${category.category_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="/category/update/${category.category_id}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="/category/delete/${category.category_id}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            function updatePagination(pages) {
                paginationDiv.innerHTML = '';
                for (let i = 1; i <= pages; i++) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.className = 'px-4 py-2 border rounded hover:bg-gray-200';
                    button.addEventListener('click', () => {
                        currentPage = i;
                        updateTable();
                    });
                    paginationDiv.appendChild(button);
                }
            }

            function updateTable() {
                let filteredCategories = categories;

                // Filter
                const searchQuery = searchInput.value.toLowerCase();
                filteredCategories = filteredCategories.filter(category =>
                    category.category_name.toLowerCase().includes(searchQuery)
                );

                // Sort
                const sortBy = sortBySelect.value;
                const sortOrder = sortOrderSelect.value;
                filteredCategories.sort((a, b) => {
                    if (a[sortBy] < b[sortBy]) return sortOrder === 'asc' ? -1 : 1;
                    if (a[sortBy] > b[sortBy]) return sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });

                // Pagination
                const totalPages = Math.ceil(filteredCategories.length / rowsPerPage);
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;
                const paginatedCategories = filteredCategories.slice(startIndex, endIndex);

                renderTable(paginatedCategories);
                updatePagination(totalPages);
            }

            searchInput.addEventListener('input', updateTable);
            sortBySelect.addEventListener('change', updateTable);
            sortOrderSelect.addEventListener('change', updateTable);

            // Hide success message after 5 seconds
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            }

            updateTable(); // Initial call
        });
    </script>
@endsection
