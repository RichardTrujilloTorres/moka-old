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
     * Default max number of results per page.
     *
     * @const
     */
    const DEFAULT_MAX_RESULTS = 10;


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
        $users = User::paginate(self::DEFAULT_MAX_RESULTS);

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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (! $user->hasProfile()) {
            $user->profile->build($user);
        }

        return view('users::edit')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (! $user->hasProfile()) {
            $user->profile = $user->buildProfile();
        }

        return view('users::edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        // @todo add validation
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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with([
            'message' =>  'User deleted.',
            'status' => 'success',
        ]);
    }

    /**
     * Unlock user access.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function unlock(User $user)
    {
        $user->unlock();

        return redirect()->back()->with([
            'message' =>  'User unlocked.',
            'status' => 'success',
        ]);
    }



    /**
     * Lock user access.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function lock(User $user)
    {
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
     * Retrieve user's profile image.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function getProfileImage(Request $request, User $user)
    {
        $server = ServerFactory::create([
            'source' => storage_path(),
            'cache' => storage_path().'/cache',
        ]);

        $resizeParams = [
            'w' => $request->has('w') ? @$request['w'] : 300,
            'h' => $request->has('h') ? @$request['h'] : 400,
        ];

        return $server->outputImage($user->profile->avatar_url, $resizeParams);
    }


    /**
     * Update user's background profile image.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function getBackgroundImage(Request $request, User $user)
    {
        $server = ServerFactory::create([
            'source' => storage_path(),
            'cache' => storage_path().'/cache',
        ]);

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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function setBackgroundImage(Request $request, User $user)
    {
        if (! $request->has('image')) {
            return redirect()->back()->with([
                'message' =>  'Could not find image.',
                'status' => 'danger',
            ]);
        }

        $image = $this->image->make($request->file('image'));

        // save image
        $filename = 'profile-background-'.$user->id.'-'.uniqid().'.jpg';
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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function setProfileImage(Request $request, User $user)
    {
        if (! $request->has('profile-image')) {
            return redirect()->back()->with([
                'message' =>  'Could not find image.',
                'status' => 'danger',
            ]);
        }

        
        $image = $this->image->make($request->file('profile-image'));

        // save image
        $filename = 'profile-'.$user->id.'-'.uniqid().'.jpg';
        $image->save(storage_path($filename));

        // save profile update
        $user->profile->avatar_url = $filename;
        $user->profile->save();

        return redirect()->back()->with([
            'message' =>  'Profile image updated.',
            'status' => 'success',
        ]);
    }
}
