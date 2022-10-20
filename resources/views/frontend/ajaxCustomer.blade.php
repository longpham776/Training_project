<div id="listCustomer">
    <div class="row-sm">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{$customers->links()}}
            </ul>
        </nav>
    </div>

    <div class="text-right"><strong>Tổng số {{count($customers)}} khách hàng</strong></div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    
    @if( session('arr_messFail') )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry! Can't Import File</strong><br>
        @foreach( session('arr_messFail') as $row => $errors)
        <span class="text-danger">Dòng {{ $row }}: {{ $errors }} </span><br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if( session('fail') )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry!</strong>{{ session('fail') }}
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
                @forelse($customers as $cus)
                <form class="editCustomer" action="#" method="post">
                    <tr class="customer{{$cus->customer_id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }} " hidden />
                        <td scope="row">
                            <h6 id="customerId">{{$cus->customer_id}}</h6> <input class="form-control" type="hidden" readonly name="customerId" value="{{$cus->customer_id}}">
                        </td>
                        <td>
                            <h6 id="name">{{$cus->customer_name}}</h6> <input class="form-control" type="hidden" name="name" value="{{$cus->customer_name}}">
                            <span style="color:red;" class="error_name"></span><br>
                        </td>
                        <td>
                            <h6 id="email">{{$cus->email}}</h6> <input class="form-control" type="hidden" name="email" value="{{$cus->email}}">
                            <span style="color:red;" class="error_email"></span><br>
                        </td>
                        <td>
                            <h6 id="address">{{$cus->address}}</h6> <input class="form-control" type="hidden" name="address" value="{{$cus->address}}">
                            <span style="color:red;" class="error_address"></span><br>
                        </td>
                        <td>
                            <h6 id="phone">{{$cus->tel_num}}</h6> <input class="form-control" type="hidden" name="phone" value="{{$cus->tel_num}}">
                            <span style="color:red;" class="error_phone"></span><br>
                        </td>
                        <td>
                            <a name="editBtn" id="editBtn" class="editBtn text-dark" href="#" data-id="{{$cus->customer_id}}" role="button"><i class="fas fa-pencil-alt"></i></a>
                            <a name="editSaveBtn" id="editSaveBtn" class="editSaveBtn text-dark d-none" href="#" data-url="{{route('customers.update', ['customer' => $cus->customer_id])}}" data-id="{{$cus->customer_id}}" role="button"><i class="fas fa-save"></i></a>
                        </td>
                    </tr>
                </form>
                @empty
                <tr>
                    <td class="text-center" colspan="6">
                        Not Found!
                    </td>
                </tr>
                @endforelse
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