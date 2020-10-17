<?php
/**
 * WooCommerce REST API HTTP Client Exception
 *
 * @category HttpClient
 * @package  Automattic/WooCommerce
 */

namespace App\woocommerce\src\WooCommerce\HttpClient;

use App\woocommerce\src\WooCommerce\HttpClient\Request;
use App\woocommerce\src\WooCommerce\HttpClient\Response;

/**
 * REST API HTTP Client Exception class.
 *
 * @package Automattic/WooCommerce
 */
class HttpClientException extends \Exception
{
    /**
     * Request.
     *
     * @var Request
     */
    private $request;

    /**
     * Response.
     *
     * @var Response
     */
    private $response;

    /**
     * Initialize exception.
     *
     * @param string   $message  Error message.
     * @param int      $code     Error code.
     * @param Request  $request  Request data.
     * @param Response $response Response data.
     */
    public function __construct($message, $code, Request $request, Response $response)
    {
        parent::__construct($message, $code);

        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * Get request data.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get response data.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
