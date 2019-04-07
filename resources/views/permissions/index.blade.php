@extends('layouts.master')

@section('title')
Permissions
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    
        <div class="card">
            <a href="{{ route('admin.users.permissions.create') }}" class="btn btn-success">Add</a>
        </div>

        
        <div class="card">
            <div class="header">
                <h4 class="title">Permission Listing</h4>
                <p class="category">Users</p>
            </div>

            <div class="content table-responsive table-full-width">

                @if ($permissions->isEmpty())
                <div class="form-control">
                    No permissions yet
                </div>
                @endif
                            
                @if (! $permissions->isEmpty())
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('admin.users.permissions.edit', $permission->id) }}">
                                    <i class="fa fa-edit" title="edit"></i>
                                </a>

                                <a href="{{ route('admin.users.permissions.destroy', $permission->id) }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('delete-permission-form-{{ $permission->id }}').submit();">
                                    <i class="fa fa-trash" title="remove"></i>
                                </a>

                                <form id="delete-permission-form-{{ $permission->id }}"
                                    name="delete-permission-form-{{ $permission->id }}"
                                    action="{{ route('admin.users.permissions.destroy', $permission->id) }}"
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
