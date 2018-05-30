<?php

require 'vendor/autoload.php';
$arr = [1,2,3];
$sms = new JSsoft\smsSdk\smsConfig($arr);
$sms->index();
$sms->test();