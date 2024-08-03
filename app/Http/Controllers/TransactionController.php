<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class TransactionController extends Controller
{
    public function TransactionView(){
        $productList = DB::select('select * from product_list');

        return view('pages.main.transaction.create',[
            'productList' => $productList
        ]);
    }

    public function TransactionPost(Request $request)
    {
        $getId = DB::select('select count(trx_id)+1 as count from trx_list')[0];

        $meId = Session::get('employee_id');

        $totalAmount = 0;
        $tempTotalAmount = 0;

        $productList = array_keys($request->input('quantity'));
        $quantityList = $request->input('quantity');

        foreach($productList as $product){
            $productId = $product;
            $qty = $quantityList[$product];

            $productData = DB::select('select price, discount from product_list where product_id = ?', [$productId])[0];
            $tempTotalAmount = $tempTotalAmount + (($productData->price*$qty)-(($productData->price*$qty)*($productData->discount/100)));

        }
        DB::select('INSERT INTO trx_list (trx_id, trx_date, total_amount, created_by, updated_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)',[$getId->count, now(), $tempTotalAmount, $meId, $meId, now(), now()]);

        foreach($productList as $product){
            $productId = $product;
            $qty = $quantityList[$product];

            $productData = DB::select('select price, discount from product_list where product_id = ?', [$productId])[0];
            $totalAmount = $totalAmount + (($productData->price*$qty)-(($productData->price*$qty)*($productData->discount/100)));

            DB::select('INSERT INTO trx_detail(trx_id, product_id, quantity, price, discount, created_by, updated_by, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$getId->count, $product, $qty, $productData->price, $productData->discount, $meId, $meId, now(), now()]);
        }

        return Redirect::route('transaction');
    }

    public function HistoryTransactionView(){
        $trxList = DB::select('SELECT * FROM trx_list');

        return view('pages.main.transactionhistory.index',[
            'i' => 1,
            'trxList' => $trxList
        ]);
    }

    public function HistoryTransactionDetailView($id){
        $trxList = DB::select('SELECT * FROM trx_list WHERE trx_id = ?',[$id]);
        $trxDetailList = DB::select('SELECT prod.product_name, cat.category_name, prod.price, trx.quantity, prod.discount, (prod.price*trx.quantity)-((prod.price*trx.quantity)*prod.discount/100) AS total_price  FROM trx_detail trx
                                    LEFT JOIN product_list prod ON trx.product_id = prod.product_id
                                    LEFT JOIN category_product cat ON prod.category_id = cat.category_id
                                    WHERE trx_id = ?',[$id]);

        return view('pages.main.transactionhistory.detail',[
            'i' => 1,
            'trxList' => $trxList[0],
            'trxDetailList' => $trxDetailList
        ]);
    }
}
