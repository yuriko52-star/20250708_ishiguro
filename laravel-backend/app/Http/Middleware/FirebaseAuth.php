<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Models\User;

class FirebaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        $idToken = $request->bearerToken(); 
        $path = config('firebase.projects.app.credentials.file');
        
    if (!file_exists($path)) {
       
        return response()->json(['error' => '認証設定ファイルが見つかりません'], 500);
    }

        if (!$idToken) {
            return response()->json(['error' => 'トークンなし'], 401);
        }

        try {
            $firebase = (new Factory)  
                ->withServiceAccount(config('firebase.projects.app.credentials.file'))
                ->createAuth();
            $verifiedIdToken = $firebase->verifyIdToken($idToken);

            $uid = $verifiedIdToken->claims()->get('sub');

            $user = User::where('firebase_uid', $uid)->first();

            if(!$user) {
                return response()->json(['error' => 'ユーザーが見つかりません'], 404);
            }

            auth()->login($user);

            return $next($request);
        } catch (\Throwable $e) {
           
            return response()->json(['error' => '無効なトークン'], 401);
        }

        
    }
}
