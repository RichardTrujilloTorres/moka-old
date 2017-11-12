@extends('layouts.master')

@section('title')
User Profile
@endsection

@section('content')
<div class="row">

    <div class="col-lg-4 col-md-5">


        <div class="card card-user">
            <div class="image">

                <a data-toggle="modal" data-target="#update-background-image-modal">
                    <img src="{{ $user->profile->backgroundImage() }}" alt="..."/>
                </a>




                {{-- Update background image --}}
                {{--
                <a href="{{ route('admin.users.setBackgroundImage', $user->id) }}"
                    onclick="event.preventDefault();
                    document.getElementById('update-background-image-form').submit();">
                        <img src="{{ $user->profile->backgroundImage() }}" alt="..."/>
                </a>
                <form id="update-background-image-form" action="{{ route('admin.users.setBackgroundImage', $user->id) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                </form>
                --}}

            </div>
            <div class="content">
                <div class="author">


                        <a data-toggle="modal" data-target="#update-profile-image-modal">
                            <img class="avatar border-white" src="{{ $user->profile->image() }}" alt="..."/>
                        </a>

                        {{-- Update profile image --}}
                        {{--
                        <a href="{{ route('admin.users.setProfileImage', $user->id) }}"
                            onclick="event.preventDefault();
                            document.getElementById('update-image-form').submit();">
                                <img class="avatar border-white" src="{{ $user->profile->avatar_url }}" alt="..."/>
                        </a>
                        <form id="update-image-form" action="{{ route('admin.users.setProfileImage', $user->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                        --}}


                  <h4 class="title"><br />
                     <small>{{ "@" }}{{ $user->profile->username }}</small>
                  </h4>
                </div>
                <p class="description text-center">
                    {{-- @todo add phrase formating in here --}}
                    {{ $user->profile->getPhrase() }}
                </p>
            </div>
            <hr>

            <div class="text-center">
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <h5>{{ $user->numberOfFiles() }}<br /><small>Files</small></h5>
                    </div>
                    <div class="col-md-4">
                        <h5>{{ $user->spaceUsed() }}GB<br /><small>Used</small></h5>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $user->lastLoggedIn() }}<br /><small>Last logged in</small></h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- @todo --}}
        {{-- 
        <div class="card">
            <div class="header">
                <h4 class="title">Team Members</h4>
            </div>
            <div class="content">
                <ul class="list-unstyled team-members">
                            <li>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="avatar">
                                            <img src="assets/img/faces/face-0.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        DJ Khaled
                                        <br />
                                        <span class="text-muted"><small>Offline</small></span>
                                    </div>

                                    <div class="col-xs-3 text-right">
                                        <btn class="btn btn-sm btn-success btn-icon"><i class="fa fa-envelope"></i></btn>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="avatar">
                                            <img src="assets/img/faces/face-1.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        Creative Tim
                                        <br />
                                        <span class="text-success"><small>Available</small></span>
                                    </div>

                                    <div class="col-xs-3 text-right">
                                        <btn class="btn btn-sm btn-success btn-icon"><i class="fa fa-envelope"></i></btn>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="avatar">
                                            <img src="assets/img/faces/face-3.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        Flume
                                        <br />
                                        <span class="text-danger"><small>Busy</small></span>
                                    </div>

                                    <div class="col-xs-3 text-right">
                                        <btn class="btn btn-sm btn-success btn-icon"><i class="fa fa-envelope"></i></btn>
                                    </div>
                                </div>
                            </li>
                        </ul>
            </div>
        </div>
        --}}



    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="header">
                <h4 class="title">Edit Profile</h4>
            </div>
            <div class="content">
                <form 
                    method="POST"
                    action="{{ route('admin.users.update', $user->id) }}"
                    >

                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control border-input" 
                                    disabled placeholder="Company" 
                                    name="company"
                                    id="company"
                                    value="{{ $user->profile->getCompany() }}">
                            </div>
                        </div>

                        <!-- username -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="Username" 
                                    name="username"
                                    id="username"
                                    value="{{ $user->profile->username }}">
                            </div>
                        </div>

                        <!-- email address -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control border-input" 
                                    placeholder="Email"
                                    name="email"
                                    id="email"
                                    value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- first name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="first_name"
                                    id="first_name"
                                    value="{{ $user->profile->first_name }}">
                            </div>
                        </div>

                        <!-- first name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="last_name"
                                    id="last_name"
                                    value="{{ $user->profile->last_name }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- address -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="address"
                                    id="address"
                                    value="{{ $user->profile->address }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <!-- city -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="city"
                                    id="city"
                                    value="{{ $user->profile->city }}">
                            </div>
                        </div>

                        <!-- country -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="country"
                                    id="country"
                                    value="{{ $user->profile->country }}">
                            </div>
                        </div>

                        <!-- zip code -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="number" class="form-control border-input" 
                                    placeholder="..." 
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ $user->profile->zip_code }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- about -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>About Me</label>
                                <textarea rows="5" class="form-control border-input" 
                                    placeholder="No description yet." 
                                    name="about"
                                    id="about"
                                    value="Mike">{{ $user->profile->about }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-info btn-fill btn-wd" value="Update Profile"/ >
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>



</div>


@endsection

@section('partials')
    @include('partials._update_background_image_modal')
    @include('partials._update_profile_image_modal')
@endsection
