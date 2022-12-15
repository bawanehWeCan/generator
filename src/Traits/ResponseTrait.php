<?php

namespace BawanehWeCan\Generator\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{

    /**
     * Return Error function
     *
     * @param string $msg
     * @return Response
     */
    public function returnError($msg)
    {
        return response()->json([
            'status' => false,
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => $msg,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Return Success Message function
     *
     * @param string $msg
     * @return Response
     */
    public function returnSuccessMessage($msg = '')
    {
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'msg' => $msg,
        ], Response::HTTP_OK);
    }

    /**
     * Return Data function
     *
     * @param string $key
     * @param array $value
     * @param string $msg
     * @return Response
     */
    public function returnData($key, $value, $msg = '')
    {
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'msg' => $msg,
            $key => $value,
        ], Response::HTTP_OK);
    }

    /**
     * Return Validation Errors function
     *
     * @param Validator $validator
     * @return Response
     */
    public function returnValidationError($validator, $code = null, $errors = null)
    {
        if ($code == null) {
            $code = $this->returnCodeAccordingToInput($validator);
        }

        return response()->json([
            'status' => false,
            'code' => $this->returnCodeAccordingToInput($validator),
            'msg' => __('Please check the following errors'),
            'errors'=>$errors,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCodeValidation($inputs[0]);

        return $code;
    }

}
