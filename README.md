# COVID-19-Malaysia-API
An API to convert CSV data from Ministry Of Health - Malaysia data into JSON file 

## Available Data 
1. Cases 
2. Deaths
3. Vaccination
4. Clusters

## Language 
Build with pure PHP script

## Instructions 
Please read [https://covid-19.samsam123.name.my/api.html](https://covid-19.samsam123.name.my/api.html) for more information.

## Local usage 
Requirement :
1. PHP 7.0 and above , 7.4 is recommended
2. Connected with Internet
3. Able to access Github 

Steps : 
1. Copy the 4 of the PHP file to ur webroot directory with PHP enabled.
2. Start using it now by reading the instructions [here](https://covid-19.samsam123.name.my/api.html).

Credit :
[MoH-Malaysia](https://github.com/MoH-Malaysia/covid19-public)
[https://www.webslesson.info/2020/10/how-to-convert-csv-to-json-in-php.html](https://www.webslesson.info/2020/10/how-to-convert-csv-to-json-in-php.html)

## Rate Limit
Requirement : 
1. Redis Installed with no forcing password authentication
2. Redis for PHP (Extension) Installed

Add code below to each PHP file before the original PHP code :
```
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


$max_calls_limit  = 30;
$time_period      = 30;
$total_user_calls = 0;

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $user_ip_address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $user_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $user_ip_address = $_SERVER['REMOTE_ADDR'];
}

if (!$redis->exists($user_ip_address)) {
    $redis->set($user_ip_address, 1);
    $redis->expire($user_ip_address, $time_period);
    $total_user_calls = 1;
} else {
    $redis->INCR($user_ip_address);
    $total_user_calls = $redis->get($user_ip_address);
    if ($total_user_calls > $max_calls_limit) {
   
            $json = array("Status"=>"Fail","Message"=>"Rate limit exceeded!","IP Address"=>$user_ip_address,"Total_Calls"=>$total_user_calls,"Period"=>$time_period);
       header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
     header('HTTP/1.1 429 Too Many Requests');
   echo (json_encode($json));
        exit();
    }
}
```
Place these code BEFORE the original PHP code 
Example :
````
<?php
[PLACE HERE THE RATE LIMIT CODE!]
$date_request = $_GET["date"];
if (empty($date_request)) {
   $json = array("Status"=>"Fail","Message"=>"Did not provide query string - date. Please refer to https://covid-19.samsam123.name.my/api.html for more information.");
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
   echo (json_encode($json)); ..........
?>
````
Final : 
````
<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


$max_calls_limit  = 30;
$time_period      = 30;
$total_user_calls = 0;

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $user_ip_address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $user_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $user_ip_address = $_SERVER['REMOTE_ADDR'];
}

if (!$redis->exists($user_ip_address)) {
    $redis->set($user_ip_address, 1);
    $redis->expire($user_ip_address, $time_period);
    $total_user_calls = 1;
} else {
    $redis->INCR($user_ip_address);
    $total_user_calls = $redis->get($user_ip_address);
    if ($total_user_calls > $max_calls_limit) {
   
            $json = array("Status"=>"Fail","Message"=>"Rate limit exceeded!","IP Address"=>$user_ip_address,"Total_Calls"=>$total_user_calls,"Period"=>$time_period);
       header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
     header('HTTP/1.1 429 Too Many Requests');
   echo (json_encode($json));
        exit();
    }
}
$date_request = $_GET["date"];
if (empty($date_request)) {
   $json = array("Status"=>"Fail","Message"=>"Did not provide query string - date. Please refer to https://covid-19.samsam123.name.my/api.html for more information.");
    header('Content-type: application/json');  header('Access-Control-Allow-Origin: *');
   echo (json_encode($json)); ..........
?>
````

The rate limit code is same as the rate limit section on [API section](https://covid-19.samsam123.name.my/api.html) </br>
Any IP Address that exceed 30 requests in 30 seconds will receive a ``` 429 Too Many Requests ``` and a JSON string contains ```IP Address``` and ```Total Call Requests in 30 seconds```.  </br>
The rate limit will be auto reset each 30 seconds.
