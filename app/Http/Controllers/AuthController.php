<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * Validates the received request and log in.
     *
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Log in",
     *      description="Returns the JWT token",
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  default="Successfully authenticated"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  default="Token data json"
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid Credentials",
     *      )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'message' => 'Successfully authenticated',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }

    /**
     * Logout the token related user.
     *
     * @OA\Post(
     *      path="/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Log out",
     *      description="Returns a message related to action",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  default="Logged out successfully"
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid Credentials",
     *      ),
     *     @OA\Response(
     *          response="404",
     *          description="Not authenticated",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  default="You are not logged in"
     *              )
     *          )
     *     )
     * )
     */
    public function logout()
    {
        $authenticated = auth()->user();
        if (is_null($authenticated))
        {
            return response()->json(['message' => 'You are not logged in'], 404);
        }

        auth()->logout();
        return response()->json(['message' => 'Logged out successfully'], 205);
    }
}
