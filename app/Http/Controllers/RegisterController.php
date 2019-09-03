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
        $this->wechat_user->update(['cell' => $request->cell], $user_id);


        //用户与医生绑定关系
        $this->doctor_patients->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $user->id,
            'status' => DoctorPatients::status_valid
        ]);

        return $this->SuccessResponse();
    }

    public function succeed()
    {
        return View('registerSucceed');
    }
}
