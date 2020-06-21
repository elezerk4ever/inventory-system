<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class SupplierControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',\App\User::class);
        return view('suppliers.index');
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
        $this->authorize('create',\App\User::class);
        $data = $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required'
        ]);
        $data['password'] = Hash::make($data['password']);
        \App\User::create($data);
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
        $this->authorize('view',\App\User::find($id));
        $user = \App\User::find($id);
        return view('suppliers.show',compact('user'));
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
        $this->authorize('update',\App\User::find($id));

        $data = $this->validate($request,[
            'name'=>'required',
            'password'=>'required',
            'email'=>'required'
        ]);
        $user = \App\User::find($id);
        $data['password']=Hash::make($data['password']);
        $user->update($data);
        return back()->withSuccess('Done!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',\App\User::find($id));

        $user = \App\User::find($id);
        foreach ($user->products as $product) {
            $product->delete();
        }
        $user->delete();
        return redirect(route('suppliers.index'))->withSuccess('Done!');
    }
}
