<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatUsersRepository;
use App\Models\WechatUsers;
use App\Models\Doctors;
use App\Models\DoctorPatients;

/**
 * Class WechatUsersRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WechatUsersRepositoryEloquent extends BaseRepository implements WechatUsersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatUsers::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getPatientList() {
        return WechatUsers::where('wechat_users.status', WechatUsers::status_valid)
            ->join('doctor_patients', function($join){
                    $join->on('doctor_patients.patient_id', 'wechat_users.id')
                        ->where('doctor_patients.status', DoctorPatients::status_valid);
            })
            ->join('doctors', function($join){
                $join->on('doctor_patients.doctor_id', 'doctors.id')
                    ->where('doctors.status', Doctors::status_valid);
            })->select(
                'wechat_users.id',
                'wechat_users.nickname',
                'wechat_users.cell',
                'doctors.name',
                'doctor_patients.created_at'
            )->get();
    }
}
