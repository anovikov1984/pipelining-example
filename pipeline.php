<?php

// create both cURL resources
$ch1 = curl_init();
$ch2 = curl_init();
$ch3 = curl_init();

$header = array("Accept: */*", "Connection: keep-alive", "Keep-Alive: 300", 'Accept-Encoding: gzip;q=1.0,deflate;q=0.6,identity;q=0.3');

// set URL and other appropriate options
curl_setopt($ch1, CURLOPT_HEADER, $header);
curl_setopt($ch1, CURLOPT_URL, 'http://pubsub.pubnub.com/publish/demo/demo/0/my_channel/0/"ONE"');
curl_setopt($ch2, CURLOPT_HEADER, $header);
curl_setopt($ch2, CURLOPT_URL, 'http://pubsub.pubnub.com/publish/demo/demo/0/my_channel/0/"TWO"');
curl_setopt($ch3, CURLOPT_HEADER, $header);
curl_setopt($ch3, CURLOPT_URL, 'http://pubsub.pubnub.com/publish/demo/demo/0/my_channel/0/"THREE"');

//create the multiple cURL handle
$mh = curl_multi_init();

echo curl_multi_setopt($mh, CURLMOPT_PIPELINING, 1);
echo curl_multi_setopt($mh, CURLMOPT_MAXCONNECTS, 4);

//add the two handles
curl_multi_add_handle($mh,$ch1);
curl_multi_add_handle($mh,$ch2);
curl_multi_add_handle($mh,$ch3);

$stillRunning = 0;

//execute the handles
do {
    $mrc = curl_multi_exec($mh, $stillRunning);
    curl_multi_select($mh);
} while ($stillRunning > 0);

curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_remove_handle($mh, $ch3);

curl_multi_close($mh);
