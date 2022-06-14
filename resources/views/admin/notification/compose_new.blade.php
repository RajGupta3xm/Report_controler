@extends('admin.layout.master3')

@section('content')
        <div class="content-wrapper">
            <div class="content-header sty-one">
                <h1>Notification Management</h1>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @if(session()->has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session()->get('success') }}
                                </div>
                                @else 
                                @if(session()->has('error'))  
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session()->get('error') }}
                                </div>
                                @endif 
                                @endif
                                <form method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <div class="search-select-btn">
                                                <select name="users[]" class="mdb-select md-form" multiple searchable="Search here..">
                                                    <option value="" disabled selected>Select User</option>
                                                    @if($users)
                                                    @foreach($users as $user)
                                                    <option value="{{$user['id']}}">{{$user['name']}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <p class="text-danger">{{ $errors->first('users') }}</p>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <p>Title</p>
                                            <input type="text" name="title" class="form-control" placeholder="" />
                                            <p class="text-danger">{{ $errors->first('title') }}</p>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <p>Write a message</p>
                                            <textarea cols="6" name="message" rows="6" class="form-control" placeholder=""></textarea>
                                            <p class="text-danger">{{ $errors->first('message') }}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12"> <button class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
