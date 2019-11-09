<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientCreateRequest;
use App\Models\DoctorPatients;
use App\Models\Verifycode;
use App\Repositories\DoctorPatientsRepositoryEloquent;
use App\Repositories\DoctorsRepositoryEloquent;
use App\Repositories\WechatUsersRepositoryEloquent;
use App\Repositories\VerifycodeRepositoryEloquent;
use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepositoryEloquent;
use Illuminate\View\View;
use EasyWeChat;
use Carbon\Carbon;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class RegisterController extends Controller
{

    protected $wechat_user;
    protected $doctor_patients;

    protected $doctor;
    protected $verify_code;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct(WechatUsersRepositoryEloquent $wechat_user,
                                DoctorsRepositoryEloquent $doctor,
                                DoctorPatientsRepositoryEloquent $doctor_patients,
                                VerifycodeRepositoryEloquent $verify_code)
    {
        $this->wechat_user = $wechat_user;
        $this->doctor = $doctor;
        $this->doctor_patients = $doctor_patients;
        $this->verify_code = $verify_code;
    }

    public function index($docId, $openId)
    {
        $user_info = $this->wechat_user->findWhere(['openID' => $openId])->first();
        if (!$user_info) {
            return $this->ErrorResponse(-999);
        }

        $docInfo = $this->doctor->findWhere(['uuid' => $docId])->first();
        if (!$docInfo) {
            return $this->ErrorResponse(-999);
        }

        $bindInfo = $this->doctor_patients->findWhere(['doctor_id' => $docInfo->id, 'patient_id' => $user_info->id])->first();
        if ($bindInfo) {
            return View('registerSucceed');
        }


        return View('register', compact('docId', 'openId'));
    }

    public function save(PatientCreateRequest $request)
    {
        $code_type = 1;
        $valid_time = 300;
        $verify_info = $this->verify_code->findWhere([
            'cell' => $request->cell,
            'type' => $code_type,
            'code' => $request->verify_code,
            'status' => Verifycode::status_valid,
        ])->first();

        if (!is_null($verify_info)) {
            if ($verify_info->created_at <= date('Y-m-d H:i:s', time() - $valid_time)) {

                $this->verify_code->find($verify_info->id)->update([
                    'status' => Verifycode::status_delete,
                ]);

                throw new DoctorAppException(-2100006);
            }

            $this->verify_code->usedVerifyCode($verify_info->id);


        } else {
            throw new DoctorAppException(-2100005);
        }

        $uuid = $request->uuid;
        $doctor = $this->doctor->findWhere(['uuid' => $uuid])->first();
        if (is_null($doctor)) {
            throw new DoctorAppException(-2100003);
        }

        $user = $this->wechat_user->findWhere(['openID' => $request->openid])->first();

        //更新微信用户手机号
        $this->wechat_user->update(['cell' => $request->cell], $user->id);


        //用户与医生绑定关系
        $this->doctor_patients->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $user->id,
            'status' => DoctorPatients::status_valid
        ]);

        $wechatServer = app('wechat.official_account');
        $wechatServer->template_message->send([
            'touser' => $request->openid,
            'template_id' => '0dyi8qARPhUviBIQFxUidbq9-XR9F_EOkyUWllFvDLs',
            'url' => 'https://www.wenjuan.com/s/BJBbaed',
            'miniprogram' => [
                'appid' => 'wx97cfa6ffa05a01d7',
                'pagepath' => 'pages/shelf/shelf',
            ],
            'data' => [
                'first' => '欢迎你加入喜福康平台！',
                'keyword1' => $request->cell,
                'keyword2' => Carbon::now(),
                'keyword3' => '喜福康平台',
                'remark' => '更多优惠信息，尽在喜福康商城！'
            ],
        ]);

        return $this->SuccessResponse();
    }

    public function succeed()
    {
        return View('registerSucceed');
    }
}
