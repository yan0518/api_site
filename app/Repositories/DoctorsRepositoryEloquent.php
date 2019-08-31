<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DoctorsRepository;
use App\Models\Doctors;

/**
 * Class DoctorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DoctorsRepositoryEloquent extends BaseRepository implements DoctorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Doctors::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
