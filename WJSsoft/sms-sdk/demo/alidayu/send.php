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
$smsObj = new JSsoft\smsSdk\alidayu($param);
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