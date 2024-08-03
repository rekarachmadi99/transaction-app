@extends('layouts/main-layout')

@section('title', 'Create Transaction')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Transaksi</h1>

        <form action="{{ route('transaction.post') }}" method="POST" id="transaction-form">
            @csrf

            <div class="mb-6">
                <label for="product" class="block text-sm font-medium text-gray-700">Select Product</label>
                <select name="product_id" id="product"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @foreach ($productList as $product)
                        <option value="{{ $product->product_id }}" data-price="{{ $product->price }}"
                            data-stock="{{ $product->quantity }}" data-discount="{{ $product->discount }}">
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <button type="button" id="add-product"
                    class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Add Product
                </button>
            </div>

            <div class="overflow-x-auto mt-6">
                <table id="selected-products"
                    class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Product</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Price</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Quantity</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Discount</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Total</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-center mt-6">
                <div class="text-xl font-semibold text-gray-800">
                    Grand Total: <span id="grand-total" class="font-bold text-blue-600">Rp 0,00</span>
                </div>
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Save Transaction
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addedProductIds = new Set();

            document.getElementById('add-product').addEventListener('click', function() {
                const productSelect = document.getElementById('product');
                const selectedProduct = productSelect.options[productSelect.selectedIndex];
                const productId = selectedProduct.value;
                const productName = selectedProduct.text;
                const productPrice = parseFloat(selectedProduct.getAttribute('data-price'));
                const productDiscount = parseFloat(selectedProduct.getAttribute('data-discount'));
                const productStock = parseInt(selectedProduct.getAttribute('data-stock'));

                if (addedProductIds.has(productId)) {
                    alert('This product has already been added.');
                    return;
                }

                const tableBody = document.getElementById('selected-products').getElementsByTagName(
                    'tbody')[0];
                const row = tableBody.insertRow();

                row.insertCell(0).textContent = productName;
                row.insertCell(1).textContent = formatRupiah(productPrice);
                row.insertCell(2).innerHTML =
                    `<input type="number" name="quantity[${productId}]" min="1" max="${productStock}" class="quantity w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="1">`;
                row.insertCell(3).textContent = `${productDiscount.toFixed(2)}%`;
                row.insertCell(4).textContent = formatRupiah(calculateTotal(productPrice, productDiscount,
                    1));
                row.insertCell(5).innerHTML =
                    '<button type="button" class="remove-product bg-red-600 text-white px-3 py-2 rounded-md shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Remove</button>';

                addedProductIds.add(productId);

                selectedProduct.disabled = true;

                updateTotal();

                document.querySelectorAll('.remove-product').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.parentElement.parentElement;
                        const removedProductId = row.querySelector('input').name.match(
                            /\d+/)[0];
                        addedProductIds.delete(
                            removedProductId); // Remove the product ID from the set
                        row.remove();
                        updateTotal();

                        // Re-enable the product option in the dropdown
                        const option = Array.from(productSelect.options).find(opt => opt
                            .value === removedProductId);
                        if (option) {
                            option.disabled = false;
                        }
                    });
                });

                document.querySelectorAll('.quantity').forEach(input => {
                    input.addEventListener('input', function() {
                        const row = this.parentElement.parentElement;
                        const price = parseFloat(row.cells[1].textContent.replace('Rp ', '')
                            .replace('.', '').replace(',', '.'));
                        const discount = parseFloat(row.cells[3].textContent.replace('%',
                            ''));
                        const quantity = parseInt(this.value);

                        if (quantity > 0 && quantity <= parseInt(this.max)) {
                            row.cells[4].textContent = formatRupiah(calculateTotal(price,
                                discount, quantity));
                            updateTotal();
                        } else {
                            this.value = this.max;
                            row.cells[4].textContent = formatRupiah(calculateTotal(price,
                                discount, this.max));
                            updateTotal();
                        }
                    });
                });
            });

            document.getElementById('transaction-form').addEventListener('submit', function(event) {
                const tableBody = document.getElementById('selected-products').getElementsByTagName(
                    'tbody')[0];
                if (tableBody.rows.length === 0) {
                    alert('You must add at least one product.');
                    event.preventDefault(); // Prevent form submission
                }
            });

            function calculateTotal(price, discount, quantity) {
                const total = (price * quantity) * (1 - (discount / 100));
                return total;
            }

            function updateTotal() {
                const rows = document.getElementById('selected-products').getElementsByTagName('tbody')[0].rows;
                let grandTotal = 0;
                for (const row of rows) {
                    grandTotal += parseFloat(row.cells[4].textContent.replace('Rp ', '').replace('.', '').replace(
                        ',', '.'));
                }
                document.getElementById('grand-total').textContent = formatRupiah(grandTotal);
            }

            function formatRupiah(amount) {
                return 'Rp ' + amount
            }
        });
    </script>
@endsection
