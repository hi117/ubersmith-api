<?php

class Ubersmith
{
  private $endpoint, $auth_string, $arguments_to_send, $result, $request_url, $response;

  var $ubersmith_functions = [ 'client.service.list' => 'client.service.list' ];
  var $ubersmith_arguments = [ 'client.service.list' => [ 'client_id' ] ];

  function __construct($api_ip, $api_user, $api_pass)
  {
    $this->endpoint    = 'http://' . $ip . '/api/2.0/?';
    $this->curl_handle = curl_init();
    $this->auth_string = $api_user . ':' . $api_pass;

    curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, 			0);
    curl_setopt($this->handle, CURLOPT_SSL_VERIFYHOST, 			0);
    curl_setopt($this->handle, CURLOPT_HEADER,         			0);
    curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 			1);
    curl_setopt($this->handle, CURLOPT_USERPWD,        $this->auth_string); 
 }

  private function request()
  {
    if(strlen($this->url) < 1)
      throw new Exception("No method called.");

    curl_setopt($this->curl_handle, CURL_URL, $this->request_url);
    $this->result = curl_exec($this->curl_handle);
  }

  private function generate_url()
  {
    $this->request_url = $this->endpoint . 'method=' . $this->provided_method . "&";
    foreach($this->arguments_to_send as $key => $val)
    {
      $this->request_url .= $key . "=" . $val . "&";
    }
  }

  public function __call($method, $args)
  {
    $this->provided_method = $method;
    if(!$method)
      throw new Exception("Method does not exist");

    $this->provided_arguments = json_decode($args[0]);
    foreach($this->provided_arguments as $provided_argument => $provided_value)
    {
      if(array_search($provided_argument, $this->ubersmith_arguments[$this->provided_method]) !== FALSE)
        $this->arguments_to_send[$provided_argument] = $provided_value;
    }
    if(count($this->arguments_to_send) == 0)
      throw new Exception("No valid arguments provided.");

    $this->generate_url();

    return $this;
  }

  public function result()
  {
    # return json object
    return $this->result;
  }

}

# $api = new Ubersmith('', '', '');
# $api->list_services('{"client_id":1001}')->execute();
# print_r($api->result());
