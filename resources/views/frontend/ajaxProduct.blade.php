<div id="listProduct">
    <div class="row-sm">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
            {{ $products->links() }}
            </ul>
        </nav>
    </div>

    <div class="text-right"><strong>Tổng số {{ count($products) }} khách hàng</strong></div>

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
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Tình trạng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                <tr>
                    <td scope="row">
                        <h6>{{$prod->product_id}}</h6> <input class="form-control" type="hidden" readonly name="productId" value="{{$prod->product_id}}"></td>
                    <td>
                        <h6>{{$prod->product_name}}</h6> <input class="form-control" type="hidden" name="name" value="{{$prod->product_name}}">
                    </td>
                    <td>
                        <h6>{{$prod->email}}</h6> <input class="form-control" type="hidden" name="email" value="{{$prod->email}}">
                    </td>
                    <td>
                        <h6>{{$prod->address}}</h6> <input class="form-control" type="hidden" name="address" value="{{$prod->address}}">
                    </td>
                    <td>
                        <h6>{{$prod->tel_num}}</h6> <input class="form-control" type="hidden" name="phone" value="{{$prod->tel_num}}">
                    </td>
                    <td>
                        <a name="editBtn" id="editBtn" class="editBtn text-dark" href="#"
                        data-id="" role="button"><i class="fas fa-pencil-alt"></i></a>
                        <a name="delete" id="delete" class="text-dark" href="{{route('products.destroy',['product'=>$prod->product_id])}}"
                            onclick="if (confirm('Are you sure to delete {{$prod->product_name}}')) commentDelete(1); return false" role="button"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
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
            {{ $products->links() }}
            </ul>
        </nav>
    </div>
</div>