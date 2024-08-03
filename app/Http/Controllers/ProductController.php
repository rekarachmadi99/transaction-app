<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function ProductView(){
        return view('pages/main/product/index',[
            'i' => 1,
            'productList' => DB::select('select product_id, product_name, quantity, price, cat.category_name, discount from product_list prod LEFT JOIN category_product cat ON prod.category_id = cat.category_id')
        ]);
    }

    public function ProductAddView(){
        return view('pages/main/product/create',[
            'categoryList' => DB::select('select * from category_product')
        ]);
    }
    public function ProductAddPost(Request $request){
        $request->validate([
            'productName' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|exists:category_product,category_id',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $productName = $request->input('productName');
        $qty = $request->input('quantity');
        $price = $request->input('price');
        $category = $request->input('category');
        $discount = $request->input('discount');
        DB::select('INSERT INTO product_list (product_name, quantity, price, category_id, discount, created_by, updated_by, created_at, updated_at) VALUES ( ?, ?, ?, ?, ?, ?, ?, NOW(),NOW());', [$productName, $qty, $price, $category, $discount, Session::get('employee_id'), Session::get('employee_id')]);

        //return redirect()->route('product')->with('success', 'Product added successfully.');
    }

    public function ProductUpdateView($id){
        $productData = DB::select('select product_id, product_name, quantity, price, category_id, discount from product_list where product_id = ?',[$id]);
        $categoryList = DB::select('select * from category_product');
        return view('pages/main/product/update',[
            'productData' => $productData[0],
            'categoryList' => $categoryList
        ]);
    }

    public function ProductUpdatePut(Request $request, $id){
        $request->validate([
            'productName' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|integer|exists:category_product,category_id',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $productName = $request->input('productName');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $category = $request->input('category');
        $discount = $request->input('discount');

        DB::select('UPDATE product_list SET product_name = ?, quantity = ?, price = ?, category_id = ?, discount = ?, updated_by = ?, updated_at = ? WHERE product_id = ?',[$productName, $quantity, $price, $category, $category,Session::get('employee_id'), now(), $id]);

        return redirect()->route('product')->with('success', 'Produk dengan id '.$id." berhasil diupdate.");
    }
    public function ProductDelete($id){
        DB::select('DELETE FROM product_list WHERE product_id = ?',[$id]);

        return redirect()->route('product')->with('success', 'Produk dengan id '.$id." berhasil dihapus.");
    }
}
