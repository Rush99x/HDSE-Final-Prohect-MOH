<?php

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Twilio\Rest\Client;

require __DIR__ . "/vendor/autoload.php";

$number = $_POST["number"];
$message = $_POST["message"];

if ($_POST["provider"] === "infobip") {

    $base_url = "j3zynv.api.infobip.com";
    $api_key = "16d58db2a820cef7b193652e8fb6e3d5-7db1e889-fe40-444e-bd5f-8e404e477743";

    $configuration = new Configuration(host: $base_url, apiKey: $api_key);

    $api = new SmsApi(config: $configuration);

    $destination = new SmsDestination(to: $number);

    $message = new SmsTextualMessage(
        destinations: [$destination],
        text: $message,
        from: "Ministry Of Health"
    );

    $request = new SmsAdvancedTextualRequest(messages: [$message]);

    $response = $api->sendSmsMessage($request);

} else {   // Twilio

    $account_id = "AC45bcde7711805566cb36f5c0c0c428fd";
    $auth_token = "5086a259dbf5c64d4094e95ffc24814a";

    $client = new Client($account_id, $auth_token);

    $twilio_number = "+16597582541";

    $client->messages->create(
        $number,
        [
            "from" => $twilio_number,
            "body" => $message
        ]
    );

}

echo "Message sent.";
