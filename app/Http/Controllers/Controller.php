<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * response the success
     * @param array $data
     * @param int $code
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function SuccessResponse($data=[], $code=1, $status_code=200){
        return \response()->json(compact('code','data'),$status_code, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * response the error
     * @param $code
     * @param string $error
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ErrorResponse($code, $error='', $status_code=400){
        return \response()->json(compact('code','error'),$status_code, [], JSON_UNESCAPED_UNICODE);
    }
}
