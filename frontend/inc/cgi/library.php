<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

class Library {

  var $basicUrl = "http://127.0.0.1:8282/api";


  function makeCurl ($url, $request) {

    $completeUrl = $this->basicUrl;
    $completeUrl .= $url;

    $curl = curl_init();
      curl_setopt_array(
        $curl, 
        array(
          CURLOPT_URL => $completeUrl,
          CURLOPT_CUSTOMREQUEST => $request,
          CURLOPT_PORT=>"8282",
          CURLOPT_RETURNTRANSFER=>true,
          CURLOPT_ENCODING=>"",
          CURLOPT_MAXREDIRS=>10,
          CURLOPT_TIMEOUT=>30,
          CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER => array("authorization: Basic YXBpdXNlcjpwYXNz","content-type: application/json")
        )
      );
      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);
      if ($err) {
       echo "cURL Error #:" . $err;
        $error = "Error while retrieving the URL: " . $url;
      } else {
       $data = json_decode($response);
      }

      return $data;
  }

}
?>