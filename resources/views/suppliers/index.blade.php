@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        Suppliers Record
                    </div>
                    <div>
                        <a href="#" type="button" data-toggle="modal" data-target="#add-form">Add new Supplier</a>
                        <div class="modal fade" id="add-form" tabindex="-1" role="dialog" aria-labelledby="add-form" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="add-form">New Supplier</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" action="{{route('suppliers.store')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input id="name" class="form-control" type="text" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input id="email" class="form-control" type="email" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input id="password" class="form-control" type="password" name="password">
                                        </div>
                                        <button class="btn btn-primary">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table-bordered w-100">
                        <tr>
                            <th class="text-center">
                                Created At
                            </th>
                            <th class="text-center">
                                Name
                            </th>
                            <th class="text-center">
                                Email
                            </th>
                            <th class="text-center">
                                Actions
                            </th>
                        </tr>
                        @foreach (\App\User::where('id','!=',1)->get() as $user)
                            <tr>
                                <td class="text-center">
                                    {{$user->created_at->diffForHumans()}}
                                </td>
                                <td class="text-center">
                                <a href="{{route('suppliers.show',$user->id)}}" title="view details about {{$user->name}}">
                                    {{$user->name}}
                                </a>
                                </td>
                                <td class="text-center">
                                    {{$user->email}}
                                </td>
                                <td class="text-center">
                                <a href="#edit" class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#edit-{{$user->id}}">edit</a>
                                <div class="modal fade" id="edit-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="edit-{{$user->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="edit-{{$user->id}}">Edit user</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <form method="POST" action="{{route('suppliers.update',$user->id)}}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                    <input id="name" class="form-control" type="text" name="name" value="{{$user->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                    <input id="email" class="form-control" type="email" name="email" required value="{{$user->email}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input id="password" class="form-control" type="password" name="password" required placeholder="**************">
                                                    </div>
                                                    <button class="btn btn-primary">Save changes</button>
                                            </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                
                                    <a href="#delete" class="btn btn-sm btn-danger" onclick="delete{{$user->id}}.submit()">delete</a>
                                <form action="{{route('suppliers.destroy',$user->id)}}" method="POST" id="delete{{$user->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
