const { remove } = require("lodash");

$('#fileImage').change(function(e){
    
    let files = e.target.files;

    let url = URL.createObjectURL(files[0]);

    $('#image').attr('src',url);

    // console.log(files,url);
    // console.log($('#image').attr('src'));
});

$('#btnClearImage').on('click',function(e){
    $('#fileImage').val("");
    $('.error_fileImage').text("");
    $('#image').attr('src','https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg');
});

$('.btnStore').on('click',function(e){

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

        success: function({status,html,message}){
            if(status){
                $('#listProduct').html(html);
                $('#modelId').modal('hide');
                $('.addProduct')[0].reset();
            }
            alert(message);
        },

        error: function({responseJSON}){
            
            console.log(responseJSON);

            console.log(responseJSON.errors);

            let errors = responseJSON.errors;

            if(Object.getOwnPropertyNames(errors).length){

                console.log("step 1 check error");

                $('form#addProduct input').each(function(index, value) {
                    
                    var name = $(this).attr('name');

                    if(name && errors[name]) {

                        $(errors[name]).each(function(index,value){
                            
                            $(`.error_${name}`).text(value);
                        });

                    }else   $(`.error_${name}`).text("");
                });
            }
        }
    });
});

$('#btnDelete').on('click',function(e){

    console.log($(this).data('id'),$(this).data('name'));

    let url = $(this).data('url');

    let product_id = $(this).data('id');

    let product_name = $(this).data('name');

    let result = confirm("Bạn có muốn xóa sản phẩm "+product_name+" không");

    if(!result){
        return false;
    }

    $.ajax({

        url: url,
        method: "delete",

        success: function(mess){
            console.log("Delete Success!");
            
            $(`#product${product_id}`).remove();

            if($('#listProduct tbody').children().length <= 0){

                console.log("List null");

                getData(1);
            }

            $('.noticeSuccess span#text').text(mess['mess']);

            $('.noticeSuccess').show();

            alert(mess['mess']);
        },

        error: function(mess){
            console.log("Delete Fail!");

            $('.noticeFail span#text').text(mess['mess']);

            $('.noticeFail').show();
        }
    });
});

$('#btnSearch').on('click',function(e){
    
    e.preventDefault();

    let searchData = $('.searchProduct').not(':button').serializeArray();

    getData(1);
});

$(document).ready(function(){
    $(document).on('click','.pagination a',function(event){
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

    console.log(searchData);
    
    $.ajax({
        url : '?page=' + page,
        type : 'get',
        data: searchData,
        datatype : 'html',
    }).done(function(data){
        $('#listProduct').html(data);
        location.hash = page;
    }).fail(function(jqXHR,ajaxOptions,thrownError){
        alert('No response from server');
    });
}

$('#exampleModal').on('show.bs.modal', event => {
    var button = $(event.relatedTarget);
    var modal = $(this);
    // Use above variables to manipulate the DOM
    
});