<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SmartAppException;
use App\Http\Controllers\Controller;
use App\Repositories\DoctorsRepositoryEloquent;
use App\Models\Doctors;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DoctorEditRequest;
use Illuminate\Support\Facades\Storage;

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

    /**
     * DoctorController constructor.
     *
     * @param DoctorsRepositoryEloquent $repository
     */
    public function __construct(DoctorsRepositoryEloquent $doctor)
    {
        $this->doctor = $doctor;
    }

    public function list($id = 0) {
        $params[] = ['status', '!=', Doctors::status_invalid];
        if(!empty($id) && is_numeric($id)) {
            $params[] = ['id', '=' ,$id];
        }
        $list = $this->doctor->findWhere($params)->all();
        
        if(is_null($list)){
            $list = [];
        }
        return $this->SuccessResponse($list);
    }

    public function create(DoctorRequest $request) {
        $photo = '';
        if(!empty($request->photo)){
            //upload photo
            $photo = Storage::disk('local')->putFile('photos/'.microtime(), $request->photo);
        }
        $data = [
            'name' => $request->name,
            'hospital' => $request->hospital,
            'department' => $request->department,
            'position' => $request->position,
            'cell' => $request->cell,
            'saler' => $request->saler,
            'sale_cell' => $request->sale_cell,
            'photo' => $photo,
            'uuid' => '',
            'status' => Doctors::status_valid
        ];
        $this->doctor->create($data);

        return $this->SuccessResponse();
    }

    public function update(DoctorEditRequest $request) {
        $data = [
            'saler' => $request->saler,
            'sale_cell' => $request->sale_cell
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
            $photo = Storage::disk('local')->putFile('photos/'.microtime(), $request->photo);
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

    public function bind($uuid) {

    }

}
