<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SmartAppException;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepositoryEloquent;
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
     * @var PatientRepositoryEloquent
     */
    protected $patients;

    /**
     * PatientController constructor.
     *
     * @param PatientRepositoryEloquent $repository
     */
    public function __construct(PatientRepositoryEloquent $patients)
    {
        $this->patients = $patients;
    }

    public function list(Request $request) {
        $pageNum = $request->pageNum ?? 1;
        $pageSize = $request->pageSize ?? 20;
        $data = $this->patients->getPatientList($pageNum, $pageSize);
        if(is_null($data)){
            $data = [];
        }
        return $this->SuccessResponse($data);
    }

}
