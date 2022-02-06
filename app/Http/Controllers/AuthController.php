<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\JwtAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use External\Bar\Auth\LoginService as BarLoginService;
use External\Baz\Auth\Authenticator as BazLoginService;
use External\Foo\Auth\AuthWS as FooLoginService;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(
        Request $request,
        JwtAuthenticator $jwtAuth,
        BarLoginService $barLoginService,
        FooLoginService $fooLoginService,
        BazLoginService $bazLoginService
    ): JsonResponse {
        // Request login name
        $login = $request->login;
        $password = $request->password;

        // Check company user
        if (Str::startsWith($login, 'BAR_') == true) {
            // Proceed to login service
            $isAuth = $barLoginService->login($login, $password);
            if ($isAuth) {
                // Authorize credentials
                $data = [
                    'login' => $login
                ];

                $token = $jwtAuth->create($data);

                return response()->json([
                    'status' => 'success',
                    'token'  => $token
                ]);
            }

            return response()->json([
                'status' => 'failure',
            ]);
        }

        if (Str::startsWith($login, 'BAZ_') == true) {
            // Proceed to login service
            $isAuth = $bazLoginService->auth($login, $password);
            if ($isAuth) {
                // Authorize credentials
                $data = [
                    'login' => $login
                ];

                $token = $jwtAuth->create($data);

                return response()->json([
                    'status' => 'success',
                    'token'  => $token
                ]);
            }

            return response()->json([
                'status' => 'failure',
            ]);
        }

        if (Str::startsWith($login, 'FOO_') == true) {
            // Proceed to login service
            $isAuth = $fooLoginService->authenticate($login, $password);
            if ($isAuth) {
                // Authorize credentials
                $data = [
                    'login' => $login
                ];

                $token = $jwtAuth->create($data);

                return response()->json([
                    'status' => 'success',
                    'token'  => $token
                ]);
            }

            return response()->json([
                'status' => 'failure',
            ]);
        }

        return response()->json([
            'status' => 'failure',
        ]);
    }
}
