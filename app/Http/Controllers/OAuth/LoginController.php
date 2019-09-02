<?php

namespace App\Http\Controllers\OAuth;

use App\Exceptions\OauthException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;


class LoginController extends AccessTokenController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function withErrorHandling($callback)
    {
        try {
            return $callback();
        } catch (OAuthServerException $e) {
            if ($e->getCode() === 3) {
                //client 缺失
                throw new OauthException(-1100002);
            } else if ($e->getCode() === 2) {
                //无效grant_type
                throw new OauthException(-1100003);
            } else if ($e->getCode() === 4) {
                //client 无效
                throw new OauthException(-1100004);
            } else if($e->getCode() === 8){
                //refresh_token 无效
                throw new OauthException(-1100005);
            } else if ($e->getCode() === 6) {
                //用户认证失败
                throw new OauthException(-2100007);
            } else {
                //服务错误
                throw new OauthException(-9999999);
            }
        } catch (\Exception $e) {
            throw new OauthException(-9999999);
        } catch (\Throwable $e) {
            throw new OauthException(-9999999);
        }
    }

    public function login(ServerRequestInterface $request){
        $token = $this->issueToken($request)->content();
        return $this->SuccessResponse(json_decode($token, true));
    }

    protected function SuccessResponse($data=[], $code=1, $status_code=200){
        return \response()->json(compact('code','data'),$status_code);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $TokenRepository = new TokenRepository;
        $TokenRepository->revokeAccessToken($user->token()->id);
        return $this->SuccessResponse();
    }

}
