<?php
/**
 * Created by PhpStorm.
 * User: a7811
 * Date: 2018/8/4
 * Time: 21:50
 */
include_once 'vendor/autoload.php';
use \WJSsoft_sms\ali\sms;
/**
 * accessKeyId      您阿里大于的 accessKeyId
 * accessKeySecret      您阿里大于的 accessKeySecret
 */
$param = array(
    'accessKeyId'=>'LTAI5ww0W6nI7qXO', 'accessKeySecret'=>'vVR2QMWbcnA7lZdCVj3eZJjZkPwrPX'
);
$smsObj = new sms($param);
/**
 * phoneNumbers  array   索引数组   // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
 * signName     array    索引数组    必填:短信签名-支持不同的号码发送不同的短信签名，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
 * templateCode     string     // 必填:短信模板-可在短信控制台中找到, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
 * data    array   索引数组      可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
 *                  如果模板为“您验验证码为{$code}”，则传入 array('code'=>'1234')
 * upExtendCode     array   索引数组      // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段），该字段作用例如：通过查询接口查看用户回复的短信内容
 */
$info = array(
    'phoneNumbers'=>array('15283848215', '15196378118'),
    'signName'=>array('环宇科技网站管理系统', '环宇科技网站管理系统'),
    'templateCode'=>'SMS_119086466',
    'data'=>array(array('code'=>111), array('code'=>222)),
    'upExtendCode'=>''
);
$res = $smsObj->sendBatch($info);
var_dump($res);







