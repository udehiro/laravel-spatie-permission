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
                    <input type="text" value="{{ isset($data->name) ? $data->name : '' }}" name="name" class="form-control" id="name" placeholder="Nama Data" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="text" value="{{ isset($data->price) ? $data->price : '' }}" name="price" class="form-control" id="price" placeholder="Harga" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>            
        </div>
    </div>
</div> 
@endsection