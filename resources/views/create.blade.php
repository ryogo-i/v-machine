@extends('layouts.app')
@section('title', '商品新規登録画面')
@section('content')
<div class="card">
    <p>商品新規登録画面</p>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder='商品名を入力してください'>
            @error('product_name')
            <span class="error_message">商品名を入力してください</span>
            @enderror
        </div> 
        <div class="form-group"> 
            <label for="maker">メーカー名</label>
            <select class="form-control" id="company_id" name="company_id">
                <option>メーカーを選択してください</option>
                @foreach ($companies as $company)
                <option value="{{ $company->id }}"> {{ $company->company_name }}</option>
                @endforeach
            </select>
            @error('company_id')
            <span class="error_message">メーカーを選択してください</span>
            @enderror
        </div> 
        <div class="form-group"> 
            <label for="price">価格</label> 
            <input type="number" class="form-control" id="price" name="price" placeholder='価格を入力してください'> 
            @error('price')
            <span class="error_message">価格を入力してください</span>
            @enderror
        </div> 
        <div class="form-group"> 
            <label for="stock">在庫数</label> 
            <input type="number" class="form-control" id="stock" name="stock" placeholder='在庫数を入力してください'> 
            @error('stock')
            <span class="error_message">在庫を入力してください</span>
            @enderror
        </div> 
        <div class="form-group"> 
            <label for="comment">コメント</label> 
            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder='コメントを入力してください'></textarea> 
        </div> 
        <div class="form-group"> 
            <label for="image">商品画像</label> 
            <input type="file" class="img_path" id="img_path" name="img_path"> 
        </div>
        <button type="submit" class="btn btn-primary">新規登録</button>
        <a class="btn btn-success" href="{{ url('list') }}">戻る</a>        
    </form>
</div>

@endsection

