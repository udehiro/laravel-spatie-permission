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
                @csrf()   
                <div class="form-group">
                    <label for="name">Nama User</label>
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control" placeholder="Nama User" readonly>
                </div>
                <div class="form-group">
                    <label for="permission"> Pilih Role</label>
                    <select multiple class="form-control" id="role" name="role[]">
                        @foreach($roles as $role)
                            @if($user->hasRole($role)) 
                                {!! $selected = 'selected' !!}
                            @else
                                {!! $selected = '' !!}
                            @endif
                        <option value="{{ $role->id }}" {{ $selected }} >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
</div> 
@endsection