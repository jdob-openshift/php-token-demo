<html>

 <head>
  <title>Red Hat OpenShift</title>
  <style>
    table, th, td {
      border: 1px solid #111111;
      border-collapse: collapse;
    } 
    th, td {
      padding: 5px;
      text-align: left;
    }
    h1 {
        font-family: "Open Sans", Helvetica, Arial, sans-serif;
    }
    body {
        background-color: #eeeeee;
        color: #222222;
        font-family: "Open Sans", Helvetica, Arial, sans-serif;
    }
    
  </style>
 </head>

 <body>   
   <h1>Red Hat OpenShift API Invocation Demo</h1>
   <br/>

<?php

# Only attempt to call if the user specified the controller

$url = "https://openshift.default.svc.cluster.local/oapi/v1/users/~";

# Read in the token and create the HTTP headers
$token_file = "/var/run/secrets/kubernetes.io/serviceaccount/token";
$f = fopen($token_file, "r");
$token = fread($f, filesize($token_file));
fclose($f);
$auth = "Authorization: Bearer $token";

# Configure and run curl
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $auth));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);

curl_close($curl);

# Display call and results to the page

$json = json_decode($result);
$formatted = json_encode($json, JSON_PRETTY_PRINT);

echo "Token: <code>$token</code>";
echo "<br/><br/>";
echo "URL: <code>$url</code>";
echo "<br/><br/>";
echo "Result:";
echo "<pre> $formatted </pre>";

?>

    <br/><br/>
    <img src="powered-transparent-black.png" alt="Powered by OpenShift"/>

  </body>
</html>
