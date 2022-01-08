<?php
   $url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/clusters.csv";

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
$data = json_encode($final_data);
echo $data;
?>
