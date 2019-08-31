<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepositoryEloquent;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class UsersController extends Controller
{
    /**
     * @var UsersRepositoryEloquent
     */
    protected $user;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct(UsersRepositoryEloquent $user)
    {
        $this->user = $user;
    }

    public function info(Request $request){
        $user = $request->user();
        $user_info = $this->user->find($user->id, ['id', 'name', 'cell', 'email', 'photo']);
        if(!is_null($user_info)){
            return $this->SuccessResponse($user_info);
        }

        throw new DoctorAppException(-2100003);
    }
}
