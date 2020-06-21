@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        {{$user->name}} - < {{$user->email}} >
                    </div>
                    <div>
                        <a href="#" class="btn btn-danger btn-sm" onclick="delete{{$user->id}}.submit()">
                            Delete this account
                        </a>
                        <form action="{{route('suppliers.destroy',$user->id)}}" method="POST" id="delete{{$user->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <h5>
                       List of Products
                    </h5>
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
                                
                            </th>
                        </tr>
                        @forelse ($user->products as $product)
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
                                    <a href="#" class="btn btn-sm btn-danger" onclick="delete{{$product->id}}.submit()">Delete</a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
