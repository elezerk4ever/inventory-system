@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        Your products
                    </div>
                    <div>
                        <a href="#" type="button" data-toggle="modal" data-target="#add-form">Supply New product</a>
                        <div class="modal fade" id="add-form" tabindex="-1" role="dialog" aria-labelledby="add-form" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="add-form">new Product</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" action="{{route('products.store')}}">
                                      @csrf
                                      <div class="form-group">
                                          <label for="name">Name *</label>
                                          <input id="name" class="form-control" type="text" name="name" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="Quantity">Quantity *</label>
                                          <input id="Quantity" class="form-control" type="text" name="qty" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="orig_prince">Original Price *</label>
                                          <input id="orig_prince" class="form-control" type="number"  name="orig_price" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="profit">Profit *</label>
                                          <input id="profit" class="form-control" type="number" name="profit" required>
                                      </div>
                                      <button class="btn btn-primary">Submit</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>

                <div class="card-body">
                    
                  <table class="table-bordered w-100">
                      <tr class="text-center">
                          <th>
                              Name
                          </th>
                          <th>
                              Original Price
                          </th>
                          <th>
                              Profit
                          </th>
                          <th>
                              Quantity
                          </th>
                          <th>
                              Actions
                          </th>
                      </tr>
                      @forelse (auth()->user()->products as $product)
                    <tr class="{{$product->actQty() <= 100  ? 'bg-warning':''}}">
                            <td class="text-center">
                                {{$product->name}}
                            </td>
                            <td class="text-center">
                                P{{number_format($product->orig_price,2)}}
                            </td>
                            <td class="text-center">
                                P{{number_format($product->profit,2)}}
                            </td>
                            <td class="text-center">
                                {{$product->actQty()}}
                            </td>
                            <td class="text-center">
                            <a href="#" class="btn btn-sm btn-danger {{$product->carts()->count() ? 'disabled':''}}" onclick="delete{{$product->id}}.submit()">Delete</a>
                            <form action="{{route('products.destroy',$product->id)}}" id="delete{{$product->id}}" method="POST">@csrf @method("DELETE")</form>
                            </td>
                        </tr>

                      @empty
                          <tr>
                              <td class="text-center bg-warning" colspan="5" >
                                  No products available
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
