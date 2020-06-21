@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (auth()->user()->id == 1)
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <div class="card card-body">
                                        NO. OF PRODUCTS
                                        <h2>
                                            {{\App\Product::count() ?? 0}}
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <div class="card card-body">
                                        NO. OF SUPPLIERS
                                        <h2>
                                            {{\App\User::count() - 1 ?? 0}}
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div class="card card-body">
                                        REMAINING ITEMS
                                        <h2>
                                            @if (\App\Product::count())
                                            {{number_format(\App\Product::sum('qty') ,0) }}
                                            @endif
                                            
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-1">
                            <div class="card card-body py-5">
                                
                                <h4>
                                   REVENUE
                                </h4>
                                <h2>
                                    @if (\App\Income::count())
                                    P {{number_format(\App\Income::where('is_save',false)->sum('amount'),2)}}
                                    @endif
                                    
                                </h2>
                            <form action="{{route('saves.update',1)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-block btn-primary mt-2">
                                        SAVE
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-header">
                    Out of Stock threshold
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @php
                            $threshold = \App\Product::where('qty','<=',100)->get();
                        @endphp
                        @forelse ($threshold as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                <a href="{{route('suppliers.show',$product->user->id)}}">{{$product->name}} - < {{$product->user->name}} ></a>
                                </div>
                                <div class="badge badge-danger">
                                    {{$product->qty ?? 0}}
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">
                                No product Available
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            @else
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="card card-body">
                                    PRODUCTS
                                    <h2 class="display-6">
                                        {{number_format(auth()->user()->products()->count(),0) ?? 0}}
                                    </h2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body">
                                    REVENUE
                                    <h2 class="display-5">
                                        @php
                                            $products = auth()->user()->products;

                                            $rev = 0;
                                            foreach($products as $product){
                                                foreach($product->incomes as $income){
                                                    $rev += $income->amount;
                                                }
                                            }
                                        @endphp
                                        P {{number_format($rev,2)}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
