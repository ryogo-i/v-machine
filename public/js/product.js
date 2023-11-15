$(document).ready(function() {

    $('#product-search-form').on('click', function() {
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
            alert('成功しました');
    
            let products = response.products;
            let tableBody = $('#product-table tbody');
    
            tableBody.empty(); 
    
            for (let product of products) {
                let detailUrl = '/detail/' + product.id;
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
                        <td><button class="delete_btn" onclick="confirmDelete('${deleteUrl}')">削除</button></td>
                    </tr>`;
                tableBody.append(row);
            }
        }).fail(function (error) {
            alert('失敗しました！');
        });
    })
    
    // ソート機能
    $(document).ready(function() {
        $('#product-table th a').on('click', function() {
            e.preventDefault();
    
            // リンクのhrefからソートの方向を取得
            var href = $(this).attr('href');
            var direction = 'asc';
            if (href.indexOf('desc') !== -1) {
                direction = 'desc';
            }
    
            $.ajax({
                url: href,
                data: {
                    direction: direction
                },
                success: function(data) {
                    // ソートされたデータをテーブルに反映
                    $('#product-table tbody').html(data);
                }
            });
        });
    });

    // 削除処理の非同期処理
    $('.delete_btn').on('click', function() {
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


