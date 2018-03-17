@extends('layouts.master')

@section('title')
Roles
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    
        <div class="card">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-success">Add</a>
        </div>

        
        <div class="card">
            <div class="header">
                <h4 class="title">Role Listing</h4>
                <p class="category">Users</p>
            </div>

            <div class="content table-responsive table-full-width">

                @if ($roles->isEmpty())
                <div class="form-control">
                    No roles yet
                </div>
                @endif
                            
                @if (! $roles->isEmpty())
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role->id) }}">
                                    <i class="fa fa-edit" title="edit"></i>
                                </a>

                                <a href="{{ route('admin.roles.delete', $role->id) }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('delete-role-form-{{ $role->id }}').submit();">
                                    <i class="fa fa-trash" title="remove"></i>
                                </a>

                                <form id="delete-role-form-{{ $role->id }}" 
                                    name="delete-role-form-{{ $role->id }}"
                                    action="{{ route('admin.roles.delete', $role->id) }}" 
                                    method="POST" style="display:none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>

        </div>

    </div>
</div>

@endsection
