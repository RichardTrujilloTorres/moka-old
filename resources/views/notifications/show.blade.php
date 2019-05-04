@extends('layouts.master')

@section('title')
Notifications
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <h4 class="title">{{ $notification->data['text'] }}</h4>
            </div>

            <div class="content">
                <div class="row">

                    <div class="col-md-6">
                        No description available for this notification.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
