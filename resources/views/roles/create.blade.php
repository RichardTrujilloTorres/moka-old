@extends('layouts.master')

@section('title')
Roles
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="header">
                <h4 class="title">New Role</h4>
            </div>

            <div class="content">
                <div class="row">

                    <div class="col-md-6">

                        <!-- role creation form -->
                        <form method="POST" action="{{ route('admin.roles.store') }}">
                            {{ csrf_field() }}

                            <!-- name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <!-- permission -->
                            <div class="form-group{{ $errors->has('permission') ? ' has-error' : '' }}">

                                    // TODO
                                    {{--
                                    <label for="permission" class="control-label">Name</label>
                                    <input id="permission" type="text" class="form-control" 
                                        name="permission" 
                                        value="{{ old('permission') }}" 
                                        required>

                                    @if ($errors->has('permission'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('permission') }}</strong>
                                        </span>
                                    @endif
                                    --}}
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
