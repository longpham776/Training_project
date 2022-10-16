<div id="listProduct">
    <div class="row-sm">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
            {{ $products->links() }}
            </ul>
        </nav>
    </div>

    <div class="text-right"><strong>Tổng số {{ count($products) }} khách hàng</strong></div>

    <div class="noticeSuccess alert alert-success alert-dismissible fade show" hidden role="alert">
        <strong>Success!</strong> <span id="text" aria-hidden="true">text</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="noticeFail alert alert-danger alert-dismissible fade show" hidden role="alert">
        <strong>Sorry!</strong> <span id="text" aria-hidden="true">text</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

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
                <tr id="product{{$prod->product_id}}">
                    <td scope="row">
                        <h6 id="productId">{{ $prod->product_id }}</h6> <input class="form-control" type="hidden" readonly name="productId" value="{{$prod->product_id}}"></td>
                    <td>
                        <h6 id="name">{{ $prod->product_name }}</h6> <input class="form-control" type="hidden" name="name" value="{{$prod->product_name}}">
                    </td>
                    <td>
                        <h6 id="description" class="text-truncate" style="max-width: 100px;">{{ strip_tags($prod->description) }}</h6> <input class="form-control" type="hidden" name="description" value="{{$prod->description}}">
                    </td>
                    <td>
                        <h6 id="price" class="text-success">${{ $prod->product_price }}</h6> <input class="form-control" type="hidden" name="price" value="{{$prod->product_price}}">
                    </td>
                    <td>
                        @if($prod->is_sales == 1)
                        <h6 id="sale" class="text-success">Có hàng bán</h6>
                        @else
                        <h6 id="sale" class="text-danger">Dừng bán</h6>
                        @endif
                        <input class="form-control" type="hidden" name="sale" value="{{$prod->id_sales}}">
                    </td>
                    <td>
                        <a name="editBtn" id="editBtn" class="editBtn text-dark" href="#"
                        data-toggle="modal" data-target="#modelId" data-url="{{route('products.show',['product'=>$prod->product_id])}}"
                        data-id="{{$prod->product_id}}" role="button"><i class="fas fa-pencil-alt"></i></a>
                        <a name="btnDelete" id="btnDelete" class="btnDelete text-dark" href="#" 
                        data-url="{{route('products.destroy',['product'=>$prod->product_id])}}"
                        data-id="{{$prod->product_id}}" data-name="{{$prod->product_name}}" role="button"><i class="fas fa-trash-alt"></i></a>
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