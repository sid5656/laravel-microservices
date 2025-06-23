<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $r)
    {   
        
       $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
      
        if ($validator->fails()) {
            return Response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = User::create([
            'name'  => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $r)
    {
     
        $validator = Validator::make($r->all(), [
           'email' => 'required|email',
            'password' => 'required',
        ]);
      
        if ($validator->fails()) {
            return esponse()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $r->email)->first();

        if (! $user || ! Hash::check($r->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }
}
