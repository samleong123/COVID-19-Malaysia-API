<?php

$date_request = $_GET["date"];
if ($date_request == ""){
       $json = array("Status"=>"Fail","Message"=>"Did not provide query string - date. Please refer to https://covid-19.samsam123.name.my/api.html for more information.");
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
   echo (json_encode($json));
} else {
    if ($date_request == "all") {
        
        $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/cases_state.csv";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

      $column_name = array();

      $final_data = array();



      $data_array = array_map("str_getcsv", explode("\n", $resp));

      $labels = array_shift($data_array);

      foreach($labels as $label)
      {
        $column_name[] = $label;
      }

      $count = count($data_array) - 1;

      for($j = 0; $j < $count; $j++)
      {
        $data = array_combine($column_name, $data_array[$j]);

        $final_data[$j] = $data;
      }

     
      header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
      echo (json_encode($final_data));
        
    } else {
        if ($date_request == "latest") {
    $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/cases_state.csv";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

      $column_name = array();

      $final_data = array();



      $data_array = array_map("str_getcsv", explode("\n", $resp));

      $labels = array_shift($data_array);

      foreach($labels as $label)
      {
        $column_name[] = $label;
      }

      $count = count($data_array) - 1;

      for($j = 0; $j < $count; $j++)
      {
        $data = array_combine($column_name, $data_array[$j]);

        $final_data[$j] = $data;
      }

     
      header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
$data = array_chunk($final_data,16);
$count = count($data);
$latest_date_count = $count - 1;
$latest_date = $data[$latest_date_count];
     $state_request = $_GET["state"];
if (empty($state_request)) {
     header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($latest_date));
   
} else {
    $array_number = array_search($state_request, array_column($latest_date, "state"));
    $json_encode_date = json_encode($latest_date[$array_number]);
    $json_decode_date = json_decode($json_encode_date,true);
if ($json_decode_date["state"] !== $state_request) {
    
    
       $json = array("Status"=>"Fail","Message"=>"Could not find state provided! Please try again!");
       header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
   echo (json_encode($json));
} else {
 header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo json_encode($latest_date[$array_number]);
}
    
    
    

}





} else {
 $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/cases_state.csv";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

      $column_name = array();

      $final_data = array();



      $data_array = array_map("str_getcsv", explode("\n", $resp));

      $labels = array_shift($data_array);

      foreach($labels as $label)
      {
        $column_name[] = $label;
      }

      $count = count($data_array) - 1;

      for($j = 0; $j < $count; $j++)
      {
        $data = array_combine($column_name, $data_array[$j]);

        $final_data[$j] = $data;
      }

     
      header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
$data = array_chunk($final_data,16);
$count = count($data);
$latest_date_count = $count - 1;
$latest_date = $data[$latest_date_count][0]["date"];
$date1 = new DateTime($latest_date);
$date2 = new DateTime($date_request);
$diff = $date1->diff($date2);
$diff_day = $diff->days;
$requested_date_count = $latest_date_count - $diff_day;
$latest_date_data = $data[$requested_date_count];
$output_date_data = $latest_date_data[0]["date"];
if ($output_date_data !== $date_request){
     $json = array("Status"=>"Fail","Message"=>"Could not find date provided! Please try again! Please try after midnight if you wanted to retrieve the latest data!");
       header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
     echo (json_encode($json));
     
} else {
   $state_request = $_GET["state"];
if (empty($state_request)) {header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    echo (json_encode($latest_date_data)); 
} else {
    $array_number = array_search($state_request, array_column($latest_date_data, "state"));
   header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
    $final_results_state = json_encode($latest_date_data[$array_number]);
    $final_results_state_json = json_decode($final_results_state,true);
    if ($final_results_state_json["state"] !== $state_request)   {$json = array("Status"=>"Fail","Message"=>"Could not find state provided! Please try again!");
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
echo (json_encode($json));} else {  header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
  echo json_encode($latest_date_data[$array_number]);

}
  

}
}
}

}

}



?>
