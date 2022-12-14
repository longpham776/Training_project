/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/customer.js":
/*!**********************************!*\
  !*** ./resources/js/customer.js ***!
  \**********************************/
/***/ (function() {

var _this = this;
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
  var searchData = $('.searchCustomer input').serializeArray();
  console.log(searchData);
  getData(1);
});
$(document).on('click', '.editBtn', function (e) {
  e.preventDefault();
  var customerId = $(this).data('id');

  // console.log( $(`.customer${customerId} .editSaveBtn`));

  // console.log($(`.customer${customerId} input`).serializeArray());

  $('.editBtn').hide();
  $(".customer".concat(customerId, " .editSaveBtn")).attr('class', 'editSaveBtn text-dark');
  $(".customer".concat(customerId, " h6")).hide();
  $(".customer".concat(customerId, " input")).attr('type', 'text');
});
$(document).on('click', '.editSaveBtn', function (e) {
  e.preventDefault();

  // console.log("close edit");

  var customerId = $(this).data('id');
  var customerData = $(".customer".concat(customerId, " input")).serializeArray();
  var url = $(this).data('url');
  console.log(url);
  console.log("New data!");
  $.each(customerData, function (index, value) {
    var newValue = value['value'];
    var oldValue = $(".customer".concat(customerId, " h6#").concat(value['name'])).text();
    if (!index) return;
    if (newValue != oldValue) {
      console.log("Value not equal! return Ajax", value['name']);
      $.ajax({
        url: url,
        method: "PUT",
        data: customerData,
        success: function success(_ref) {
          var status = _ref.status,
            customer = _ref.customer;
          console.log(status, customer);
          $.each(customer, function (index, value) {
            console.log(index, value);
            if (index == "_token") return;
            $(".customer".concat(customerId, " h6#").concat(index)).text(value);
          });
          $('.editBtn').show();
          $(".customer".concat(customerId, " .editSaveBtn")).attr('class', 'editSaveBtn text-dark d-none');
          $(".customer".concat(customerId, " td h6")).show();
          $(".customer".concat(customerId, " span")).text("");
          $(".customer".concat(customerId, " input")).attr('type', 'hidden');
        },
        error: function error(_ref2) {
          var responseJSON = _ref2.responseJSON;
          var errors = responseJSON.errors;
          $(".customer".concat(customerId, " input:not(:hidden)")).each(function (index, value) {
            var name = $(this).attr('name');
            if (name && errors[name]) {
              $(errors[name]).each(function (index, value) {
                $(".customer".concat(customerId, " .error_").concat(name)).text(value);
              });
            } else $(".customer".concat(customerId, " .error_").concat(name)).text("");
          });
        }
      });
      return false;
    }
    console.log("Value equal!", value['name']);
  });
  console.log("not return ajax!");
  $('.editBtn').show();
  $(".customer".concat(customerId, " .editSaveBtn")).attr('class', 'editSaveBtn text-dark d-none');
  $(".customer".concat(customerId, " td h6")).show();
  $(".customer".concat(customerId, " span")).text("");
  $(".customer".concat(customerId, " input")).attr('type', 'hidden');
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
  var formData = $('form.addCustomer').serializeArray();
  var url = "".concat(location.pathname);
  $.ajax({
    url: url,
    method: "POST",
    data: formData,
    success: function success(_ref3) {
      var status = _ref3.status,
        html = _ref3.html;
      console.log("success");
      if (status) {
        $('#listCustomer').html(html);
        $('#modelId').modal('hide');
        $('.addCustomer')[0].reset();
        alert("Th??m kh??ch h??ng th??nh c??ng!");
      }
    },
    error: function error(_ref4) {
      var responseJSON = _ref4.responseJSON;
      var errors = responseJSON.errors;
      if (Object.getOwnPropertyNames(errors).length) {
        $('form.addCustomer input').each(function (index, value) {
          // console.log(`name`, $(this).attr('name'));

          var name = $(this).attr('name');
          if (name && errors[name]) {
            // console.log(errors[name]);
            // console.log($(`#error_${name}`).text("test"));
            $(errors[name]).each(function (index, value) {
              $("form.addCustomer .error_".concat(name)).text(value);
            });
          } else $("form.addCustomer .error_".concat(name)).text("");
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
  var searchData = $('.searchCustomer input').serializeArray();
  $.ajax({
    url: '?page=' + page,
    type: 'get',
    data: searchData,
    datatype: 'html'
  }).done(function (data) {
    $('#listCustomer').html(data);
    location.hash = page;
  }).fail(function (jqXHR, ajaxOptions, thrownError) {
    alert('No response from server');
  });
}
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var modal = $(_this);
  // Use above variables to manipulate the DOM
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/customer.js"]();
/******/ 	
/******/ })()
;