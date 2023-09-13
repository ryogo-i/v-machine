@extends('layouts.app')
@section('title', '商品情報詳細画面')
@section('content')
<div class="card">
    <h1>商品情報詳細画面</h1>
    <div class="details">
        <div class="detail-row">
            <div class="label">ID</div>
            <div class="value">{{ $product->id }}.</div>
        </div>
        <div class="detail-row">
            <div class="label">商品画像</div>
            <div class="value">
                <img src="{{ $product->image_path }}" alt="Product Image">
            </div>
        </div>
        <div class="detail-row">
            <div class="label">商品名</div>
            <div class="value">{{ $product->product_name }}</div>
        </div>
        <div class="detail-row">
            <div class="label">メーカー</div>
            <div class="value">{{ $product->company_id }}</div>
        </div>
        <div class="detail-row">
            <div class="label">価格</div>
            <div class="value">￥{{ $product->price }}</div>
        </div>
        <div class="detail-row">
            <div class="label">在庫数</div>
            <div class="value">{{ $product->stock }}</div>
        </div>
        <div class="detail-row">
            <div class="label">コメント</div>
            <div class="value">{{ $product->comment }}</div>
        </div>
    </div>
    <div class="button-row">
        <a href="{{ route('products.edit', $product->id) }}" class="edit-button">編集</a>
        <a class="btn btn-success" href="{{ url('list') }}">戻る</a>
    </div>
</div>
@endsection
