@extends('frontend.masterview')
@section('content')
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><i class="fas fa-user-circle"></i> Admin</a>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="#">Sản phẩm </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Khách hàng</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Users</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button> &ensp;
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Clear</button>
        </form>
    </div>
</nav>
<div class="container">

    <div class="col justify-content-center">

        <div class="row-sm">
            <h1>Users |
                <a href="{{route('logout')}}">Logout</a>
            </h1>
        </div>

        <div class="row-sm">

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-xl" data-toggle="modal" data-target="#modelId">
                <i class="fas fa-user-plus"> Thêm user</i>
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                            <div class="modal-header">
                                    <h5 class="modal-title">Thêm User / Chỉnh sửa User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <form action="#" method="post">
                                        <label><strong>Tên</strong></label>
                                        <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="Nhập họ tên">
                                        <label><strong>Email</strong></label>
                                        <input type="text" class="form-control" name="email" id="" aria-describedby="helpId" placeholder="Nhập Email">
                                        <label><strong>Mật khẩu</strong></label>
                                        <input type="text" class="form-control" name="password" id="" aria-describedby="helpId" placeholder="Nhập mật khẩu">
                                        <label><strong>Xác nhận</strong></label>
                                        <input type="text" class="form-control" name="confirm" id="" aria-describedby="helpId" placeholder="Nhập xác nhận">
                                        <label><strong>Nhóm</strong></label>
                                        <select class="form-control" name="group" id="">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                          </select>
                                        <label><strong>Trạng thái</strong></label>
                                        <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                $('#exampleModal').on('show.bs.modal', event => {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                    // Use above variables to manipulate the DOM
                    
                });
            </script>
            
        </div>

        <div class="row-sm">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                {{$users->links()}}
              </ul>
            </nav>
        </div>

        <div class="text-right"><strong>Tổng số {{count($users)}} users</strong></div>

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
                        <th>Nhóm</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td scope="row">{{$u->id}}</td>
                        <td>{{$u->name}}</td>
                        <td>{{$u->email}}</td>
                        <td>{{$u->group_role}}</td>
                        @if($u->is_active == 1)
                        <td class="text-success">Đang hoạt động</td>
                        @elseif($u->is_active == 0)
                        <td class="text-danger">Tạm khóa</td>
                        @endif
                        <td>
                            <a name="edit" id="edit" class="text-dark" href="#" role="button"><i class="fas fa-pencil-alt"></i></a>
                            <a name="delete" id="delete" class="text-dark" href="{{route('delete',['id'=>$u->id])}}"
                            onclick="alertFunction('delete')" role="button"><i class="fas fa-trash-alt"></i></a>
                            <a name="deactive" id="deactive" class="text-dark" href="{{route('deact',['id'=>$u->id])}}"
                            onclick="alertFunction('deactive')" role="button"><i class="fas fa-user-minus"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row-sm">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                {{$users->links()}}
              </ul>
            </nav>
        </div>
    </div>
</div>
<script>
    function alertFunction($string){
        alert("Are you sure to "+$string+" it!");
    }
</script>
@stop