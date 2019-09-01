<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WechatUsersRepository;
use App\Models\WechatUsers;

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
    
}
