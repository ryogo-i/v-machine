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

}
