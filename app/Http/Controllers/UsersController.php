<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepositoryEloquent;
use App\Models\Users;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;

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

        throw new UserAppException(-2100003);
    }

    public function list(Request $request) {
        $pageNum = $request->pageNum ?? 1;
        $pageSize = $request->pageSize ?? 20;
        $params = $request->searchKey ?? '';

        $query = Users::where('status', '!=', Users::status_invalid);
        if($params) {
            $query->where('name', 'like', '%'.$params.'%')
                        ->orWhere('cell', $params);
        }
        $total = $query->count();
        $list = $query->offset(($pageNum - 1)* $pageSize)
                ->limit($pageSize)
                ->get();
       
        return $this->SuccessResponse([
            'total' => $total,
            'list' => $list
        ]);
    }

    public function get($id) {
        $data = $this->user->find($id);

        return $this->SuccessResponse($data);
    }}

    public function create(UserRequest $request) {
        $data = [
            'name' => $request->name,
            'pwd' => $request->password,
            'login_id' => $request->login_id,
            'cell' => $request->cell,
            'gender' => 0,
            'status' => Users::status_valid,
            'lock_status' => Users::lock_status_unlock
        ];
        $this->user->create($data);

        return $this->SuccessResponse();
    }

    public function update(UserEditRequest $request) {
        if(!empty($request->name)){
            $data['name'] = $request->name;
        }
        if(!empty($request->password)){
            $data['pwd'] = $request->password;
        }
        if(!empty($request->login_id)){
            $data['login_id'] = $request->login_id;
        }
        if(!empty($request->cell)){
            $data['cell'] = $request->cell;
        }
        $this->user->update($data, $request->id);

        return $this->SuccessResponse();
    }

    public function delete($id) {
        $user = $this->user->find($id);
        if(is_null($user)){
            throw new DoctorAppException(-2100008);
        }
        $this->user->update(['status' =>  User::status_invalid], $id);

        return $this->SuccessResponse();
    }
