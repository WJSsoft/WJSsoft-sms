<?php


require 'vendor/autoload.php';
/**
 * accessKeyId      您阿里大于的 accessKeyId
 * accessKeySecret      您阿里大于的 accessKeySecret
 */
$param = array(
    'accessKeyId'=>'LTAIC6lV6wHtZxmF', 'accessKeySecret'=>'qrGwrLtwBhKZr5MZstjAg5J5ibPQxf'
);
$alidayuMsg = new WJSsoft\smsSdk\alidayuMsg($param);
$res = $alidayuMsg->receiveMsg(
    // 消息类型，SmsReport: 短信状态报告
    "SmsReport",
    // 在云通信页面开通相应业务消息后，就能在页面上获得对应的queueName
    "Alicom-Queue-1388389400056848-SmsReport",
    /**
     * 回调
     * @param stdClass $message 消息数据
     * @return bool 返回true，则工具类自动删除已拉取的消息。返回false，消息不删除可以下次获取
     */
    function ($message) {
    	return json_encode(json_decode(json_encode($message),TRUE));
    }
);






exit;
$smsObj = new WJSsoft\smsSdk\alidayuSms($param);
/**
 * phoneNumber  string      必填，设置短信接收号码
 * signName     string    必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
 * templateCode     string     // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
 * data    array     可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
 *                  如果模板为“您验验证码为{$code}”，则传入 array('code'=>'1234')
 * outId    string       // 可选，设置流水号
 * upExtendCode     string     // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段），该字段作用例如：通过查询接口查看用户回复的短信内容
 */
$info = array(
    'phoneNumber'=>'phoneNumber',
    'signName'=>'signName',
    'templateCode'=>'templateCode',
    'data'=>'data',
    'outId'=>'outId',
    'upExtendCode'=>'upExtendCode'
);
$res = $smsObj->send($info);
var_dump($res);





$info = array('phoneNumber'=>'15196378118',
'sendDate'=>date('Ymd'),
'pageSize'=>10,
);

$redis = new \Redis();
$redis->connect('127.0.0.1',6379);
$keys = $redis->keys('*');
var_dump($redis->exists('key_one'));
