<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Product();
        $products = Product::with('company')->get();
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
            'stock'=> 'required | integer',
        ]);

        $input = $request->all();
        Product::create($input);
        return redirect()->route('products.list')
        ->with('success','商品を登録しました');

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
            'price' => 'required | integer',
            'stock'=> 'required | integer',
        ]);

        $product->product_name = $request->input(["product_name"]);
        $product->company_id = $request->input(["company_id"]);
        $product->price = $request->input(["price"]);
        $product->stock = $request->input(["stock"]);
        $product->comment = $request->input(["comment"]);
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $imagePath = $image->store('public/img_path'); 
            $product->img_path = $imagePath;
        }

        $product->save(); 

        return redirect()->route('products.edit', $product->id)
            ->with('success', '商品情報が更新されました');
    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {    
        $product->delete(); 
        
        return redirect()->route('products.list')
            ->with('success', '商品が削除されました');
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $companyId = $request->input('maker');

        $query = Product::query();

        if ($keyword) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }
    
        if ($companyId) {
            $query->where('company_id', $companyId);
        }
    
        $products = $query->get();
        $companies = Company::all();
    
        return view('list', ['products' => $products, 'companies' => $companies]);
    }
}
