<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = \App\Receipt::latest()->get();
        return view('receipts.index',compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,
        [
            'order_id'=>'required',
            'tender'=>'required',
            'total'=>'required'
        ]);
        
        $order = \App\Order::find($data['order_id']);
        $details = "";
        foreach($order->carts as $cart){
            $details .= "".$cart->qty." x ".$cart->product->name." = ".number_format($cart->product->sellPrice() * $cart->qty )."/";
        }
        $change = $data['tender'] - $data['total'];
        $order_date = $order->created_at->format('m/d/Y');
        $customer_name = $order->customer_name;
        $newData = [
            'order_date' =>$order_date,
            'total_cost' =>$data['total'],
            'tender'=>$data['tender'],
            'change'=>$change,
            'customer_name'=>$customer_name,
            'details'=>$details
        ];
        
        //subrtact each product qty 
        foreach($order->carts as $cart){
            $cart->product()->update(['qty'=>$cart->product->qty - $cart->qty]);
            $product = $cart->product->id;
            $product = \App\Product::find($product);
            $product->incomes()->create(['amount'=>$product->sellPrice() * $cart->qty]);
            $cart->delete();
        }
        $order->delete();

        //saving receipts 
        \App\Receipt::create($newData);
        return back()->withSuccess('Done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = \App\Receipt::find($id);
        return view('receipts.show',compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
