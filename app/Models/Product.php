<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'img_path',
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'created_at',
        'updated_at',
        ];

    public function getList() {
        // productsテーブルからデータを取得
        $products = DB::table('products')->get();

        return $products;
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // 商品を作成
    public function createProduct(array $input) {
        return $this->create($input);
    }

    // 商品情報を更新
    public function updateProduct($data) {
        $this->update($data);
    }

    // 商品を削除
    public function deleteProduct() {
        $this->delete();
    }

    // 商品一覧を表示
    public function getAllProducts() {
        return static::with('company')->get();
    }

    public static function serchProducts($keyword, $companyId) {
        $query = static::query();

        if($keyword) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

        if($companyId) {
            $query->where('company_id', $companyId);
        }

        return $query->get();
    }

}
