$(document).ready(function () {
    $('form.editCustomer span').hide();
});


$('button[name="btnImport"]').on('click', function (e) {

    if (!$('.importCsv input[name="file"]').val()) {
        $('.error_file').text("This field must be required!");

        return;
    }

    $('.importCsv').trigger('submit');
});

$('#btnClear').on('click', function () {
    $('.searchCustomer')[0].reset();
    getData(1);
});

$('#btnSearch').on('click', function (e) {

    e.preventDefault();

    let searchData = $('.searchCustomer input').serializeArray();

    console.log(searchData);

    getData(1);
});

$(document).on('click', '.editBtn', function (e) {

    e.preventDefault();

    let customerId = $(this).data('id');

    // console.log( $(`.customer${customerId} .editSaveBtn`));

    // console.log($(`.customer${customerId} input`).serializeArray());

    $('.editBtn').hide();

    $(`.customer${customerId} .editSaveBtn`).attr('class', 'editSaveBtn text-dark');

    $(`.customer${customerId} h6`).hide();

    $(`.customer${customerId} input`).attr('type', 'text');

});

$(document).on('click', '.editSaveBtn', function (e) {

    e.preventDefault();

    // console.log("close edit");

    let customerId = $(this).data('id');

    let customerData = $(`.customer${customerId} input`).serializeArray();

    let url = $(this).data('url');

    console.log(url);

    console.log("New data!");

    $.each(customerData, function (index, value) {

        let newValue = value['value'];

        let oldValue = $(`.customer${customerId} h6#${value['name']}`).text();

        if (!index) return;

        if (newValue != oldValue) {
            console.log("Value not equal! return Ajax", value['name']);

            $.ajax({

                url: url,
                method: "PUT",
                data: customerData,

                success: function ({ status, customer }) {

                    console.log(status, customer);

                    $.each(customer, function (index, value) {
                        console.log(index, value);

                        if (index == "_token") return;

                        $(`.customer${customerId} h6#${index}`).text(value);
                    });

                    $('.editBtn').show();

                    $(`.customer${customerId} .editSaveBtn`).attr('class', 'editSaveBtn text-dark d-none');

                    $(`.customer${customerId} td h6`).show();

                    $(`.customer${customerId} span`).text("");

                    $(`.customer${customerId} input`).attr('type', 'hidden');

                },

                error: function ({ responseJSON }) {

                    let errors = responseJSON.errors;

                    $(`.customer${customerId} input:not(:hidden)`).each(function (index, value) {

                        var name = $(this).attr('name');

                        if (name && errors[name]) {

                            $(errors[name]).each(function (index, value) {
                                $(`.customer${customerId} .error_${name}`).text(value);
                            });

                        } else $(`.customer${customerId} .error_${name}`).text("");
                    });

                }
            });

            return false;
        }

        console.log("Value equal!", value['name']);
    });

    console.log("not return ajax!");

    $('.editBtn').show();

    $(`.customer${customerId} .editSaveBtn`).attr('class', 'editSaveBtn text-dark d-none');

    $(`.customer${customerId} td h6`).show();

    $(`.customer${customerId} span`).text("");

    $(`.customer${customerId} input`).attr('type', 'hidden');

});

$('.btnCancelAddCustomer').on('click', function () {
    $('.addCustomer')[0].reset();
    $('form.addCustomer span').text("");
});

$('.close').on('click', function () {
    $('.addCustomer')[0].reset();
    $('.importCsv')[0].reset();
    $('.error_file').text('');
    $('form.addCustomer span').text("");
});

$('.btnAddCustomer').on('click', function (e) {

    e.preventDefault();

    $('form.addCustomer span').text("");

    let formData = $('form.addCustomer').serializeArray();

    let url = `${location.pathname}`;

    $.ajax({

        url: url,
        method: "POST",
        data: formData,

        success: function ({ status, html }) {
            console.log("success");
            if (status) {

                $('#listCustomer').html(html);

                $('#modelId').modal('hide');

                $('.addCustomer')[0].reset();

                alert("Thêm khách hàng thành công!");
            }
        },

        error: function ({ responseJSON }) {

            let errors = responseJSON.errors;

            if (Object.getOwnPropertyNames(errors).length) {

                $('form.addCustomer input').each(function (index, value) {

                    // console.log(`name`, $(this).attr('name'));

                    var name = $(this).attr('name');

                    if (name && errors[name]) {
                        // console.log(errors[name]);
                        // console.log($(`#error_${name}`).text("test"));
                        $(errors[name]).each(function (index, value) {
                            $(`form.addCustomer .error_${name}`).text(value);
                        });
                    } else $(`form.addCustomer .error_${name}`).text("");
                });
            }


        }
    });
});

$(document).ready(function () {
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var page = $(this).attr('href').split('page=')[1];

        getData(page);
    });
});

function getData(page) {
    // body...
    let searchData = $('.searchCustomer input').serializeArray();
    $.ajax({
        url: '?page=' + page,
        type: 'get',
        data: searchData,
        datatype: 'html',
    }).done(function (data) {
        $('#listCustomer').html(data);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('No response from server');
    });
}

$('#exampleModal').on('show.bs.modal', event => {
    var button = $(event.relatedTarget);
    var modal = $(this);
    // Use above variables to manipulate the DOM

});