<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SmartAppException;
use App\Http\Controllers\Controller;
use App\Repositories\WechatUsersRepositoryEloquent;
use Illuminate\Support\Facades\Storage;

/**
 * Class PatientController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class PatientController extends Controller
{
    /**
     * @var WechatUsersRepositoryEloquent
     */
    protected $wechat_user;

    /**
     * PatientController constructor.
     *
     * @param WechatUsersRepositoryEloquent $repository
     */
    public function __construct(WechatUsersRepositoryEloquent $wechat_user)
    {
        $this->wechat_user = $wechat_user;
    }

    public function list(Request $request) {
        $pageNum = $request->pageNum ?? 1;
        $pageSize = $request->pageSize ?? 20;
        $params = $request->searchKey ?? '';

        $data = $this->wechat_user->getPatientList($pageNum, $pageSize, $params);
        
        if(is_null($data)){
            $data = [];
        }
        return $this->SuccessResponse($data);
    }

}
