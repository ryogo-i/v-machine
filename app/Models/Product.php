<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable; //STEP8で追加

class Product extends Model
{
    use HasFactory, Sortable; // STEP8でSortable トレイトを使用

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

    public $sortable = [
        'id', 'img_path', 'product_name', 'price', 'stock', 'company.company_name' // ソート可能なカラムを指定
    ];//STEP8で追加

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

    public static function searchProducts($keyword, $companyId, $minPrice, $maxPrice, $minStock, $maxStock) {
        $query = static::query();

        if($keyword) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

        if($companyId) {
            $query->where('company_id', $companyId);
        }

        if($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        if($minStock) {
            $query->where('stock', '>=', $minStock);
        }

        if($maxStock) {
            $query->where('stock', '<=', $maxStock);
        }

        return $query->get();
    }

}
