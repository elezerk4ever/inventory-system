@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    List of Receipts
                </div>
                <div class="card-body">
                    <table class="w-100 table-bordered">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Customer_name
                            </th>
                            <th>
                                Total cost
                            </th>
                            <th>
                                Tender
                            </th>
                            <th>
                                Change
                            </th>
                            <th>
                                P_date
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                        @forelse ($receipts as $key=>$receipt)
                            <tr>
                                <td>
                                    {{$key+1}}
                                </td>
                                <td>
                                    {{$receipt->customer_name}}
                                </td>
                                <td>
                                    P {{number_format($receipt->total_cost,2)}}
                                </td>
                                <td>
                                    P {{number_format($receipt->tender,2)}}
                                </td>
                                <td>
                                    P {{number_format($receipt->change,2)}}
                                </td>
                                <td>
                                    {{$receipt->created_at->format('m/d/Y')}}
                                </td>
                                <td>
                                <a href="{{route('receipts.show',$receipt->id)}}" class="text-success">Print</a> |
                                <a href="#" class="text-primary" type="button" data-toggle="modal" data-target="#view{{$key}}" >View</a>
                                <div class="modal fade" id="view{{$key}}" tabindex="-1" role="dialog" aria-labelledby="view{{$key}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="view{{$key}}">Receipt details</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table-light">
                                                <tr>
                                                    <th>
                                                        Customer
                                                    </th>
                                                    <td>
                                                        {{$receipt->customer_name}}
                                                    </td>
                                                    <td>

                                                    </td>
                                                    <th>
                                                        Processed Date 
                                                    </th>
                                                    <td>
                                                        {{$receipt->created_at->format('m/d/Y')}}
                                                    </td>
                                                    
                                                </tr>
                                                @php
                                                    $products = explode('/',$receipt->details);
                                                    array_pop($products);
                                                @endphp
                                                <tr>
                                                    <th>
                                                       {{count($products)}} Item(s)
                                                    </th>
                                                    <td></td>
                                                    <td></td>
                                                    <th>Ordered Date</th>
                                                    <td>
                                                        {{$receipt->order_date}}
                                                    </td>
                                                </tr>
                                                
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>

                                                        </td>
                                                        <td>
                                                            {{$product}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr style="border-top:2px solid black" class="bg-light">
                                                    <th>
                                                        Total
                                                    </th>
                                                    <td>
                                                        P {{number_format($receipt->total_cost,2)}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Tender
                                                    </th>
                                                    <td>
                                                        P {{number_format($receipt->tender,2)}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Change
                                                    </th>
                                                    <td>
                                                        P{{number_format($receipt->change,2)}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
