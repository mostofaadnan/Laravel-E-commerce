@extends('layouts.master')
@section('content')
<style>
    .table-wrap {
        height: 400px;
        overflow-y: auto;
    }
</style>
<div class="col-sm-6 form-single-input-section">
    <div class="card">
        <div class="card-header">Show Role</div>
        <div class="card-body">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $role->name }}
            </div>
            <hr>
            <strong>Permissions:</strong><br>
            <div class="table-wrap">
                <table class="data-table table table-bordered table-sm" width=100%>
                    <thead>
                        <tr>
                            <th>#Sl</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $key =>$v)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $v->name }}</td>

                        </tr>
                       
                        @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection