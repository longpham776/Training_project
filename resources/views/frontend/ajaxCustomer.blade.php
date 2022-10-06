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