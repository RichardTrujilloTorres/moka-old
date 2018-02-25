@extends('layouts.master')

@section('title')
Roles
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    
        <div class="card">
            <a href="{{ url('users.roles.create') }}" class="btn btn-success">Add</a>
            <button class="btn btn-danger">Eliminate</button>
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
                        <th>Slug</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->slug }}</td>
                            <td>// @todo</td>

                            {{--
                            <td>
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.users.edit', $user->id) }}">
                                        <i class="fa fa-edit" title="edit"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.users.show', $user->id) }}">
                                        <i class="fa fa-eye" title="view"></i>
                                    </a>
                                @endif

                                    @if (! $user->isLocked())
                                        <a href="{{ route('admin.users.lock', $user->id) }}" id="lock-user" 
                                            name="lock-user">
                                            <i class="fa fa-lock" title="lock"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.users.unlock', $user->id) }}" id="unlock-user" 
                                            name="unlock-user">
                                            <i class="fa fa-unlock" title="unlock"></i>
                                        </a>
                                    @endif

                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('admin.users.delete', $user->id) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('delete-user-form').submit();">
                                            <i class="fa fa-trash" title="remove"></i>
                                        </a>

                                        <form id="delete-user-form" 
                                            name="delete-user-form"
                                            action="{{ route('admin.users.delete', $user->id) }}" 
                                            method="POST" style="display:none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    @endif
                                    

                            </td>
                            --}}

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
