<?php
/**
 * Created by PhpStorm.
 * User: iamjiangshui
 * Date: 2018/6/1
 * Time: 10:08
 */
require_once dirname(__DIR__) . '/common.php';
/**
 * accessKeyId      您阿里大于的 accessKeyId
 * accessKeySecret      您阿里大于的 accessKeySecret
 */
$param = array(
    'accessKeyId'=>'LTAIC6lV6wHtZxmF', 'accessKeySecret'=>'qrGwrLtwBhKZr5MZstjAg5J5ibPQxf'
);
$msgObj = new WJSsoft\smsSdk\alidayuMsg($param);
echo "消息接口查阅短信状态报告返回结果:\n";
$msgObj->receiveMsg(
// 消息类型，SmsReport: 短信状态报告
    'SmsReport',
    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
    'Alicom-Queue-xxxxxxxx-SmsReport', function($message) {
    print_r($message);
    return false;
});
echo "消息接口查阅短信服务上行返回结果:\n";
$msgObj->receiveMsg(
// 消息类型，SmsUp: 短信服务上行
    "SmsUp",
    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
    "Alicom-Queue-xxxxxxxx-SmsUp",
    /**
     * 回调
     * @param stdClass $message 消息数据
     * @return bool 返回true，则工具类自动删除已拉取的消息。返回false，消息不删除可以下次获取
     */
    function ($message) {
        print_r($message);
        return false;
    }
);


//建议直接在回调函数里面进行业务代码，若不这样选择直接把回调函数的内容返回出来。eg:
//$res = $msgObj->receiveMsg(
//// 消息类型，SmsReport: 短信状态报告
//    'SmsReport',
//    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
//    'Alicom-Queue-xxxxxxxx-SmsReport', function($message) {
//    return $message;
//});
//var_dump($res);