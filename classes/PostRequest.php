<?php


namespace Jovana\SendInBlue;

use HTTP_Request2;
use HTTP_Request2_Exception;

class PostRequest
{
    protected $response;
    protected $body_element;

    public function __construct($email, $name, $surname)
    {
        $this->setBodyElements($email, $name, $surname);
        $this->postRequest();
    }

    protected function setBodyElements($email, $name, $surname) {
        $this->body_element = [
            "attributes" => [
                "FIRSTNAME" => $name,
                "LASTNAME" => $surname
            ],
            "updateEnabled" => false,
            "email" => $email
        ];
    }

    protected function postRequest() {
        $body_tag = json_encode($this->body_element);

        $request = new HTTP_Request2();
        $request->setUrl('https://api.sendinblue.com/v3/contacts');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => true
        ));
        $request->setHeader(array(
            "Accept: application/json",
            "Content-Type: application/json",
            "api-key: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"
        ));

        $request->setBody($body_tag);

        try {
            $response = $request->send();
            if ($response->getStatus() == 201) {
                $this->response = $response->getBody();
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function response() {
        return json_decode($this->response);
    }
}