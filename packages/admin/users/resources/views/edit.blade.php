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
                        <h5>{{ $user->spaceUsed() }}<br /><small>Used</small></h5>
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
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label>Username</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="Username" 
                                    name="username"
                                    id="username"
                                    value="{{ $user->profile->username }}" />

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- email address -->
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control border-input" 
                                    placeholder="Email"
                                    name="email"
                                    id="email"
                                    value="{{ $user->email }}" disabled>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- first name -->
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label>First Name</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="first_name"
                                    id="first_name"
                                    value="{{ $user->profile->first_name }}">

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- last name -->
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label>Last Name</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="last_name"
                                    id="last_name"
                                    value="{{ $user->profile->last_name }}">

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- address -->
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label>Address</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="address"
                                    id="address"
                                    value="{{ $user->profile->address }}">

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <!-- city -->
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label>City</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="city"
                                    id="city"
                                    value="{{ $user->profile->city }}">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- country -->
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                <label>Country</label>
                                <input type="text" class="form-control border-input" 
                                    placeholder="..." 
                                    name="country"
                                    id="country"
                                    value="{{ $user->profile->country }}">

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- zip code -->
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                                <label>Postal Code</label>
                                <input type="number" class="form-control border-input" 
                                    placeholder="..." 
                                    name="zip_code"
                                    id="zip_code"
                                    value="{{ $user->profile->zip_code }}">

                                @if ($errors->has('zip_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- about -->
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                <label>About Me</label>
                                <textarea rows="5" class="form-control border-input" 
                                    placeholder="No description yet." 
                                    name="about"
                                    id="about"
                                    value="Mike">{{ $user->profile->about }}</textarea>

                                @if ($errors->has('about'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('about') }}</strong>
                                    </span>
                                @endif
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

<script>

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

    var onView = {
        locality: 'city',
        country: 'country',
        postal_code: 'zip_code'
    };


    // Component initialization
    function initAutocomplete() {
        var input = document.getElementById('address');
        autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});

        autocomplete.addListener('place_changed', fillInAddress);
    };

    // Form autocompletion
    function fillInAddress() {

        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            if (onView.hasOwnProperty(component)) {
                  document.getElementById(onView[component]).value = '';
                  document.getElementById(onView[component]).disabled = false;
            }
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];

            // document.getElementById(addressType).value = val;
            if (onView.hasOwnProperty(addressType)) {
                document.getElementById(onView[addressType]).value = val;
            }
          }
        }
  }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_AUTOCOMPLETE_KEY') }}&libraries=places&callback=initAutocomplete"></script>



@endsection

@section('partials')
    @include('partials._update_background_image_modal')
    @include('partials._update_profile_image_modal')
@endsection
