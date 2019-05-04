@extends('layouts.master')

@section('title')
Notifications
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <h4 class="title">Notifications</h4>
            </div>

            <div class="content table-responsive table-full-width">
                @if ($notifications->isEmpty())
                <div class="form-control">
                    No notifications yet.
                </div>
                @endif

                @if (! $notifications->isEmpty())
                <table class="table table-striped">
                    <thead>
                        <th>Notification</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->data['text'] }}</td>
                            <td>

                                {{-- detail --}}
                                <a href="{{ route('admin.users.notifications.show', $notification->id) }}">
                                    <i class="fa fa-eye" title="details"></i>
                                </a>

                                {{-- mark as read --}}
                                <a href="{{ route('admin.users.notifications.mark-as-read', $notification->id) }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('mark-as-read-notification-form-{{ $notification->id }}').submit();">
                                    <i class="fa fa-check-circle-o" title="mark as read"></i>
                                </a>

                                <form id="mark-as-read-notification-form-{{ $notification->id }}"
                                      name="mark-as-read-notification-form-{{ $notification->id }}"
                                      action="{{ route('admin.users.notifications.mark-as-read', $notification->id) }}"
                                      method="POST" style="display:none;">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                </form>

                                {{-- remove --}}
                                <a href="{{ route('admin.users.notifications.destroy', $notification->id) }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('delete-notification-form-{{ $notification->id }}').submit();">
                                    <i class="fa fa-trash" title="remove"></i>
                                </a>

                                <form id="delete-notification-form-{{ $notification->id }}"
                                    name="delete-notification-form-{{ $notification->id }}"
                                    action="{{ route('admin.users.notifications.destroy', $notification->id) }}"
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
