<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DB;
// use Mail;
use stdClass;

class AuthController extends Controller
{
    public function index()
    {

        $jan = DB::table('users')
            ->whereBetween('created_at', [date('2020-01-01'), date('2020-01-31')])
            ->count();
        $feb = DB::table('users')
            ->whereBetween('created_at', [date('2020-02-01'), date('2020-02-31')])
            ->count();
        $mar = DB::table('users')
            ->whereBetween('created_at', [date('2020-03-01'), date('2020-03-31')])
            ->count();
        $apr = DB::table('users')
            ->whereBetween('created_at', [date('2020-04-01'), date('2020-04-31')])
            ->count();
        $mei = DB::table('users')
            ->whereBetween('created_at', [date('2020-05-01'), date('2020-05-31')])
            ->count();
        $jun = DB::table('users')
            ->whereBetween('created_at', [date('2020-06-01'), date('2020-06-31')])
            ->count();
        $jul = DB::table('users')
            ->whereBetween('created_at', [date('2020-07-01'), date('2020-07-31')])
            ->count();
        $aug = DB::table('users')
            ->whereBetween('created_at', [date('2020-08-01'), date('2020-08-31')])
            ->count();
        $sep = DB::table('users')
            ->whereBetween('created_at', [date('2020-09-01'), date('2020-09-31')])
            ->count();
        $oct = DB::table('users')
            ->whereBetween('created_at', [date('2020-10-01'), date('2020-10-31')])
            ->count();
        $nov = DB::table('users')
            ->whereBetween('created_at', [date('2020-11-01'), date('2020-11-31')])
            ->count();
        $des = DB::table('users')
            ->whereBetween('created_at', [date('2020-12-01'), date('2020-12-31')])
            ->count();

        $object = new stdClass();
        $object->jan = $jan;
        $object->feb = $feb;
        $object->mar = $mar;
        $object->apr = $apr;
        $object->mei = $mei;
        $object->jun = $jun;
        $object->jul = $jul;
        $object->aug = $aug;
        $object->sep = $sep;
        $object->oct = $oct;
        $object->nov = $nov;
        $object->des = $des;

        // $count = {
        //     'jan' => $jan,
        //      $feb, $mar, $apr, $mei, $jun, $jul, $aug, $sep, $oct, $nov, $des};
        $user = User::all();
        if (count($user)  > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user,
                'month' => $object
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $registrationData['password'] = bcrypt($request->password);
        $registrationData['remember_token'] = md5(openssl_random_pseudo_bytes(32));
        $data = [
            'url' => 'http://paw8api.online/api/email/',
            'email' => $registrationData['email'],
            'body' => $registrationData['remember_token'],
        ];
        $email = $request->email;
        // $email = 'Hellchimera33@gmail.com';

        Mail::send('mail', $data, function ($mail) use ($email) {
            $mail->from('laravelid@gmail.com', 'Laravel Indonesia');
            $mail->to($email, 'Verification');
        });
        // Mail::to($email)->send(new UserMail($data));
        if (Mail::failures()) {
            return response([
                'message' => 'Failed to send email',
                'data' => null
            ], 404);
        }
        $user = User::create($registrationData);
        return response([
            'message' => 'Register Success',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }
        if (!Auth::attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }


        $user = Auth::user();
        if($user->email_verified_at === null){
            return response(['message' => 'Not Verified'], 401);
        }
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function update(Request $request, $id)
    {
        \Log::info($request->all());
        $user = User::findOrFail($id);
        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if ($request->name != null) {
            $user->name = $request->name;
        }

        if ($request->email != null) {
            $user->email = $request->email;
        }

        if ($request->status != null) {
            $user->status = $request->status;
        }

        if ($request->password != null) {
            if (Hash::check($request->passwordOld, $user->password))
                $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            else {
                return response([
                    'message' => 'Password Lama Salah',
                    'data' => null,
                ], 400);
            }
        }

        if (isset($request->image)) {
            $explodeed = explode(',', $request->image);
            $decoded = base64_decode($explodeed[1]);

            (str_contains($explodeed[0], 'jpeg')) ?  $extension = 'jpg' : $extension = 'png';
            $filename = rand() . '.' . $extension;
            $path = public_path() . '/' . $filename;
            file_put_contents($path, $decoded);
            $user->image = $filename;
        }

        $user->updated_at = Carbon::now();

        if ($user->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $user,
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if ($user->delete()) {
            return response([
                'message' => 'Delete User Success',
                'data' => $user,
            ], 200);
        }

        return response([
            'message' => 'Delete User Failed',
            'data' => null,
        ], 400);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            return response([
                'message' => 'Retrieve Success',
                'user' => $user
            ], 200);
        }

        return response([
            'message' => 'No User Were Found',
            'user' => null
        ], 404);
    }

    public function verify(Request $request, $email, $token){

        $id = DB::table('users')->where('email', $email)->value('id');
        $user = User::findOrFail($id);
        if (is_null($user)) {
            return response([
                'message' => '404 User Not Found',
                'data' => null
            ], 404);
        }

        if($user->remember_token === $token){

            $user->email_verified_at = Carbon::now();
            if($user->save()){
                return response([
                    'message' => 'Verified',
                    'data' => $user
                ], 200);
            }
            return response([
                'message' => 'Vrify User Failed',
                'data' => null,
            ], 400);

        }
        
        return response([
            'message' => 'Token Invalid',
            'data' => null,
        ], 400);

    }
}