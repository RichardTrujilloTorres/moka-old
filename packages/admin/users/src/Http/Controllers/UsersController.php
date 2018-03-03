<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\UploadedFile;

use App\Http\Requests\UpdateUserRequest;
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
     * Default image extension.
     *
     * @var string
     */
    protected $defaultImageExtension = 'jpg';

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
    public function update(UpdateUserRequest $request, User $user)
    {
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
        $server = $this->getServerFactory();
        $resizeParams = $this->getResizeParams($request);

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
        $server = $this->getServerFactory();
        $resizeParams = $this->getResizeParams($request);

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

        $filename = $this->getProfileUniqueFilename($user);

        $this->saveProfileImage($request->file('profile-image'), $user, $filename);
        $this->setProfileAvatar($user, $filename);

        return redirect()->back()->with([
            'message' =>  'Profile image updated.',
            'status' => 'success',
        ]);
    }

    
    
    /**
     * Save user profile image.
     *
     * @param \App\User $user
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $filename
     * @return void
     */
    protected function saveProfileImage(UploadedFile $file, User $user, $filename)
    {
        $image = $this->image->make($file);
        $image->save(storage_path($filename));
    }

    /**
     * Set user profile avatar.
     *
     * @param \App\User $user
     * @param string $filename
     * @return void
     */
    protected function setProfileAvatar(User $user, $filename)
    {
        $user->profile->avatar_url = $filename;
        $user->profile->save();
    }


    /**
     * Get user profile unique filename.
     *
     * @param \App\User $user
     * @return string
     */
    protected function getProfileUniqueFilename(User $user)
    {
        return (string) ('profile-'.$user->id.'-'.uniqid().'.'.$this->defaultImageExtension);
    }

    /**
     * Get default Glide server factory.
     *
     * @return \League\Glide\ServerFactory
     */
    protected function getServerFactory()
    {
        return ServerFactory::create([
            'source' => storage_path(),
            'cache' => storage_path().'/cache',
        ]);
    }


    /**
     * Get default profile image resize params.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    protected function getResizeParams(Request $request)
    {
        return [
            'w' => $request->has('w') ? @$request['w'] : 300,
            'h' => $request->has('h') ? @$request['h'] : 400,
        ];
    }
}
