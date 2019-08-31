<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DoctorPatientsRepository;
use App\Models\DoctorPatients;

/**
 * Class DoctorPatientsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DoctorPatientsRepositoryEloquent extends BaseRepository implements DoctorPatientsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DoctorPatients::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
