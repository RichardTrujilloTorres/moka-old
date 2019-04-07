<div class="sidebar" data-background-color="black" data-active-color="success">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ url('/') }}" class="simple-text">
                {{ config('app.name') }}
            </a>
        </div>

        <ul class="nav">

        @if (Route::is('admin.dashboard'))
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{ route('admin.dashboard') }}">
                    <i class="ti-pie-chart"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            @if (Route::is('admin.users.*') && !Route::is('admin.users.roles.*') || Route::is('admin.users.index'))
                <li class="active">
            @else
                <li>
            @endif
                    <a href="{{ route('admin.users.index') }}">
                        <i class="ti-user"></i>
                        <p>Users</p>
                    </a>
                </li>

                @if (Route::is('admin.users.roles.*') || Route::is('admin.users.roles'))
                    <li class="active">
                @else
                    <li>
                @endif
                        <a href="{{ route('admin.users.roles.index') }}">
                            <i class="ti-lock"></i>
                            <p>Roles</p>
                        </a>
                    </li>
        </ul>
    </div>
</div>
