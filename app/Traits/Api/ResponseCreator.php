<?php

namespace App\Traits\Api;

use Illuminate\Support\Arr;

trait ResponseCreator
{
    public function createResponse(bool $status, int $statusCode, string $message = null, $data = [], $errors = [])
    {
        return response()->json(
            [
                "status" => $status,
                "status-code" => $statusCode,
                "message" => $message,
                "data" => $data,
                "errors" => $errors
            ],
            $statusCode
        );
    }

    /**
     * @OA\Schema(
     *      schema="Response200",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="200"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="success"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      example="1"
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      example="10"
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseSuccess($data = [], $codeSuccess = 200)
    {
        return $this->createResponse(true, $codeSuccess, "success", $data);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseCreated201",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="201"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="created"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseCreated($data = [], $codeCreated = 201)
    {
        return $this->createResponse(true, $codeCreated, "created", $data);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseUpdate200",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="200"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="updated"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseUpdated($data = [], $codeUpdated = 200)
    {
        return $this->createResponse(true, $codeUpdated, "updated", $data);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseMultStatus207",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="207"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Multi Status"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      example="1"
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      example="10"
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseMultiStatus($data = [], $errors = [], $message = 'Multi Status', $statusCode = 207)
    {
        return $this->createResponse(true, $statusCode, $message, $data, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseDeleteStatus200",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="200"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="deleted"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseDeleted($data = [], $codeDeleted = 200)
    {
        return $this->createResponse(true, $codeDeleted, "deleted", $data);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseNotFoundStatus404",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="404"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Not found"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseNotFound($status = false, $statusCode = 404, $message = "Not found", $data = null, $errors = null)
    {
        return $this->createResponse($status, $statusCode, $message, $data, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseBadRequestStatus400",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="400"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *              example="Bad Request"
     *          )
     *      )
     * )
     */

    public function createResponseBadRequest($data = null, $errors = "Bad Request", int $statusCode = 400)
    {
        return $this->createResponse(false, $statusCode, "fail", $data, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseWarning409",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="409"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Warning"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseWarning($data = null, $errors = null)
    {
        return $this->createResponse(true, 409, "warning", $data, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseFail400",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="400"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseFail($errors = [], $statusCode = 400)
    {
        return $this->createResponse(false, $statusCode, "fail", [], $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseRequestFail400",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="400"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseFailRequest($errors = [], $statusCode = 400)
    {
        return $this->createResponse(false, $statusCode, "fail", [], $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseInternalError500",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="500"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */


    public function createResponseInternalError($errors = null, $showErrors = false)
    {
        return $this->createResponse(false, 500, "fail", [], ($showErrors ? $errors->getMessage() : []));
    }

    /**
     * @OA\Schema(
     *      schema="ResponseForbbidenStatus403",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="403"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *         type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          example="Forbbiden"
     *          )
     *      )
     * )
     */

    public function createResponseForbbiden()
    {
        return $this->createResponse(false, 403, "fail", [], "Forbbiden");
    }

    /**
     * @OA\Schema(
     *      schema="ResponseFailStatus422",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="422"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          example="Unprocessable Content"
     *          )
     *      )
     * )
     */

    public function createResponseUnprocessableContent($errors = "Unprocessable Content")
    {
        return $this->createResponse(false, 422, "fail", null, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseStatus401",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="401"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Unauthorized"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseUnauthorized($errors = "Unauthorized")
    {
        return $this->createResponse(false, 401, "fail", null, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseMethodNotAllowed405",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="405"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="Method Not Allowed"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     *      
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseMethodNotAllowed($errors = "Method Not Allowed")
    {
        return $this->createResponse(false, 405, "fail", null, $errors);
    }

    /**
     * @OA\Schema(
     *      schema="ResponseUnexpectedError500",
     *      type="object",
     * @OA\Property(
     *      property="status-code",
     *      type="integer",
     *      description="Status code",
     *      example="500"
     * ),
     * @OA\Property(
     *      property="message",
     *      type="string",
     *      description="Message",
     *      example="fail"
     * ),
     * @OA\Property(
     *      property="page",
     *      type="integer",
     *      description="Page",
     * ),
     * @OA\Property(
     *      property="per_page",
     *      type="integer",
     *      description="Per page",
     *      
     * ),
     * @OA\Property(
     *      property="data",
     *      type="array",
     *      description="Data",
     *      @OA\Items(
     *          type="object",
     *      )
     * ),
     * @OA\Property(
     *      property="errors",
     *      type="array",
     *      description="Errors",
     *      @OA\Items(
     *          type="object",
     *          )
     *      )
     * )
     */

    public function createResponseUnexpectedError($errors = 'Unexpected error')
    {
        return $this->createResponse(status: false, statusCode: 500, errors: $errors);
    }
}
