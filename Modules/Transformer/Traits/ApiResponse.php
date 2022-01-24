<?php

namespace Modules\Transformer\Traits;

use \Illuminate\Http\JsonResponse;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\Response;
use Modules\Transformer\Facades\FractalBuilder;

/**
 * Class ApiResponse
 * @package App\Traits
 */
trait ApiResponse
{

    /**
     * @var string
     */
    protected string $format = 'json';

    /**
     * Permite que classes filhas substituam o
     * código de status que é usado em sua API.
     *
     * @var array
     */
    protected array $codes = [
        'created' => 201,
        'deleted' => 200,
        'updated' => 204,
        'no_content' => 204,
        'invalid_request' => 400,
        'unsupported_response_type' => 400,
        'invalid_scope' => 400,
        'temporarily_unavailable' => 400,
        'invalid_grant' => 400,
        'invalid_credentials' => 400,
        'invalid_refresh' => 400,
        'no_data' => 400,
        'invalid_data' => 400,
        'access_denied' => 401,
        'unauthorized' => 401,
        'invalid_client' => 401,
        'forbidden' => 403,
        'resource_not_found' => 404,
        'not_acceptable' => 406,
        'resource_exists' => 409,
        'conflict' => 409,
        'resource_gone' => 410,
        'payload_too_large' => 413,
        'unsupported_media_type' => 415,
        'too_many_requests' => 429,
        'server_error' => 500,
        'unsupported_grant_type' => 501,
        'not_implemented' => 501,
    ];

    /**
     * @param mixed $data
     * @param int|null $status
     * @param string|null $message
     * @return JsonResponse
     */
    public function respond(?array $data, int $status = 200, ?string $message = null): JsonResponse
    {
        // Se os dados forem nulos e o código de status não for fornecido, saia e saia
        if ($data === null && $status === null) {
            $status = 404;

            // Crie a saída var aqui no caso de $ this->response([]);
            $output = null;
        } // Se os dados forem nulos, mas o status for fornecido, mantenha a saída vazia.
        elseif ($data === null && is_numeric($status)) {
            $output = null;
        } else {
            $status = empty($status) ? 200 : $status;
            $output = $data;
        }

        return match ($this->format) {
            default => response()->json(data: $output, status: $status, options: JSON_PRESERVE_ZERO_FRACTION)->setStatusCode(code: $status, text: $message),
        };
    }

    /**
     * @param $messages
     * @param int $status
     * @param string|null $code
     * @param string|null $customMessage
     * @return JsonResponse
     */
    public function fail($messages, int $status, ?string $code, ?string $customMessage): JsonResponse
    {
        if (!is_array($messages)) {
            $messages = ['error' => $messages];
        }

        $response = [
            'status' => $status,
            'error' => $code ?? $status,
            'messages' => $messages,
        ];

        return $this->respond(
            data: $response,
            status: $status,
            message: $customMessage
        );
    }

    /**
     * @param mixed       $data
     * @param string|null $message
     *
     * @return JsonResponse
     */
    public function respondCreated(mixed $data, string $message = null): JsonResponse
    {
        return $this->respond(
            data: $data,
            status: $this->codes['created'],
            message: $message ?? Response::$statusTexts[$this->codes['created']]
        );
    }

    /**
     * @param string|null $message
     *
     * @return JsonResponse
     */
    public function respondDeleted(string $message = null): JsonResponse
    {
        return $this->respond(
            data: null,
            status: $this->codes['deleted'],
            message: $message ?? Response::$statusTexts[$this->codes['deleted']]
        );
    }

    /**
     * @param mixed $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function respondUpdated(mixed $data, ?string $message = null): JsonResponse
    {
        return $this->respond(
            data: $data,
            status: $this->codes['updated'],
            message: $message ?? Response::$statusTexts[$this->codes['updated']]
        );
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondNoContent(string $message = 'No Content'): JsonResponse
    {
        return $this->respond(
            data: null,
            status: $this->codes['no_content'],
            message: $message
        );
    }

    /**
     * @param string|null $code
     * @param string|null $message
     * @return JsonResponse
     */
    public function failUnauthorized(?string $code, ?string $message): JsonResponse
    {
        return $this->fail(
            messages: 'Unauthorized',
            status: $this->codes['unauthorized'],
            code: $code,
            customMessage: $message ?? Response::$statusTexts[$this->codes['unauthorized']]
        );
    }

    /**
     * @param string|null $code
     * @param string|null $message
     * @return JsonResponse
     */
    public function failForbidden(?string $code = "403", ?string $message = ''): JsonResponse
    {
        return $this->fail(
            messages: 'Forbidden',
            status: $this->codes['forbidden'],
            code: $code,
            customMessage: $message ?? Response::$statusTexts[$this->codes['forbidden']]
        );
    }

    /**
     * @param string|null $code
     * @param string|null $message
     * @return JsonResponse
     */
    public function failNotFound(?string $code = null, ?string $message = null): JsonResponse
    {
        return $this->fail(
            messages: 'Not Found',
            status: $this->codes['resource_not_found'],
            code: $code,
            customMessage: $message ?? Response::$statusTexts[$this->codes['resource_not_found']]
        );
    }

    /**
     * @param string|array $description
     * @param string|null $code
     * @param string $message
     * @return JsonResponse
     */
    public function failValidationError(string|array $description = 'Bad Request', string $code = null, string $message = ''): JsonResponse
    {
        return $this->fail(
            messages: $description,
            status: $this->codes['invalid_data'],
            code: $code,
            customMessage: $message ?? Response::$statusTexts[$this->codes['invalid_data']]
        );
    }

    /**
     * @param string $description
     * @param string|null $code
     * @param string $message
     * @return JsonResponse
     */
    public function failServerError(string $description = 'Internal Server Error', string $code = null, string $message = ''): JsonResponse
    {
        return $this->fail(
            messages: $description,
            status: $this->codes['server_error'],
            code: $code,
            customMessage: $message ?? Response::$statusTexts[$this->codes['server_error']]
        );
    }

    /**
     * Transforma os dados para apresentação.
     *
     * @param                     $data
     * @param TransformerAbstract $transformer
     *
     * @return array
     */
    protected function transform($data, TransformerAbstract $transformer):array
    {
        return FractalBuilder::handle($data, $transformer)->toArray();
    }

    /**
     * @param                     $data
     * @param TransformerAbstract $transformer
     *
     * @return array
     */
    protected function payload($data, TransformerAbstract $transformer):array
    {
        return $this->transform($data, $transformer)['data'];
    }
}
