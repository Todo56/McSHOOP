<?php
class PayPal {
    public $base;
    public $logfile;
    public $auth;
    public function __construct(bool $sandbox)
    {
        $this->logfile = "../../log.txt";
        $this->base = ($sandbox === false) ? "https://api.paypal.com/v2" : "https://api.sandbox.paypal.com/v2";
        $this->auth = ($sandbox === false) ? "https://api.paypal.com/v1" : "https://api.sandbox.paypal.com/v1";
    }
    public function getToken(string $client, string $secret)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->auth . "/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $client.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if(empty($result))die("Error: No response.");
        else
        {
            $json = json_decode($result);
            curl_close($ch);
            return $json->access_token;
        }

    }
    public function checkPayment(string $id, string $token, string $url ){
        $ch = curl_init();
        $auth ="Authorization: Bearer {$token}";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = $auth;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result);
    }
}