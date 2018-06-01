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
 * phoneNumber  string     // 必填，短信接收号码
 * sendDate     string  eg: 20181212       // 必填，短信发送日期，格式Ymd，支持近30天记录查询
 * pageSize     int    建议10     // 必填，分页大小
 * bizId    string      选填，短信发送流水号
 */
$info = array(
    'phoneNumber'=>'phoneNumber',
    'sendDate'=>'sendDate',
    'pageSize'=>'pageSize',
    'bizId'=>'bizId'
);
$res = $smsObj->sendBatch($info);
var_dump($res);