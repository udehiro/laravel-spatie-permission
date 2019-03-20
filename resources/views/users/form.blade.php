@extends('layouts.app')

@section('content')
<div class="col-md-9"> 
    <div class="card">
        <div class="card-header">{{ $title }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning" role="warning">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url($action) }}" method="post">
                @csrf
                @if(isset($method))
                    @method($method)
                @endif    
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" value="{{ isset($role->name) ? $role->name : '' }}" name="name" class="form-control" id="name" placeholder="Nama User" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="{{ isset($role->email) ? $role->email : '' }}" name="email" class="form-control" id="email" placeholder="Email User" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password-confirm">Password Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
</div> 
@endsection