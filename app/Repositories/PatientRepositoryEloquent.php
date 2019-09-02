<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PatientRepository;
use App\Models\Patient;
use App\Models\Doctors;
use App\Models\DoctorPatients;

/**
 * Class PatientRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PatientRepositoryEloquent extends BaseRepository implements PatientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Patient::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getPatientList($pageNum, $pageSize, $params) {
        $query = Patient::where('patients.status', Patient::status_valid)
            ->join('doctor_patients', function($join){
                    $join->on('doctor_patients.patient_id', 'patients.id')
                        ->where('doctor_patients.status', DoctorPatients::status_valid);
            })
            ->join('doctors', function($join){
                $join->on('doctor_patients.doctor_id', 'doctors.id')
                    ->where('doctors.status', Doctors::status_valid);
            });
        if($params) {
            $query->where('patients.name', 'like', '%'.$params.'%')
                    ->orWhere('patients.cell', $params);
        }
        $query->select(
            'patients.id',
            'patients.name',
            'patients.cell',
            'doctors.name as doctor_name',
            'doctor_patients.created_at'
        );
        $total = $query->count();
        $list = $query->offset(($pageNum - 1) * $pageSize)
            ->limit($pageSize)
            ->get();
        return [
            'total' => $total,
            'list' => $list
        ];
    }
    
}
