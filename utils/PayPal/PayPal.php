<?php
class PayPal {
    public $base;
    public $logfile;
    public function __construct(bool $sandbox)
    {
        $this->logfile = "../../log.txt";
        $this->base = ($sandbox === false) ? "https://api.paypal.com/v2" : "https://api.sandbox.paypal.com/v2";
    }
    public function getToken(string $client, string $secret)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base . "/oauth2/token");
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
            return $json->access_token . ":" . $json->token_type;
        }

    }
    public function checkPayment(string $id, string $token){
        $ch = curl_init();
        $tk = explode(":", $token);
        $url = $this->base . "/checkout/orders/$id";
        $auth ="Authorization: {$tk[1]} {$tk[0]}";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, array(
            "Content-Type: application/json",
            $auth
        ));
        $result = curl_exec($ch);

        if(empty($result))return false;
        else
        {
            $file = file_get_contents("../../log.txt");
            file_put_contents("../../log.txt", $file . "\n" . $result . $auth);
            $json = json_decode($result);
            curl_close($ch);
            return $json;
        }
    }
}