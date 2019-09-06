<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\DoctorsRepositoryEloquent;
use App\Repositories\DoctorPatientsRepositoryEloquent;
use App\Repositories\WechatUsersRepositoryEloquent;
use App\Models\Doctors;
use App\Models\DoctorPatients;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DoctorEditRequest;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

/**
 * Class DoctorController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class DoctorController extends Controller
{
    /**
     * @var DoctorsRepositoryEloquent
     */
    protected $doctor;
    protected $doctor_patients;
    protected $patients;

    /**
     * DoctorController constructor.
     *
     * @param DoctorsRepositoryEloquent $repository
     */
    public function __construct(DoctorsRepositoryEloquent $doctor,
                    DoctorPatientsRepositoryEloquent $doctor_patients,
                    WechatUsersRepositoryEloquent $patients)
    {
        $this->doctor = $doctor;
        $this->doctor_patients = $doctor_patients;
        $this->patients = $patients;
    }

    public function list(Request $request) {
        $pageNum = $request->pageNum ?? 1;
        $pageSize = $request->pageSize ?? 20;
        $params = $request->searchKey ?? '';

        $query = Doctors::where('status', '!=', Doctors::status_invalid);
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

    public function info($id) {
        $data = $this->doctor->find($id);
        $data->photo = !empty($data->photo) ? Storage::url($data->photo) : '';

        return $this->SuccessResponse($data);
    }

    public function create(DoctorRequest $request) {
        $photo = '';
        if(!empty($request->photo)){
            //upload photo
            $photo = Storage::putFile('photos/'.Uuid::uuid4(), $request->photo);
        }
        $data = [
            'name' => $request->name,
            'hospital' => $request->hospital,
            'department' => $request->department,
            'position' => $request->position,
            'cell' => $request->cell,
            'saler' => $request->saler ?? '',
            'sale_cell' => $request->sale_cell ?? '',
            'photo' => $photo,
            'uuid' => Uuid::uuid4(),
            'status' => Doctors::status_valid
        ];
        $this->doctor->create($data);

        return $this->SuccessResponse();
    }

    public function update(DoctorEditRequest $request) {
        $data = [
            'saler' => $request->saler ?? '',
            'sale_cell' => $request->sale_cell ?? ''
        ];
        if(!empty($request->name)){
            $data['name'] = $request->name;
        }
        if(!empty($request->hospital)){
            $data['hospital'] = $request->hospital;
        }
        if(!empty($request->department)){
            $data['department'] = $request->department;
        }
        if(!empty($request->position)){
            $data['position'] = $request->position;
        }
        if(!empty($request->cell)){
            $data['cell'] = $request->cell;
        }
        if(!empty($request->photo)){
            $photo = Storage::putFile('photos/'.Uuid::uuid4(), $request->photo);
            $data['photo'] = $photo;
        }
        $this->doctor->update($data, $request->id);

        return $this->SuccessResponse();
    }

    public function delete($id) {
        $doctor = $this->doctor->find($id);
        if(is_null($doctor)){
            throw new DoctorAppException(-2100001);
        }
        $this->doctor->update(['status' => Doctors::status_invalid], $id);

        return $this->SuccessResponse();
    }

}
