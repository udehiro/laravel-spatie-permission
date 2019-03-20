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
                @if(isset($method))
                    @method($method)
                @endif    
                <div class="form-group">
                    <label for="name">Nama Permission</label>
                    <input type="text" value="{{ isset($permission->name) ? $permission->name : '' }}" name="name" class="form-control" id="name" placeholder="Nama Permission">
                </div>
                <div class="form-group">
                    <label for="permission"> Pilih Role</label>
                    <select multiple class="form-control" id="role" name="role[]">
                        @foreach($roles as $role)
                            @if(isset($permission->name))
                                @if($role->hasPermissionTo($permission)) 
                                    {!! $selected = 'selected' !!}
                                @else
                                    {!! $selected = '' !!}
                                @endif
                            @else
                                {!! $selected = '' !!}
                            @endif
                        <option value="{{ $role->id }}" {{ $selected }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
</div> 
@endsection