<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function register(Request $request)
    {
        $idToken = $request->input('idToken');

        if (!$idToken) {
            return response()->json(['error' => 'idToken が届いていません'], 400);
        }

        try {
            
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');

            
            $firebaseUser = $this->firebaseAuth->getUser($uid);

            $user = User::firstOrCreate(
                ['firebase_uid' => $uid],
                ['username' => $firebaseUser->displayName,
                'email' => $firebaseUser->email,
                ]
            );

            Auth::login($user);

            return response()->json([
                'message' => '登録・ログイン成功',
                'user' => $user
            ]);
        } catch (FailedToVerifyToken $e) {
            \Log::error('Firebase Token error: ' . $e->getMessage());
            return response()->json(['error' => '無効なトークンです'], 401);
        }
    }

    public function me()
    {
        $user = Auth::user();

        if (!user) {
            return response()->json(['error' => '認証されていません'],401);
        }
        return response()->json(['user' => $user]);
    }
}
