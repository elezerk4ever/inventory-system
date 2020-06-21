@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-4 mb-1">
                    <div class="card card-body text-center">
                        TOTAL AMOUT INVENTORY
                        <h3> 
                            P{{number_format($totAmount,2)}}
                        </h3>
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="card card-body text-center">
                        TOTAL PRODUCT INVENTORY
                        <h3>
                            {{\App\Product::sum('qty')}}
                        </h3>
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="card card-body text-center">
                        TOTAL SUPPLIER
                        <h3>
                            {{\App\User::count()-1}}
                        </h3>
                    </div>
                </div>
                
            </div>
            <div class="card mt-1">
                <div class="card-header">Record of products </div>

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
                                <a href="#" class="btn btn-sm btn-danger {{$product->carts()->count() ? "disabled":""}}" {{$product->carts()->count() ? "title='Unable action due to it`s orders'":""}} {{$product->carts()->count() ? "":'onclick="delete'.$product->id.'.submit()"'}} >Delete</a>
                            <form action="{{route('products.destroy',$product->id)}}" id="delete{{$product->id}}" method="POST">@csrf @method("DELETE")</form>
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
    </div>
</div>
@endsection
