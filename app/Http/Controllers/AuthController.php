<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $user = User::create($data);
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required'
            ],
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)){
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout(Request  $request)
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        if ( Auth::id() === $request->id) {
            $data = $request->validated();
            $user = auth()->user();
            // Check if image was given and save on local file system
            if (isset($data['image'])) {
                $relativePath = $this->saveImage($data['image']);
                $data['image'] = $relativePath;

                // If there is an old image, delete it
                if ($user->image) {
                    $absolutePath = public_path($user->image);
                    File::delete($absolutePath);
                }
            }

            $user = User::whereId($request->id)->update($data);

            $user = User::where('id', auth()->id())->first();

            return new UserResource($user);
            }
            else if ( Auth::user()->role === 'Admin') {
                $data = $request->validated();

                $user = User::whereId($request->id)->first();
                // Check if image was given and save on local file system
                if (isset($data['image'])) {
                    $relativePath = $this->saveImage($data['image']);
                    $data['image'] = $relativePath;

                    // If there is an old image, delete it
                    if ($user->image) {
                        $absolutePath = public_path($user->image);
                        File::delete($absolutePath);
                    }
                }

                $updatedUser = $user->update($data);

                // $user = User::where('id', auth()->id())->first();

                return 'success';

                }

        return 'Unauthorized Action';
    }

    // Accept Users
    public function acceptUser(Request $request){
        if(auth()->user()->role === 'Admin'){
            $user = User::whereId($request->id)->first();
            if($user->role === 'Teacher'){
                $position = $request->validate([
                    'position' => 'required||string',
                ]);
                $user['position'] = $position['position'];
                $user['status'] = 'Active';
            }else{
                $user['status'] = 'Active';
            }
            $user->save();
            return $user;
        }

        abort(403, 'Unauthorized Action');
    }

    public function destroy($id){
        $user = User::whereId($id)->first();

        if (auth()->user()->role === 'Admin'){
            $user->delete();
            return response(['success'], 200);
        }
        return abort(403, 'Unauthorized Action');
    }
    public function search($search){
        $result = User::latest()->where('name', 'like', '%' . $search . '%')
        ->orWhere('department', 'like', '%' . $search . '%')
        ->orWhere('course', 'like', '%' . $search . '%')->get();

        return UserResource::collection($result);
    }
     /**
     * Save image in local file system and return saved image path
     *
     * @param $image
     * @throws \Exception
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
