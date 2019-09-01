<?php

namespace App\Http\Controllers;

use App\Repositories\PatientRepositoryEloquent;
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

    protected $patientRepository;

    /**
     * UsersController constructor.
     *
     * @param UsersRepositoryEloquent $repository
     */
    public function __construct(PatientRepositoryEloquent $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function index()
    {
        return View('register');
    }

    public function save(Request $request)
    {
        $this->patientRepository->create();
    }

    public function succeed()
    {
        return View('registerSucceed');
    }
}
