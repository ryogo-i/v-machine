@extends('layouts.app')
@section('title', '商品一覧画面')
@section('content')
<div class="card">
    <h1>商品一覧画面</h1>
    <div class="search-form">
        <form method="GET" action="{{ route('products.search') }}">
            @csrf
            <input type="text" name="keyword" placeholder="検索キーワード">
            <select name="maker">
                <option value="" disabled selected>メーカー名</option>
                @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <button type="submit" id="product-search-form">検索</button>
        </form>
    </div>
    <table class="table" id="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th colspan="2"><a href="{{ route('products.create') }}" class="new-addition-button">新規登録</a></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr> 
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset($product->img_path) }}" alt="商品画像"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name }}</td>
                <td>
                    <a href="{{ route('products.detail', $product->id) }}" class="detail_btn">詳細</a>
                </td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete_btn">削除</button>
                    </form>
                </td>

                <script>
                function confirmDelete(deleteUrl) {
                    if (confirm("本当に削除しますか？")) {
                    window.location.href = deleteUrl;
                    }
                }
                </script>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<script>
    var baseUrl = '{{ url('/') }}';
</script>

<script src="{{ asset('js/product.js') }}"></script>
@endsection
