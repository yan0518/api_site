<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * Class Verifycode.
 *
 * @package namespace App\Models;
 */
class Verifycode extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'verifycode';

    protected $guarded = [];

    const status_delete = 0;
    const status_valid = 1;
    const status_used = 2;
    const status_disabled = 3;

}
