$(document).ready(function() {

    $('#product-search-form').on('click', function(event) {
        event.preventDefault();
        // 検索フォーム内の値を取得
        let keyword = $('#keyword').val();
        let maker = $('#maker').val();
        let minPrice = $('#min-price').val();
        let maxPrice = $('#max-price').val();
        let minStock = $('#min-stock').val();
        let maxStock = $('#max-stock').val(); 
    
        $.ajax({
            type: 'GET',
            url: '/v-machine/public/search',
            data: {
                keyword: keyword,
                maker: maker,
                'min-price': minPrice,
                'max-price': maxPrice,
                'min-stock': minStock,
                'max-stock': maxStock, 
            },
            dataType: 'json',
        }).done(function (response) {
            console.log('成功しました');
    
            let products = response.products;
            let tableBody = $('#product-table tbody');
    
            tableBody.empty(); 
    
            for (let product of products) {
                let detailUrl = '/v-machine/public/detail/' + product.id;
                let deleteUrl = '/' + product.id;
    
                let row = `
                    <tr>
                        <td>${product.id}</td>
                        <td><img src="${product.img_path}" alt="商品画像"></td>
                        <td>${product.product_name}</td>
                        <td>${product.price}</td>
                        <td>${product.stock}</td>
                        <td>${product.company.company_name}</td>
                        <td><a href="${detailUrl}" class="detail_btn">詳細</a></td>
                        // 削除ボタンに商品IDをカスタムデータとして埋め込む
                        <td><button class="delete_btn" data-product-id="${product.id}">削除</button></td>

                    </tr>`;
                tableBody.append(row);
                // tablesorterを更新
                $('#product-table').trigger('update');
            }
        }).fail(function (error) {
            alert('失敗しました！');
        });
    });
    
    // ソート機能
    // tablesorter を適用
    $('#product-table').tablesorter();
    

    // 削除処理の非同期処理
    $('#product-table').on('click', '.delete_btn', function() {
        var deleteConfirm = confirm('削除してもよろしいでしょうか？')

        if(deleteConfirm) {
            var clickEle = $(this);
            // 削除ボタンに商品IDをカスタムデータとして埋め込む
            var productID = clickEle.attr('data-product-id');

            $.ajax({
                type: 'POST',
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/v-machine/public/products/' + productID,
                data: {
                    '_method': 'DELETE',
                }
            })
            .done(function(data) {
                clickEle.parents('tr').hide(); // 削除された行を非表示
            })
            .fail(function() {
                alert('エラー');
            });
        }
    });
});
