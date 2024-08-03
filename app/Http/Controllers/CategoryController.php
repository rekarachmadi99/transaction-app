<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function CategoryView(){
        return view('pages/main/category/index',[
            'i' => 1,
            'categoryList' => DB::select('select * from category_product')
        ]);
    }

    public function CategoryAddView(){
        return view('pages/main/category/create',[
            'categoryList' => DB::select('select * from category_product')
        ]);
    }
    public function CategoryAddPost(Request $request){
        $categoryName = $request->input('categoryName');
        $meId = Session::get('employee_id');
        DB::select('INSERT INTO category_product (category_name, created_by, updated_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?)',[$categoryName, $meId, $meId, now(), now()]);

        return Redirect::route('category')->with('success', 'Kategori baru berhasil disimpan');
    }
    public function CategoryUpdateView($id){
        $categoryData = DB::select('select * from category_product where category_id = ?',[$id]);
        return view('pages/main/category/update',[
            'categoryData'=> $categoryData[0]
        ]);
    }
    public function CategoryUpdatePut(Request $request, $id){
        $categoryName = $request->input('categoryName');
        $meId = Session::get('employee_id');

        DB::select('UPDATE category_product SET category_name = ?, updated_by = ?, updated_at = ? WHERE category_id = ?',[$categoryName, $meId, now(), $id]);
        return Redirect::route('category')->with('success', 'Kategori dengan id '.$id." berhasil disimpan.");
    }
    public function CategoryDelete($id){
        DB::select('DELETE FROM category_product WHERE category_id = ?',[$id]);
        return Redirect::route('category');
    }
}
