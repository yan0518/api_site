<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientCreateRequest;
use App\Repositories\DoctorPatientsRepositoryEloquent;
use App\Repositories\DoctorsRepositoryEloquent;
use App\Repositories\PatientRepositoryEloquent;
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

    protected $patient;
    protected $doctor_patients;

    protected $doctor;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct(PatientRepositoryEloquent $patient,
                                DoctorsRepositoryEloquent $doctor,
                                DoctorPatientsRepositoryEloquent $doctor_patients)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->doctor_patients = $doctor_patients;
    }

    public function index()
    {
        $docId = 1;
        return View('register', compact('docId'));
    }

    public function save(PatientCreateRequest $request)
    {
        $uuid = $request->uuid;
        $doctor = $this->doctor->findWhere(['uuid' => $uuid])->first();
        if (is_null($doctor)) {
            throw new DoctorAppException(-2100003);
        }

        // 创建报名用户
        $patient = [
            'name' => $request->name,
            'sex' => $request->sex,
            'birthday' => $request->bday,
            'cell' => $request->cell
        ];
        $patientId = $this->patient->create($patient);

        //用户与医生绑定关系
        $this->doctor_patients->create([
            'doctor_id' => $doctor->id,
            'patient_id' => patientId,
            'status' => DoctorPatients::status_valid
        ]);

        return $this->SuccessResponse();
    }

    public function succeed()
    {
        return View('registerSucceed');
    }
}
