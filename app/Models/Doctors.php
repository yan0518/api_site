<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Doctors.
 *
 * @package namespace App\Models;
 */
class Doctors extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const status_invalid = 0;
    const status_valid = 1;

    const position = [
        1 => '主任医师',
        2 => '副主任医师'
    ];

    const deparmentList = [
        1 => '高血压',
        2 => '外科'
    ];

}
