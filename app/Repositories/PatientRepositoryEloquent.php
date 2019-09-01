<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\patientRepository;
use App\Models\Patient;
use App\Validators\PatientValidator;

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
    
}
