<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // STEP7まで
    // public function index()
    // {
    //     $model = new Product();
    //     $products = Product::with('company')->get();
    //     $companies = Company::all();
    

    //     return view('list', ['products' => $products, 'companies' => $companies]);
    // }
    public function index(Request $request)
    {
        $model = new Product();
        $direction = $request->input('direction', 'desc'); // デフォルトは降順
        $sortColumn = $request->input('sort', 'id'); // デフォルトのソートカラム

        $products = Product::sortable([$sortColumn => $direction])->with('company')->get();
        $companies = Company::all();

        return view('list', ['products' => $products, 'companies' => $companies]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('create')
            ->with('companies', $companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required | integer',
            'stock' => 'required | integer',
        ]);
    
        $input = $request->all();
    
        return DB::transaction(function () use ($input, $request) {
            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $imagePath = $image->store('public/img_path'); 
                $input['img_path'] = str_replace('public/', 'storage/', $imagePath);
            }
    
            $product = new Product();
            $product->createProduct($input);

        
            return redirect()->route('products.list')
                ->with('success','商品を登録しました');
        });
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $companies = Company::all();
        return view('detail', ['product' => $product ])
        ->with('companies', $companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        $companies = Company::all();
        return view('edit', ['product' => $product ])
        ->with('companies', $companies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);
    
        return DB::transaction(function () use ($request, $product) {
            $data = $request->except(['_token', '_method']);
    
            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $imagePath = $image->store('public/img_path');
                $data['img_path'] = str_replace('public/', 'storage/', $imagePath);
            }
    
            $product->updateProduct($data);
    
            return redirect()->route('products.edit', $product->id)
                ->with('success', '商品情報が更新されました');
        });
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {    
        
        return DB::transaction(function () use ($product) {
            $product->deleteProduct();

            // return redirect()->route('products.list')
            //     ->with('success', '商品が削除されました');
            return response()->json(['message' => '商品が削除されました']);
        });
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $companyId = $request->input('maker');
        $minPrice = $request->input('min-price');
        $maxPrice = $request->input('max-price');
        $minStock = $request->input('min-stock');
        $maxStock = $request->input('max-stock');
        
    
        $products = Product::searchProducts($keyword, $companyId, $minPrice, $maxPrice, $minStock, $maxStock)->load('company');
        // $products = Product::with('company')->searchProducts($keyword, $companyId)->get();　これでは表示できなかった
        // $products = Product::searchProducts($keyword, $companyId); STEP7状態
        $companies = Company::all();
    
        $data = [
            'products' => $products->toArray(),
            'companies' => $companies->toArray(),
        ];
    
        return response()->json($data);
        // return view('list', ['products' => $products, 'companies' => $companies]);
    }
}
