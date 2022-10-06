@extends('frontend.masterview')
@section('content')
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><i class="fas fa-user-circle"></i> Admin</a>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="#">Sản phẩm </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{route('customers.index')}}">Khách hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Users</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{{route('home')}}" method="GET">
            <input class="form-control mr-sm-2" type="text" name="" value="" placeholder="Họ và tên">
            <input class="form-control mr-sm-2" type="text" name="" value="" placeholder="Email">
            <select class="form-control" name="groupSearch" id="groupSearch">
                <option value="1">Đang hoạt động</option>
                <option value="0">Tạm khóa</option>
            </select>
            &ensp;
            <input class="form-control mr-sm-2" type="text" name="" value="" placeholder="Địa chỉ">
            &ensp;
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button> &ensp;
            <button class="btn btn-outline-danger my-2 my-sm-0" id="btnClear" type="submit">Clear</button>
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
            <button type="button" id="" class="btn btn-secondary btn-xl">
                <i class="fa fa-download" aria-hidden="true"> Import CSV</i>
            </button>
            <button type="button" id="" class="btn btn-secondary btn-xl">
                <i class="fa fa-upload" aria-hidden="true"> Export CSV</i>
            </button>
            
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
                        <form class="addUser" action="#" method="post">
                            @csrf
                            <input type="hidden" name="userId" value="">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <label><strong>Tên</strong></label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Nhập họ tên">
                                        <label><strong>Email</strong></label>
                                        <input type="text" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Nhập Email">
                                        <label><strong>Điện thoại</strong></label>
                                        <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpId" placeholder="Nhập điện thoại">
                                        <label><strong>Địa chỉ</strong></label>
                                        <input type="text" class="form-control" name="address" id="address" aria-describedby="helpId" placeholder="Nhập địa chỉ">
                                        <label><strong>Trạng thái</strong></label>
                                        <input class="form-control" type="checkbox" name="active" id="active">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="listCustomer">

            <div class="row-sm">
                <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{$customers->links()}}
                </ul>
                </nav>
            </div>

            <div class="text-right"><strong>Tổng số 0 users</strong></div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('fail'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Sorry!</strong> {{session('fail')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row-sm text-center">
                <table class="table table-striped">
                    <thead class="bg-danger">
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Điện thoại</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $cus)
                        <tr>
                            <td scope="row">{{$cus->customer_id}}</td>
                            <td>{{$cus->customer_name}}</td>
                            <td>{{$cus->email}}</td>
                            <td>{{$cus->address}}</td>
                            <td>{{$cus->tel_num}}</td>
                            <td>
                                <a name="edit" id="edit" class="btnEdit text-dark" href="#"
                                data-id="id" role="button"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row-sm">
                <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{$customers->links()}}
                </ul>
                </nav>
            </div>

        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function(){
        $(document).on('click','.pagination a',function(event){
            event.preventDefault();

            $('li').removeClass('active');
            $(this).parent('li').addClass('active');

            var page = $(this).attr('href').split('page=')[1];

            getData(page);
        });
    });

    function getData(page) {
        // body...
        $.ajax({
            url : '?page=' + page,
            type : 'get',
            datatype : 'html',
        }).done(function(data){
            $('#listCustomer').empty().html(data);
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

</script>
@stop