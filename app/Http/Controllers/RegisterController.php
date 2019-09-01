<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DoctorAppException;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepositoryEloquent;
use Illuminate\View\View;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers\v1;
 */
class RegisterController extends Controller
{

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct()
    {
    }

    public function index()
    {
        return View('register');
    }

    public function succeed()
    {
        return View('registerSucceed');
    }
}
