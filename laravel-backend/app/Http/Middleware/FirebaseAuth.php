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
        \Log::info('Config credentials entire array:', [config('firebase.credentials')]);
        \Log::info('env(FIREBASE_CREDENTIALS):', [env('FIREBASE_CREDENTIALS')]); // 👈 ここ
        \Log::info('Firebase credential path:', [config('firebase.credentials')]);
        $idToken = $request->bearerToken(); // Authorization: Bearer xxxx
        \Log::info('Token from header:', [$idToken]);
        $path = config('firebase.projects.app.credentials.file');
        \Log::info('File exists? ' . (file_exists($path) ? 'yes' : 'no'));
        \Log::info('First 100 chars: ' . substr(file_get_contents($path), 0, 100));
        \Log::info('Firebase credential path:', [$path]); 
    if (!file_exists($path)) {
        \Log::error('サービスアカウントファイルが存在しません: ' . $path);
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
            \Log::error('Firebase verifyIdToken エラー: ' . $e->getMessage()); // 🔽 ここがポイント！
            \Log::error('Exception trace: ' . $e->getTraceAsString());
            return response()->json(['error' => '無効なトークン'], 401);
        }

        
    }
}
