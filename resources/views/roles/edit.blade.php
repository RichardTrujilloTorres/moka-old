@extends('layouts.master')

@section('title')
Roles
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="header">
                <h4 class="title">Edit Role</h4>
            </div>

            <div class="content">
                <div class="row">

                    <div class="col-md-6">

                        <!-- role creation form -->
                        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <!-- name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        placeholder="{{ $role->name }}"
                                        required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="text-center">
                                <input type="submit" class="btn btn-info btn-fill btn-wd" value="Save"/ >
                                <div class="clearfix"></div>
                            </div>


                        </form>
                    </div>
                </div>
        </div>

    </div>
</div>


@endsection
