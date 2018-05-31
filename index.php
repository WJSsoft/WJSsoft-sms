<?php

require 'vendor/autoload.php';
$arr = array('accessKeyId'=>'LTAIC6lV6wHtZxmF', 'accessKeySecret'=>'qrGwrLtwBhKZr5MZstjAg5J5ibPQxf');
$sms = new JSsoft\smsSdk\alidayu($arr);
$info = array('phoneNumbers'=>array('15196378118'),
'signName'=>array('科技与创新部'),
'templateCode'=>'SMS_132401546',
'data'=>array(array('code'=>'5555'))
);
$res = $sms->querySendDetails();
echo json_encode(object_array($res));
function object_array($array)
{
   if(is_object($array))
   {
    $array = (array)$array;
   }
   if(is_array($array))
   {
    foreach($array as $key=>$value)
    {
     $array[$key] = object_array($value);
    }
   }
   return $array;
}