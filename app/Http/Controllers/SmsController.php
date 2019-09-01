<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\VerifycodeRepositoryEloquent;
use App\Http\Requests\SmsRequest;
use App\Common\SMS\Sms;
use App\Models\Verifycode;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class SmsController extends Controller
{
    protected $verify_code;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct(VerifycodeRepositoryEloquent $verify_code)
    {
        $this->verify_code = $verify_code;
    }

    public function send(SmsRequest $request)
    {
        $cell = $request->cell;
        $type = $request->type;
        if($type == 1){
            $sms = new Sms();
            $code = rand(100000, 999999);
            $exist_flg = false;
            $verify_info = $this->verify_code->findWhere([
                    'cell' => $cell, 
                    'type' => $type, 
                    'status' => Verifycode::status_valid,
                ])->first();

            if(!is_null($verify_info)){
                if($verify_info->created_at >= date('Y-m-d H:i:s', time() - 60)){
                    throw new DoctorAppException(-1100023);
                }
                if($verify_info->created_at >= date('Y-m-d H:i:s', time() - 300)){
                    $code = $verify_info->code;
                    $exist_flg = true;
                }
                else{
                    $this->verify_code->find($verify_info->id)->update([
                        'status' => Verifycode::status_delete,
                    ]);
                }
            }
            $rst = $sms->sendVerifyCode($cell, $code);
            if($rst){
                if(!$exist_flg){
                    $data = [
                        'cell' => $cell,
                        'content' => '',
                        'code' => $code,
                        'type' => $type,
                    ];
                    $this->verify_code->create($data);
                }
                return $this->SuccessResponse();
            }
            throw new DoctorAppException(-2100004);
        }
        else{
            throw new DoctorAppException(-2100004);
        }
        return $this->SuccessResponse();
    }


}
