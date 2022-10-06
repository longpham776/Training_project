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
                <a class="nav-link" href="{{route('customers.index')}}">Khách hàng</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">Users</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{{route('home')}}" method="GET">
            <input class="form-control mr-sm-2" type="text" name="nameSearch" value="{{old('nameSearch')}}" placeholder="Tên">
            <input class="form-control mr-sm-2" type="text" name="emailSearch" value="{{old('emailSearch')}}" placeholder="Email">
            <select class="form-control" name="groupSearch" id="groupSearch">
                @if(old('groupSearch') == "Admin")
                <option value="Admin" selected>Admin</option>
                <option value="Editor">Editor</option>
                <option value="Reviewer">Reviewer</option>
                @elseif(old('groupSearch') == "Editor")
                <option value="Admin">Admin</option>
                <option value="Editor" selected>Editor</option>
                <option value="Reviewer">Reviewer</option>
                @elseif(old('groupSearch') == "Reviewer")
                <option value="Admin">Admin</option>
                <option value="Editor">Editor</option>
                <option value="Reviewer" selected>Reviewer</option>
                @else
                <option value="Admin">Admin</option>
                <option value="Editor">Editor</option>
                <option value="Reviewer">Reviewer</option>
                @endif
            </select>
            &ensp;
            <select class="form-control" name="activeSearch" id="activeSearch">
                @if(old('activeSearch') == 1)
                <option value="1" selected>Đang hoạt động</option>
                <option value="0">Tạm khóa</option>
                @elseif(old('activeSearch') == 0)
                <option value="1">Đang hoạt động</option>
                <option value="0" selected>Tạm khóa</option>
                @else
                <option value="1">Đang hoạt động</option>
                <option value="0">Tạm khóa</option>
                @endif
            </select>
            &ensp;
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button> &ensp;
            <button class="btn btn-outline-danger my-2 my-sm-0" id="btnClear" type="submit">Clear</button>
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
            <button type="button" id="btnAdd" class="btn btn-primary btn-xl" data-toggle="modal" data-target="#modelId">
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
                        <form class="editAddUser" action="#" method="post">
                            @csrf
                            <input type="hidden" name="userId" value="">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <label><strong>Tên</strong></label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Nhập họ tên">
                                        @error('name')
                                        <span style="color:red;">{{$message}}</span><br>
                                        @enderror
                                        <label><strong>Email</strong></label>
                                        <input type="text" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Nhập Email">
                                        @error('email')
                                        <span style="color:red;">{{$message}}</span><br>
                                        @enderror
                                        <label><strong>Mật khẩu</strong></label>
                                        <input type="text" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Nhập mật khẩu">
                                        @error('password')
                                        <span style="color:red;">{{$message}}</span><br>
                                        @enderror
                                        <label><strong>Xác nhận</strong></label>
                                        <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="helpId" placeholder="Nhập xác nhận">
                                        <label><strong>Nhóm</strong></label>
                                        <select class="form-control" name="group" id="group">
                                            <option value="Admin">Admin</option>
                                            <option value="Editor">Editor</option>
                                            <option value="Reviewer">Reviewer</option>
                                        </select>
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
                            <a name="edit" id="edit" class="btnEdit text-dark" href="#" data-toggle="modal" data-target="#modelId" 
                            data-id="{{$u->id}}" role="button"><i class="fas fa-pencil-alt"></i></a>
                            <a name="delete" id="delete" class="text-dark" href="{{route('delete',['id'=>$u->id])}}"
                            onclick="if (confirm('Are you sure to delete {{$u->name}}')) commentDelete(1); return false" role="button"><i class="fas fa-trash-alt"></i></a>
                            <a name="deactive" id="deactive" class="text-dark" href="{{route('deact',['id'=>$u->id])}}"
                            onclick="if (confirm('Are you sure to deactive {{$u->name}}')) commentDelete(1); return false" role="button"><i class="fas fa-user-minus"></i></a>
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

@stop

@section('js')

<script>
    $('#btnClear').on('click',function(){
        $.ajax({
            type:'GET',
            success: function(response){
                window.location = "{{url('/')}}";
            }
        });
    });
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
    $('#btnAdd').on('click',function(){
        $('.editAddUser').attr('action',"{{route('addUser')}}");
        $('input[name=userId]').val("");
        $('#name').val("");
        $('#email').val("");
        $('#group').val("Admin").change();
        $('#active').prop("checked",true);
    });
    $('.btnEdit').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{url('/getUser')}}",
            data:{'id':$(this).data('id')},
            type:'get',
            success:  function (response) {
                $('input[name=userId]').val(response.user.id);
                $('#name').val(response.user.name);
                $('#email').val(response.user.email);
                $('#group').val(response.user.group_role).change();
                if(response.user.is_active)    $('#active').prop("checked",true);
                else if(!response.user.is_active)   $('#active').prop("checked",false);
                $('.editAddUser').attr('action',"{{route('editUser')}}");
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                // window.open(JSON.stringify(x));
                console.log('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
            }
        });

        // return false;
    });
</script>
@stop