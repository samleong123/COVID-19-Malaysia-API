<?php
$date_request = $_GET["date"];
if (empty($date_request)) {
   $json = array("Status"=>"Fail","Message"=>"Did not provide date according to format : YYYY-MM-DD");
    header('Content-type: application/json');
   echo (json_encode($json));
   
} else {
if ($date_request == "all"){
   $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/deaths_malaysia.csv";

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

     
      header('Content-type: application/json');
$data = json_encode($final_data);
echo $data;
} else {
if ($date_request == "latest"){
   $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/deaths_malaysia.csv";

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

     
      header('Content-type: application/json');
$data1 = json_encode($final_data);


$data2 = json_decode($data1);
$latest1 = count($data2);
$latest = $latest1 - 1;
$datedata = $data2[$latest];
echo(json_encode($datedata));
} else {
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/deaths_malaysia.csv";

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

     
      header('Content-type: application/json');
$data = json_encode($final_data);

   
$array_number = array_search($date_request, array_column(json_decode($data, true), "date"));
if ($array_number == "") {
      $json = array("Status"=>"Fail","Message"=>"Could not find date provided! Please try again! Please try after midnight if you wanted to retrieve the latest data!");
       header('Content-type: application/json');
   echo (json_encode($json));
} else {
$data2 = json_decode($data);
$datedata = $data2[$array_number];
echo(json_encode($datedata));
    
}
      exit;
}
}
}