<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

class Library {

  var $basicUrl = "http://localhost:8282/api";

  function makeCurl ($url, $request, $fields = NULL) {

    // echo "<pre>fields:\n";
    // print_r($fields);
    // echo "</pre>";

    $completeUrl = $this->basicUrl;
    $completeUrl .= $url;

    //convert array to {"key":"value","key":"value",...}
    $postFields = "{\"";
    $postFields .= urldecode(str_replace('=', '":"', http_build_query($fields, null, '", "')));
    $postFields .= "\"}";

    // echo "<pre>postFields:\n";
    // print_r($postFields);
    // echo "</pre>";

    $curl = curl_init();
      curl_setopt_array(
        $curl, 
        array(
          CURLOPT_URL => $completeUrl,
          CURLOPT_CUSTOMREQUEST => $request,
          CURLOPT_POSTFIELDS => $postFields,
          CURLOPT_PORT=>"8282",
          CURLOPT_RETURNTRANSFER=>true,
          CURLOPT_ENCODING=>"",
          CURLOPT_MAXREDIRS=>10,
          CURLOPT_TIMEOUT=>30,
          CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER => array("authorization: Basic YXBpdXNlcjpwYXNz","content-type: application/json")
        )
      );

// curl_setopt($curl, CURLOPT_VERBOSE, true);
// $verbose = fopen('php://temp', 'w+');
// curl_setopt($curl, CURLOPT_STDERR, $verbose);


// echo "<pre>curl:\n";
// print_r($curl);
// echo "</pre>";

      $response = curl_exec($curl);
      $err = curl_error($curl);

// if ($response === FALSE) {
//     printf("cUrl error (#%d): %s<br>\n", curl_errno($curl), htmlspecialchars(curl_error($curl)));
// }
// rewind($verbose);
// $verboseLog = stream_get_contents($verbose);
// echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";


      curl_close($curl);
      if ($err) {
       echo "cURL Error #:" . $err;
        $error = "Error while retrieving the URL: " . $url;
      } else {
       $data = json_decode($response);
      }

      return $data;
  }

function calculateWithPercentage ($value, $percentage) {

        $percentageValue = ($percentage / 100) * $value;

        $min = $value + $percentageValue;
        $max = $value - $percentageValue;

        $scale = pow(10, 2);
        $random = rand($min * $scale, $max * $scale) / $scale;

        $v = $random % 2 == 0 ? 1 : 2;

        $finalRet = $random * 2;

        return $finalRet <= 0 ? 0 : $finalRet;

}

function adjustValue($value, $kwh_watt, $to) {

  //frig: 278 Kwh, 157 Watt
  //tv:    96 Kwh,  69 Watt
  //lamp:   6 Kwh,   2 Watt

  $percentage = 20;

  switch ($to) {
    case 'tv':
      if($kwh_watt == "kwh") {
        //convert frig kwh to tv
        $newValue = $value * (96 / 278);
        return self::calculateWithPercentage($newValue, $percentage);
      }

      if($kwh_watt == "watts") {
        //convert frig watt to tv
        return $value * (69 / 157);
      } 

      if($kwh_watt == "amps") {
        //convert frig amps to tv
        return $value * (69 / 157);
      } 
      break;
    
    case 'lamp':
      if($kwh_watt == "kwh") {
        //convert frig kwh to lamp
        return $value * (56 / 278);
      }

      if($kwh_watt == "watts") {
        //convert frig watt to lamp
        return $value * (52 / 157);
      } 

      if($kwh_watt == "amps") {
        //convert frig amps to lamp
        return $value * (52 / 157);
      }       
      break;

  }
}

    // function to convert string and print
    function convertString ($date)
    {
        $pattern = "d M Y H:i";

        $sec = strtotime($date);
        $date = date($pattern, $sec);
        $date = $date;
        return $date;
    }

    function sortArray ($oldArray) {
      foreach ($oldArray as $key => $value) {
        $object = new stdClass();
        $object->concatedDateTimeWithoutdashes = str_replace("-", "", $value->concatedDateTime);
        $object->concatedDateTime = $value->concatedDateTime;
        $object->avgmeasurment = $value->avgmeasurment;
        $object->counter = $value->counter;
        $newArray[] = $object;  
      }
      sort($newArray);
      return $newArray;
    }    
     



}
?>