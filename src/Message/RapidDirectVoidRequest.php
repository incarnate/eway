<?php
/**
 * eWAY Rapid Void Request
 */

namespace Omnipay\Eway\Message;

use Omnipay\Common\Http\ResponseParser;

class RapidDirectVoidRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        $data = array();
        $data['TransactionId'] = $this->getTransactionReference();

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getEndpointBase().'/CancelAuthorisation';
    }

    public function sendData($data)
    {
        // This request uses the REST endpoint and requires the JSON content type header
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint(),
            [
                'auth' => [
                    $this->getApiKey(),
                    $this->getPassword()
                ],
                'headers' => [
                    'content-type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]
        );

        return $this->response = new RapidResponse($this, ResponseParser::json($httpResponse));
    }
}
