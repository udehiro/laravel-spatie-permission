@extends('layouts.app')

@section('content')
<div class="col-md-9"> 
    <div class="card">
        @can('data.create')
        <div class="card-header">Data <a href="{{ url('data/create') }}" type="button" class="btn btn-primary float-right">Tambah</a></div>
        @endcan

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col" width="23%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $data)
                    <tr>
                        <th scope="row">{{ $data->id }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->price }}</td>
                        <td>
                            @can('data.update')
                            <a href="{{ route('data.edit', $data->id) }}" type="button" class="btn btn-info">Ubah</a>
                            @endcan
                            @can('data.delete')
                            <a type="button" class="btn btn-danger deleteBtn" data-id="{{ $data->id }}" data-name="{{ $data->name }}">Hapus</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  

@push('scripts')
<script>
    $(function(){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $(".deleteBtn").click(function(){
            var id = $(this).data('id')
            var name = $(this).data('name')
            $("#rowName").html(name)
            $("#deleteModalId").val(id)
            $('#deleteModal').modal()
        })
        $("#deleteModalBtn").click(function() {
            var id = $("#deleteModalId").val()
            $.ajax({
                url: 'data/' + id,
                type : "POST",
                data: {'_method':'DELETE','_token': csrf_token},
                success: function (data) {
                    location.href = 'data'
                }

            });
        })
    })
</script>
@endpush

@endsection
