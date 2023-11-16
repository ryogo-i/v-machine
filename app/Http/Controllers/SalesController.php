<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;


class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから必要なデータを取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); //購入数を代入。データがない場合１を代入。

        //　DBから対象の商品を検索、取得
        $product =Product::find($productId); 

        // 商品が存在しない場合のバリデーションを行う
        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
        // 在庫が足りないときエラー
        if($product->stock < $quantity) {
            return response()->json(['message' => '在庫不足です']);
        }

        // 在庫数を減算
        $product->stock -= $quantity;
        $product->save();

        // Salesテーブルに商品Idと購入日時を記録する
        $sale = new Sale([
            'product_id' => $productId,
        ]); //新しい Sale モデルのインスタンスを作成し、'product_id' の値をセット。日時は自動。

        $sale->save();

        return response()->json(['message' => '購入できました']);

    }
}
