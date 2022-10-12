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
    let searchData = $('.searchProduct input').serializeArray();
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