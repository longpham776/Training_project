const { remove, isEmpty } = require("lodash");

$(document).on('click', '.editBtn', function () {

    $('.error').text("");

    let productId = $(this).data('id');

    let url = $(this).data('url');

    $.ajax({
        url: url,
        method: "GET",
        data: productId,

        success: function (data) {
            console.log(data[0]);

            $('.btnStore').hide();

            $('.btnUpdate').show();

            $('#fileImage').val(null);

            $('input[name=productId]').val(productId);

            $('input[name=name]').val(data[0]['product_name']);

            $('input[name=price]').val(data[0]['product_price']);

            $('input[name=imageName]').val(data[0]['product_image']);

            CKEDITOR.instances.description.setData(data[0]['description']);

            if (data[0]['is_sales'] == 1)
                $('form#addProduct select').val(data[0]['is_sales']).change();
            else if (data[0]['is_sales'] == 0)
                $('form#addProduct select').val(data[0]['is_sales']).change();

            if (data[0]['product_image'] != null)
                $('img[name=image]').attr('src', `http://${location.host}/Rcv_Project/public/images/${data[0]['product_image']}`);
            else $('img[name=image]').attr('src', 'https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg');

        },

        error: function () {
            console.log("Fail get data product!");
        }
    });
});

$('.btnUpdate').on('click', function (e) {

    e.preventDefault();

    CKEDITOR.instances.description.updateElement();

    let productData = new FormData($('#addProduct')[0]);

    let productId = $('#productId').val();

    let productOldData = jQuery.parseJSON($(`#product${productId}`).attr("data-init"));

    let url = `${location.pathname}/${productId}`;

    console.log(productData.get('fileImage')['name'], productOldData);

    if (productOldData['product_name'] != productData.get('name')) {

        return updateProduct(url, productData, productId);
    }

    if (productOldData['product_price'] != productData.get('price')) {

        return updateProduct(url, productData, productId);
    }

    // productOldData['product_image'] = productOldData['product_image'] ?? '';    
    console.log((productOldData['product_image'] || '') , $('#imageName').val());
    if ((productOldData['product_image'] || '') != $('#imageName').val()) {

        console.log("Image not equal!");

        return updateProduct(url, productData, productId);
    }

    console.log('Value equal!');

    console.log("Don't use ajax!");

    $('.error').text("");

    $('#modelId').modal('hide');

    $('#addProduct')[0].reset();

});

function updateProduct(url, productData, productId) {
    console.log("Use ajax!");

    $.ajax({
        url: url,
        method: "POST",
        data: productData,
        contentType: false,
        processData: false,

        success: function ({ status, product, productJson }) {

            let h6 = $(`#product${productId} h6`);

            console.log($(`#product${productId}`).attr("data-init"), productJson);

            $(`#product${productId}`).attr("data-init", productJson);

            console.log($(`#product${productId}`).attr("data-init"));

            $.each(h6, function (index, value) {

                let h6Id = $(value).attr('id');

                if (h6Id == "sale") {

                    if (product[h6Id] == 1) {

                        $(value).text("C?? h??ng b??n");

                        $(value).attr('class', 'text-success');
                    } else if (product[h6Id] == 0) {

                        $(value).text("D???ng b??n");

                        $(value).attr('class', 'text-danger');
                    }

                    return true;
                }

                if (h6Id == "price") {

                    $(value).text(`$${product[h6Id]}`);

                    return true;
                }

                if (h6Id == "description") {

                    $(value).text($(product[h6Id]).text());

                    return true;
                }

                $(value).text(product[h6Id]);
            });

            $('.error').text("");

            $('#modelId').modal('hide');

            $('#addProduct')[0].reset();

        },

        error: function ({ responseJSON }) {

            let errors = responseJSON.errors || undefined;

            if (errors === undefined) {
                alert("Server Fail!");
                return;
            }

            let printError = $('.error');

            console.log(errors);

            $.each(printError, function (index, value) {

                let productId = $(value).attr('id');

                if (productId && errors[productId]) {

                    $.each(errors[productId], function (index, messError) {
                        $(`.error#${productId}`).text(messError);

                    });

                } else $(`.error#${productId}`).text("");

            });
        }
    });
}

