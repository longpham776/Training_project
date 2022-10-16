@extends('frontend.masterview')
@section('content')
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><i class="fas fa-user-circle"></i> Admin</a>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('products.index')}}">Sản phẩm </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('customers.index')}}">Khách hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Users</a>
            </li>
        </ul>
        <form class="searchProduct form-inline my-2 my-lg-0" action="#" method="GET">
            @csrf
            <input class="form-control mr-sm-2" type="text" name="nameSearch" value="" placeholder="Tên sản phẩm">
            <select class="form-control" name="saleSearch" id="saleSearch">
                <option value="" selected>Tình trạng</option>
                <option value="1">Có hàng bán</option>
                <option value="0">Dừng bán</option>
            </select>
            &ensp;
            <input class="form-control mr-sm-2" type="text" name="priceFromSearch" value="" placeholder="Giá bán từ">
            <h4 class="text-white">~</h4>
            &ensp;
            <input class="form-control mr-sm-2" type="text" name="priceToSearch" value="" placeholder="Giá bán đến">
            &ensp;
            <button class="btn btn-outline-light my-2 my-sm-0" id="btnSearch" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button> &ensp;
            <button class="btn btn-outline-danger my-2 my-sm-0" id="btnClear" type="submit">Clear</button>
        </form>
    </div>
</nav>
<div class="container">

    <div class="col justify-content-center">

        <div class="row-sm">
            <h1>Danh sách sản phẩm |
                <a href="{{route('logout')}}">Logout</a>
            </h1>
        </div>

        <div class="row-sm">

            <!-- Button trigger modal -->
            <button type="button" id="btnAdd" class="btn btn-primary btn-xl" data-toggle="modal" data-target="#modelId">
                <i class="fas fa-user-plus"> Thêm mới</i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chi tiết sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addProduct" action="#" method="">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <div class="row row-cols-2">
                                            <div class="col">
                                                <input type="hidden" name="productId" id="productId">
                                                <label><strong>Tên sản phẩm</strong></label>
                                                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Nhập tên sản phẩm">
                                                <span style="color:red;" class="error_name"></span><br>
                                                <label><strong>Giá bán</strong></label>
                                                <input type="number" class="form-control" name="price" id="price" aria-describedby="helpId" placeholder="Nhập giá bán">
                                                <span style="color:red;" class="error_price"></span><br>
                                                <label><strong>Mô tả</strong></label>
                                                <textarea class="ckeditor form-control" name="description" id="description" rows="5" placeholder="Mô tả sản phẩm"></textarea>
                                                <label><strong>Trạng thái</strong></label>
                                                <select name="sale" id="sale">
                                                    <option value="1">Có hàng bán</option>
                                                    <option value="0">Dừng bán</option>
                                                </select>
                                            </div>
                                            <label><strong>Hình ảnh</strong></label>
                                            <div class="col">
                                                <img class="form-control h-75" name="image" id="image" alt="Image Product" src="https://www.lg.com/lg5-common-gp/images/common/product-default-list-350.jpg" disabled>
                                                <input class="form-control" type="file" name="fileImage" id="fileImage"><br>
                                                <span style="color:red;" class="error_fileImage"></span><br>
                                                <button class="form-control" id="btnClearImage" type="button">Xóa file</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btnCancel btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btnStore btn btn-primary" 
                                data-url="{{route('products.store')}}">Save</button>
                                <button type="submit" class="btnUpdate btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.ajaxProduct')
    </div>
</div>
@stop

@section('js')

<script src="{{ asset('public/js/product.js')}}"></script>

@stop