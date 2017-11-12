<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\User;
use App\Notifications\UserRegistered as UserRegistered;

use Intervention\Image\ImageManager as Image;
use League\Glide\ServerFactory;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\Exception\NotReadableException;

class UsersController extends Controller
{
    /**
     * User model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $users;

    /**
     * Intervention image manager.
     *
     * @var \Intervention\Image\ImageManager 
     */
    protected $image;


    public function __construct(User $users, Image $image)
    {
        $this->users = $users;
        $this->image = $image;
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

        return redirect()->back()->with([
            'message' =>  'Profile updated.',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->users->findOrFail($id);
        $user->delete();

        return redirect()->back()->with([
            'message' =>  'User deleted.',
            'status' => 'success',
        ]);
    }

    /**
     * Unlock user access.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unlock($id)
    {
        $user = $this->users->findOrFail($id);
        $user->unlock();

        return redirect()->back()->with([
            'message' =>  'User unlocked.',
            'status' => 'success',
        ]);
    }



    /**
     * Lock user access.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lock($id)
    {
        $user = $this->users->findOrFail($id);
        $user->lock();

        return redirect()->back()->with([
            'message' =>  'User locked.',
            'status' => 'success',
        ]);
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

    /**
     * Update user's background profile image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getBackgroundImage(Request $request, $id)
    {
        $server = ServerFactory::create([
            'source' => storage_path(),
            'cache' => storage_path().'/cache',
        ]);

        $user = User::findOrFail($id);
        $resizeParams = [
            'w' => $request->has('w') ? @$request['w'] : 300,
            'h' => $request->has('h') ? @$request['h'] : 400,
        ];

        // dd($server->getImageResponse($user->profile->background_image_url, $resizeParams));
        return $server->outputImage($user->profile->background_image_url, $resizeParams);
    }



    /**
     * Update user's background profile image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setBackgroundImage(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (! $request->has('image')) {
            return redirect()->back()->with([
                'message' =>  'Could not find image.',
                'status' => 'danger',
            ]);
        }

        $image = $this->image->make($request->file('image'))->resize(200, 200);

        // save image
        $filename = 'profile-'.$user->id.'-'.uniqid().'.jpg';
        $image->save(storage_path($filename));

        // save profile update
        $user->profile->background_image_url = $filename;
        $user->profile->save();

        return redirect()->back()->with([
            'message' =>  'Background image updated.',
            'status' => 'success',
        ]);
    }



    /**
     * Update user's profile image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setProfileImage(Request $request, $id)
    {
        dd($request->all());
    }




}
