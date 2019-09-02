<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VerifycodeRepository;
use App\Models\Verifycode;
use Carbon\Carbon;

/**
 * Class VerifycodeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VerifycodeRepositoryEloquent extends BaseRepository implements VerifycodeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Verifycode::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function checkVerifyCode($type, $cell, $code, $valid_time){
        return $this->model->where('cell', $cell)
                    ->where('code', $code)
                    ->where('type', $type)
                    ->where('status', Verifycode::status_valid)
                    ->where('created_at', '>=', date('Y-m-d H:i:s', time() - $valid_time))
                    ->first();
    }

    public function usedVerifyCode($id){
        return $this->model->where('id', $id)
                    ->update(['status' => Verifycode::status_used, 'verify_at' => Carbon::now()]);
    }
    
}
