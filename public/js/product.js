/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/product.js":
/*!*********************************!*\
  !*** ./resources/js/product.js ***!
  \*********************************/
/***/ (function() {

var _this = this;
$(document).ready(function () {
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
  var searchData = $('.searchProduct input').serializeArray();
  $.ajax({
    url: '?page=' + page,
    type: 'get',
    data: searchData,
    datatype: 'html'
  }).done(function (data) {
    $('#listProduct').html(data);
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
/******/ 	__webpack_modules__["./resources/js/product.js"]();
/******/ 	
/******/ })()
;