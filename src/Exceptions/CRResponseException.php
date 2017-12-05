<?php
namespace CR\Exceptions;
use CR\Exceptions\CROtherException;
use CR\CRResponse;
use \Exception;

/**
 * CRResponseException.
 */
class CRResponseException extends CRSDKException
{
    /**
     * @var CRResponse The response that threw the exception.
     */
    protected $response;

    /**
     * @var array Decoded response.
     */
    protected $responseData;

    /**
     * Creates a CRResponseException.
     *
     * @param CRResponse     $response          The response that threw the exception.
     * @param CRSDKException $previousException The more detailed exception.
     */
    public function __construct(CRResponse $response, CRSDKException $previousException = null)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodedBody();

        $errorMessage = $this->get('message', 'Unknown error from API Response.');
        $errorCode = $this->get('error', -1);

        parent::__construct($errorMessage, $errorCode, $previousException);
    }

    /**
     * A factory for creating the appropriate exception based on the response from CR.
     *
     * @param CRResponse $response The response that threw the exception.
     *
     * @return CRResponseException
     */
    public static function create(CRResponse $response)
    {
        $data = $response->getDecodedBody();

        $code = null;
        $message = null;
        if (isset($data['error']) && $data['error'] !== false) {
            $code = -1;
            $message = isset($data['message']) ? $data['message'] : 'Unknown error from API.';
        }

        // Others
        return new static($response,new CROtherException($message, $code));
    }

    /**
     * Checks isset and returns that or a default value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    private function get($key, $default = null)
    {
        if (isset($this->responseData[$key])) {
            return $this->responseData[$key];
        }

        return $default;
    }

    /**
     * Returns the HTTP status code.
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->response->getHttpStatusCode();
    }

    /**
     * Returns the error type.
     *
     * @return string
     */
    public function getErrorType()
    {
        return $this->get('type', '');
    }

    /**
     * Returns the raw response used to create the exception.
     *
     * @return string
     */
    public function getRawResponse()
    {
        return $this->response->getBody();
    }

    /**
     * Returns the decoded response used to create the exception.
     *
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * Returns the response entity used to create the exception.
     *
     * @return CRResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
