<?php

namespace App\Http\Controllers\Oauth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\SmartAppException;
use App\Http\Requests\ForgotPwdRequest;
use App\Repositories\FUsersRepositoryEloquent;
use App\Repositories\FVerificationCodesRepositoryEloquent;

/**
 * Class FUsersController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class ForgotPwdController extends Controller
{
    /**
     * @var FUsersRepository
     */
    protected $user;

    protected $verify_code;

    /**
     * FUsersController constructor.
     *
     * @param FUsersRepository $repository
     */
    public function __construct(FUsersRepositoryEloquent $user, FVerificationCodesRepositoryEloquent $verify_code)
    {
        $this->user = $user;
        $this->verify_code = $verify_code;
    }


    public function forgetpwd(ForgotPwdRequest $request){
        $user_info = $this->user->findWhere(['cell' => $request->cell, 'status' => 1])->first();
        if(is_null($user_info)){
            throw new SmartAppException(-2100003);
        }
        $rst = $this->user->update(['pwd' => hash('sha256', $request->password)], $user_info->id);
        if($rst){
            return $this->SuccessResponse();
        }
        throw new SmartAppException(-2100005);
    }
}
