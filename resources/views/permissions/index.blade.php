@extends('layouts.app')

@section('content')
<div class="col-md-9"> 
    <div class="card">
        <div class="card-header">Permission <a href="{{ url('permissions/create') }}" type="button" class="btn btn-primary float-right">Tambah</a></div>

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
                    <th scope="col">Nama Permission</th>
                    <th scope="col" width="23%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <th scope="row">{{ $permission->id }}</th>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" type="button" class="btn btn-info">Edit</a>
                            <a type="button" class="btn btn-danger deleteBtn" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">Hapus</a>
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
                url: 'permissions/' + id,
                type : "POST",
                data: {'_method':'DELETE','_token': csrf_token},
                success: function (data) {
                    location.href = 'permissions'
                }

            });
        })
    })
</script>
@endpush

@endsection