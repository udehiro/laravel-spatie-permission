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
                    <label for="name">Nama Role</label>
                    <input type="text" value="{{ isset($role->name) ? $role->name : '' }}" name="name" class="form-control" id="name" placeholder="Nama Role">
                </div>
                <div class="form-group">
                    <label for="permission"> Pilih Permission</label>
                    <select multiple class="form-control" id="permission" name="permission[]">
                        @foreach($permissions as $permission)
                            @if(isset($role->name))
                                @if($role->hasPermissionTo($permission)) 
                                    {!! $selected = 'selected' !!}
                                @else
                                    {!! $selected = '' !!}
                                @endif
                            @else
                                {!! $selected = '' !!}
                            @endif
                        <option value="{{ $permission->id }}" {{ $selected }}>{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
</div> 
@endsection