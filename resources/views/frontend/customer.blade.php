@extends('frontend.masterview')
@section('content')
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="Javascript:void(0)"><i class="fas fa-user-circle"></i> Admin</a>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{route('products.index')}}">Sản phẩm </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{route('customers.index')}}">Khách hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Users</a>
            </li>
        </ul>
        <form class="searchCustomer form-inline my-2 my-lg-0" action="#" method="GET">
            @csrf
            <input class="form-control mr-sm-2" type="text" name="nameSearch" value="" placeholder="Họ và tên">
            <input class="form-control mr-sm-2" type="text" name="emailSearch" value="" placeholder="Email">
            <select class="form-control" name="groupSearch" id="groupSearch">
                <option value="">Tình trạng</option>
                <option value="1">Đang hoạt động</option>
                <option value="0">Tạm khóa</option>
            </select>
            &ensp;
            <input class="form-control mr-sm-2" type="text" name="addressSearch" value="" placeholder="Địa chỉ">
            &ensp;
            <button class="btn btn-outline-light my-2 my-sm-0" id="btnSearch" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button> &ensp;
            <button class="btn btn-outline-danger my-2 my-sm-0" id="btnClear" type="button">Clear</button>
        </form>
    </div>
</nav>
<div class="container">

    <div class="col justify-content-center">

        <div class="row-sm">
            <h1>Khách hàng |
                <a href="{{route('logout')}}">Logout</a>
            </h1>
        </div>

        <div class="row-sm">

            <!-- Button trigger modal -->
            <button type="button" id="btnAdd" class="btn btn-primary btn-xl" data-toggle="modal" data-target="#modelId">
                <i class="fas fa-user-plus"> Thêm mới</i>
            </button>

            <button type="button" class="btn btn-secondary btn-xl" data-toggle="modal" data-target="#modelImport">
                <i class="fa fa-download" aria-hidden="true"> Import CSV</i>
            </button>

            <button type="button" id="" class="btn btn-secondary btn-xl">
                <i class="fa fa-upload" aria-hidden="true"> <a class="text-decoration-none text-white" href="{{route('customers.export')}}">Export CSV</a></i>
            </button>


            <!-- Modal -->
            <div class="modal fade" id="modelImport" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import CSV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="importCsv" action="{{route('customers.import')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="custom-file">
                                    <input class="form-control" type="file" name="file">
                                    <!-- <label class="custom-file-label">File CSV</label> -->
                                </div>
                                <span style="color:red;" class="error_file"></span>
                                @error('file')
                                <span style="color:red;" class="error_file">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="close btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="btnImport" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm khách hàng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="addCustomer" action="#" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <label><strong>Tên</strong></label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Nhập họ tên">
                                        <span style="color:red;" class="error_name"></span><br>
                                        <label><strong>Email</strong></label>
                                        <input type="text" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Nhập Email">
                                        <span style="color:red;" class="error_email"></span><br>
                                        <label><strong>Điện thoại</strong></label>
                                        <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpId" placeholder="Nhập điện thoại">
                                        <span style="color:red;" class="error_phone"></span><br>
                                        <label><strong>Địa chỉ</strong></label>
                                        <input type="text" class="form-control" name="address" id="address" aria-describedby="helpId" placeholder="Nhập địa chỉ">
                                        <span style="color:red;" class="error_address"></span><br>
                                        <label><strong>Trạng thái</strong></label>
                                        <input class="form-control" type="checkbox" name="active" id="active" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btnCancelAddCustomer btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btnAddCustomer btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('frontend.ajaxCustomer')
    </div>
</div>
@stop

@section('js')

<script src="{{ asset('public/js/customer.js')}}"></script>

@stop