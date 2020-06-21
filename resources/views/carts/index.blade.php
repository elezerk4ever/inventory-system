@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">pending carts</div>
                <div class="card-body">
                    @php
                        $total = 0;
                    @endphp
                    <ul class="">
                        @foreach (\App\Cart::where('order_id',null)->get() as $cart)
                    <li class="d-flex justify-content-between">
                        <div>
                            {{$cart->qty}} x {{$cart->product->name}} = P {{number_format($cart->qty*($cart->product->sellPrice()),2)}}
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
                    <h5 clas="mt-2 text-primary">
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
            <hr>
            <h4 class="text-center">Orders</h4>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-md-6">
                        <div class="card card-body mt-2 ">
                            <div>
                                    <strong>Customer Name :</strong> {{$order->customer_name}}
                            </div>
                            <div>
                                    <strong>Products and computations:</strong>
                                    <table class="w-100">
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($order->carts as $cart)
                                            <tr>
                                                <td>
                                                    {{$cart->qty}} x {{$cart->product->name}}    
                                                </td> 
                                                <td>
                                                    @php
                                                        $total +=$cart->qty * $cart->product->sellPrice();
                                                    @endphp

                                                    P {{number_format($cart->qty * $cart->product->sellPrice(),2)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="border-top:1px solid black">
                                            <td>
                                                <strong>Total</strong>
                                            </td>
                                            <td>
                                                <strong>P {{number_format($total,2)}}</strong>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="mt-2 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-sm " type="button"  data-toggle="modal" data-target="#process{{$order->id}}">
                                            Process
                                        </button>
                                        <div class="modal fade" id="process{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="process{{$order->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="process{{$order->id}}">Process {{explode(' ',$order->customer_name)[0]}}'s Order</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                <form method="POST" action="{{route('receipts.store')}}">
                                                      @csrf
                                                      <span class="h4">
                                                         Total : P {{number_format($total,2)}} 
                                                      </span>
                                                      <hr>
                                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                                      <div class="form-group">
                                                          <label for="tender">Tender</label>
                                                      <input id="tender" class="form-control" oninput="this.value < {{$total}} ? processbtn{{$order->id}}.disabled=true:processbtn{{$order->id}}.disabled=false" type="number" name="tender" required>
                                                      </div>
                                                    <input type="hidden" name="total" value="{{$total}}">
                                                    <button class="btn btn-primary" id="processbtn{{$order->id}}" disabled>
                                                          Process Now ! 
                                                      </button>
                                                    &nbsp;<small class="text-primary">Once the order is process no turning back</small>
                                                    </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    <form action="{{route('carts.destroy',$order->id)}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger btn-sm">
                                        Cancel
                                    </button>
                                    </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card card-body bg-light col-12">
                        No Orders
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
