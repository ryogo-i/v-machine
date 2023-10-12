$(document).ready(function () {
    // 商品一覧表示時
    $.ajax({
        type: 'GET',
        url: '/list',
        dataType: 'json',
    }).done(function (response) {
        alert('成功しました');

        let products = response.products;
        let tableBody = $('#product-table tbody');

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
});





// $('.product-search-form').on('click', function() {
    
// })