$('#fileImage').on('change', function(e){

    let file = e.target.files[0];

    if(!file){
        
        $('#imageName').val('');
        $('#image').attr('src', 'https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg');

        return;
    }


    console.log("file Image",file);

    let fileName = file.name;

    let url = URL.createObjectURL(file);

    $('#image').attr('src', url);

    console.log("fileName", fileName);

    $('#imageName').val(fileName);
});

$('#btnClearImage').on('click', function (e) {

    $('#fileImage').val(null);
    $('#fileImage').trigger('change');
    $('.error#fileImage').text("");

    $('#image').attr('src', 'https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg');
});

$('.btnStore').on('click', function (e) {

    e.preventDefault();

    CKEDITOR.instances.description.updateElement();

    let addData = new FormData($('#addProduct')[0]);

    let url = $(this).data('url');

    $.ajax({
        url: url,
        method: "POST",
        data: addData,
        contentType: false,
        processData: false,

        success: function ({ status, html, message }) {

            if (status) {
                $('#listProduct').html(html);
                $('#modelId').modal('hide');
                $('#addProduct')[0].reset();
            }
            $('.error').text("");
            alert(message);
        },

        error: function ({ responseJSON }) {

            let errors = responseJSON.errors || undefined;

            if (errors === undefined) {
                alert("Server Fail!");
                return;
            }

            let printError = $('.error');

            console.log(errors);

            $.each(printError, function (index, value) {

                let productId = $(value).attr('id');

                if (productId && errors[productId]) {

                    $.each(errors[productId], function (index, messError) {
                        $(`.error#${productId}`).text(messError);

                    });

                } else $(`.error#${productId}`).text("");

            });
        }
    });
});

$(document).on('click', '.btnDelete', function (e) {

    console.log($(this).data('id'), $(this).data('name'));

    let url = $(this).data('url');

    let product_id = $(this).data('id');

    let product_name = $(this).data('name');

    let result = confirm("B???n c?? mu???n x??a s???n ph???m " + product_name + " kh??ng");

    if (!result) {
        return false;
    }

    $.ajax({

        url: url,
        method: "delete",

        success: function (mess) {
            console.log("Delete Success!");

            $(`#product${product_id}`).remove();

            if ($('#listProduct tbody').children().length <= 0) {

                console.log("List null");

                getData(1);
            }

            $('.noticeSuccess span#text').text(mess['mess']);

            $('.noticeSuccess').show();

            alert(mess['mess']);
        },

        error: function (mess) {
            console.log("Delete Fail!");

            $('.noticeFail span#text').text(mess['mess']);

            $('.noticeFail').show();
        }
    });
});

$('#btnClear').on('click', function () {
    $('.searchProduct')[0].reset();
    getData(1);
});

$('#btnSearch').on('click', function (e) {

    e.preventDefault();

    let searchData = $('.searchProduct').not(':button').serializeArray();

    getData(1);
});

$(document).ready(function () {
    $('.btnUpdate').hide();

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        console.log('click pagination');
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var page = $(this).attr('href').split('page=')[1];

        getData(page);
    });
});

function getData(page) {
    // body...
    let searchData = $('.searchProduct').not(':button').serializeArray();

    $.ajax({
        url: '?page=' + page,
        type: 'get',
        data: searchData,
        datatype: 'html',
    }).done(function (html) {
        $('#listProduct').html(html);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('No response from server');
    });
}

// $('.btnCancel').on('click', function () {
//     $('#addProduct')[0].reset();
//     $('#addProduct span').text("");
// });

// $('.close').on('click', function () {
//     $('#addProduct')[0].reset();
//     $('#addProduct span').text("");
// });

$('#btnAdd').on('click', function () {

    CKEDITOR.instances.description.setData("");

    $('.error').text("");

    $('.btnUpdate').hide();

    $('.btnStore').show();

    $('#addProduct')[0].reset();

    $('img[name=image]').attr('src', 'https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg');
});

$('#exampleModal').on('show.bs.modal', event => {
    var button = $(event.relatedTarget);
    var modal = $(this);
    // Use above variables to manipulate the DOM

});