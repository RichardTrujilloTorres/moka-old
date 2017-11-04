<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\User;
use App\Notifications\UserRegistered as UserRegistered;

class UsersController extends Controller
{
    protected $users;


    public function __construct(User $users)
    {
        $this->users = $users;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users::index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->users->findOrFail($id);

        if (! $user->hasProfile()) {
            dd('here');
            $user->profile->build($user);
        }

        return view('users::edit')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->users->findOrFail($id);
        if (! $user->hasProfile()) {
            $user->profile = $user->buildProfile();
        }

        return view('users::edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // @todo add validation
        $user = $this->users->findOrFail($id);
        $user->profile->fill($request->all());
        $user->profile->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // Tests shit out. Go figure.
    public function test()
    {
        // mimic user registration notification
        $newUser = User::create([
            'email' => 'johndoe@email.com',
            'name' => 'John Doe',
            'password' => \Hash::make('secret'),
        ]);

        $admin = User::findOrFail(11); // tmp admin
        $admin->notify(new UserRegistered($newUser));
    }

}
