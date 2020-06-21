@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Available products</div>

                <div class="card-body">
                    <table class="table-bordered w-100">
                        <tr class="text-center">
                            <th>
                                Prod. Name
                            </th>
                            <th>
                                Orig. Price
                            </th>
                            <th>
                                Profit
                            </th>
                            <th>
                                Selling price
                            </th>
                            <th>
                                Qty
                            </th>
                            <th>
                                Supplier
                            </th>
                            <th>
                                actions
                            </th>
                        </tr>
                        @forelse ($products as $product)
                            <tr class="text-center">
                                <td>
                                    {{$product->name}}
                                </td>
                                <td>
                                    P{{number_format($product->orig_price,2)}}
                                </td>
                                <td>
                                    P{{number_format($product->profit,2)}}
                                </td>
                                <td>
                                    P{{number_format($product->profit+$product->orig_price,2)}}
                                </td>
                                <td>
                                    {{$product->actQty()}}
                                </td>
                                <td>
                                    {{$product->user->name}}
                                </td>
                                <td>
                                <a href="#" class="btn btn-sm btn-primary {{!$product->actQty() ? 'disabled':''}}" type="button" data-toggle="modal" data-target ="#cart{{$product->id}}">+ Cart</a>
                                <div class="modal fade" id="cart{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="cart{{$product->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="cart{{$product->id}}">More details</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <form method="POST" action="{{route('checkout.store')}}">
                                                @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="form-group">
                                                <label for="qty">Quantity</label>
                                            <input id="qty" class="form-control" type="number" name="qty" max="{{$product->actQty()}}" oninput="if(this.value > {{$product->actQty()}}) this.value = {{$product->actQty()}}" required>
                                            </div>
                                            <button class="btn btn-primary">Move to cart</button>
                                            </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center bg-warning">
                                    No products to show
                                </td>
                            </tr>
                         @endforelse
                    </table>
                    <div class="mt-1">
                        {{$products->links()}}
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Cart</div>

                <div class="card-body">
                    @php
                        $total = 0;
                    @endphp
                    <ul class="list-group">
                        @foreach ($carts as $cart)
                    <li class="list-group-item p-1 d-flex justify-content-between">
                        <div>
                            {{$cart->qty}} x {{$cart->product->name}}
                            @php
                                $total += ($cart->qty*($cart->product->sellPrice()))
                            @endphp
                        </div>
                        <div>
                        <form action="{{route('checkout.destroy',$cart->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-danger" type="button" onclick="this.parentElement.submit()">remove</a>
                        </form>
                        </div>
                    </li>
                        @endforeach
                    </ul>
                    
                    
                    @if (\App\Cart::where('order_id',null)->count())
                <form method="POST" action="{{route('carts.store')}}">
                    <br>
                    total 
                    <h5 clas="mt-2">
                        P{{number_format($total,2)}}
                    </h5>
                    @csrf
                            <hr>
                            <div class="form-group">
                                <label for="name">Customer Name</label>
                                <input id="name" class="form-control" type="text" name="customer_name" required>
                            </div>
                            <button class="btn btn-primary">Proccess</button>
                        </form>
                    @else 
                    <div class="card card-body bg-light">
                        The cart is Empty
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
