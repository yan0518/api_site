<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SmartAppException;
use App\Http\Controllers\Controller;
use App\Repositories\WechatUsersRepositoryEloquent;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DoctorEditRequest;
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
    protected $patients;

    /**
     * PatientController constructor.
     *
     * @param WechatUsersRepositoryEloquent $repository
     */
    public function __construct(WechatUsersRepositoryEloquent $patients)
    {
        $this->patients = $patients;
    }

    public function list() {
        $data = $this->patients->getPatientList();
        if(is_null($data)){
            $data = [];
        }
        return $this->SuccessResponse($data);
    }

}
