<?php
//session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('max_execution_time', 300);

include("library.php");

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

// echo "<pre>_POST:\n";
// print_r($_POST);
// echo "</pre>";
// 
// echo "<pre>_GET:\n";
// print_r($_GET);
// echo "</pre>";


function constructPostCallAndGetResponse($endpoint, $query, $xmlfilter) {
  global $xmlrequest;

  // Create the XML request to be POSTed
  $xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlrequest .= "<findItemsByKeywordsRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
  $xmlrequest .= "<keywords>";
  $xmlrequest .= $query;
  $xmlrequest .= "</keywords>\n";
  $xmlrequest .= $xmlfilter;
  $xmlrequest .= "<paginationInput>\n <entriesPerPage>1000</entriesPerPage>\n</paginationInput>\n";
  $xmlrequest .= "</findItemsByKeywordsRequest>";

  // Set up the HTTP headers
  $headers = array(
    'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
    'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
    'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
    'X-EBAY-SOA-GLOBAL-ID: EBAY-DE',
    'X-EBAY-SOA-SECURITY-APPNAME: AhmedAlA-RECHSMSC-PRD-68bbc5abd-b7b36a04',
    'Content-Type: text/xml;charset=utf-8',
  );

  $session  = curl_init($endpoint);                       // create a curl session
  curl_setopt($session, CURLOPT_POST, true);              // POST request type
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out

  $responsexml = curl_exec($session);                     // send the request
  curl_close($session);                                   // close the session
  return $responsexml;                                    // returns a string

}


// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';
$query = $_POST["type"];

// Create a PHP array of the item filters you want to use in your request
$filterarray =
  array(
    array(
    'name' => 'MaxPrice',
    'value' => $_POST["MaxPrice"],
    'paramName' => 'Currency',
    'paramValue' => 'EUR'),    
    array(
    'name' => 'MinPrice',
    'value' => $_POST["MinPrice"],
    'paramName' => 'Currency',
    'paramValue' => 'EUR')
    ,
    array(
    'name' => 'ListingType',
    'value' => array('AuctionWithBIN','FixedPrice','StoreInventory'),
    'paramName' => '',
    'paramValue' => ''),
  );

// Generates an XML snippet from the array of item filters
function buildXMLFilter ($filterarray) {
  global $xmlfilter;
  // Iterate through each filter in the array
  foreach ($filterarray as $itemfilter) {
    $xmlfilter .= "<itemFilter>\n";
    // Iterate through each key in the filter
    foreach($itemfilter as $key => $value) {
      if(is_array($value)) {
        // If value is an array, iterate through each array value
        foreach($value as $arrayval) {
          $xmlfilter .= " <$key>$arrayval</$key>\n";
        }
      }
      else {
        if($value != "") {
          $xmlfilter .= " <$key>$value</$key>\n";
        }
      }
    }
    $xmlfilter .= "</itemFilter>\n";
  }
  return "$xmlfilter";
} // End of buildXMLFilter function

// Build the item filter XML code
buildXMLFilter($filterarray);

// Construct the findItemsByKeywords POST call
// Load the call and capture the response returned by the eBay API
// the constructCallAndGetResponse function is defined below
$constructedCall = constructPostCallAndGetResponse($endpoint, $query, $xmlfilter);
$resp = simplexml_load_string($constructedCall);


// echo "endpoint: [" . $endpoint . "]";
// echo "query: [" . $query . "]";
// echo "xmlfilter: [" . $xmlfilter . "]";
// echo "constructedCall: [" . $constructedCall . "]";
// echo "resp: ["; print_r($resp); echo "]";

// echo "<pre>resp:\nk";
// print_r($resp);
// echo "</pre>";

// Check to see if the call was successful, else print an error
if ($resp->ack == "Success") {
  $results = '';  // Initialize the $results variable

  $items = Array();
  // Parse the desired information from the response
  foreach($resp->searchResult->item as $item) {

    if (isset($item->eekStatus)) {
	    if(
	    	//($item->primaryCategory->categoryId == $_POST["categoryId"] || $item->primaryCategory->categoryId == $_POST["categoryId_2"]) 
	    	//&& $item->condition->conditionId == "1000"
	    	//&& 
	    	($item->eekStatus == "A+++" || $item->eekStatus == "A++")
	    ) {
	      	$item->roi = random_int(1, 4) . " Year(s)";
	      	$item->saving = random_int(8, 33);
	      	$items[] = $item;
	    }
    } else {
	    //if(
	    	//($item->primaryCategory->categoryId == $_POST["categoryId"] || $item->primaryCategory->categoryId == $_POST["categoryId_2"])
	    	//&& $item->condition->conditionId == "1000"
	    	//&& ($item->eekStatus == "A+++" || $item->eekStatus == "A++")
	    //) {
	      	$item->roi = random_int(1, 4) . " Year(s)";
	      	$item->saving = random_int(8, 33);
	      	$items[] = $item;
	    }
    }

// echo "<pre>items:\nk";
// print_r($items);
// echo "</pre>";

//Keep only first 10
$firstXItems = array_slice($items, 0, 50);

//sleep(5);

echo json_encode($firstXItems); 

} else {  // If the response does not indicate 'Success,' print an error
  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
  $results .= "AppID for the Production environment.</h3>";
}

?>