<?php
/**
 * Created by PhpStorm.
 * User: Jamal
 * Date: 9/20/2018
 * Time: 7:21 PM
 */

namespace pgsavis\payamsms;


use pgsavis\payamsms\Exceptions\RequestException;

class payamsms{
    protected $BASEURL;
    protected $APIKEY;
    protected $PASS;
    protected $FROM;
    public function __construct(){
        $this->BASEURL = config('payamsms.BASEURL');
        $this->APIKEY = config('payamsms.APIKEY');
        $this->PASS = config('payamsms.PASS');
        $this->FROM = config('payamsms.FROM');
    }

    public function getCustomerBalance(){
        $jsonResponse = $this->sendRequest('balance', array('apikey'=>$this->APIKEY));
        return $jsonResponse['balance'];
    }

    public function receivingIncomingMessages(){
        $jsonResponse = $this->sendRequest('receive', array(
            'apikey'=> $this->APIKEY,
            'shortNumber'=>$this->FROM
        ));
        return $jsonResponse['messages'];
    }

    public function sendNewMessage($to,$message){
        $jsonResponse = $this->sendRequest('send', array(
            'apikey' => $this->APIKEY,
            'from'   =>$this->FROM,
            'to'     =>$to,
            'content'=>$message
        ), 'POST');
        if ($jsonResponse['status'] == 0) {
            return $jsonResponse['id'];
        } else {
            return false;
        }
    }

    public function getMessageStatus($messageIds){

        $jsonResponse = $this->sendRequest('status', array(
            'apikey' => $this->APIKEY,
            'messageId' => $messageIds
        ));
        return $jsonResponse;
    }


    public function sendMultipleMessages($to=[],$message=[]){
        $jsonResponse = $this->sendRequest('sendMultiple', array(
            'apikey' => $this->APIKEY,
            'from'   => $this->FROM,
            'to'     => $to,
            'content'=> $message
        ), 'POST');
        if ($jsonResponse['status'] == 0) {
            return $jsonResponse['id'];
        }
        else {
            return false;
        }
    }


    private function sendRequest($uri, $params=array(), $method='GET')
    {
        $method = strtoupper($method);
        $streamOptions = array(
            'http' => array(
                'method' => $method,
            )
        );
        $requestUri = $this->BASEURL.$uri;
        if (is_array($params)) {
            $params = http_build_query($params);
        }
        if ($method == 'POST') {
            $streamOptions['http']['content'] = $params;
            $streamOptions['http']['header']  = "Content-Type: application/x-www-form-urlencoded\r\n";
        } else {
            $requestUri .= '?' . $params;
        }
        $stream = stream_context_create($streamOptions);
        $response = file_get_contents($requestUri, false, $stream);
        if ($response) {
            $jsonResponse = json_decode($response, true);
            return $jsonResponse;
        }
        throw new RequestException("Request failed: $requestUri");
    }
}