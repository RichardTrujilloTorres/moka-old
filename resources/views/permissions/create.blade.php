@extends('layouts.master')

@section('title')
Permissions
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="header">
                <h4 class="title">New Permission</h4>
            </div>

            <div class="content">
                <div class="row">

                    <div class="col-md-6">

                        <!-- permission creation form -->
                        <form method="POST" action="{{ route('admin.users.permissions.store') }}">
                            {{ csrf_field() }}

                            <!-- name -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        >

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="text-center">
                                <input type="submit" class="btn btn-info btn-fill btn-wd" value="Save" />
                                <div class="clearfix"></div>
                            </div>


                        </form>
                    </div>
                </div>
        </div>

    </div>
</div>


@endsection
