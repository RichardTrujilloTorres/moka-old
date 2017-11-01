@extends('layouts.master')

@section('title')
Users
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

    
        <div class="card">
            <div class="header">
                <h4 class="title">User Listing</h4>
                <p class="category">Registered only</p>
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td>
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.users.edit', $user->id) }}"><i class="fa fa-edit"></i> Edit</a>
                                @else
                                    <a href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-edit"></i> View</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>


@endsection
