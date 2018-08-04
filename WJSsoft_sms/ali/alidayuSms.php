<?php
/**
 * Created by PhpStorm.
 * User: iamjiangshui
 * Date: 2018/5/30
 * Time: 18:42
 */
namespace WJSsoft_sms\ali;
//调用阿里大鱼发送短信sdk
ini_set("display_errors", "on");
require_once __DIR__ . '/sdk/aliyun-dysms-php-sdk/api_sdk/vendor/autoload.php';
//阿里大鱼官方类
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
// 加载区域结点配置
Config::load();
class alidayuSms {
    static $acsClient = null;
    static $accessKeyId = null;//不能为空
    static $accessKeySecret = null;//不能为空

    public function __construct($param = array()) {
        try {
            if (!is_array($param)) {
                throw new \Exception('初始化参数必须为数组格式');
            }
            //粗略验证accessKeyId
            if (!isset($param['accessKeyId'])) {
                throw new \Exception('accessKeyId未设置，请检查');
            } else {
                if (empty($param['accessKeyId'])) {
                    throw new \Exception('accessKeyId不能为空');
                }
            }
            //粗略验证accessKeyId
            if (!isset($param['accessKeySecret'])) {
                throw new \Exception('accessKeySecret 未设置，请检查');
            } else {
                if (empty($param['accessKeySecret'])) {
                    throw new \Exception('accessKeySecret 不能为空');
                }
            }
            static::$accessKeyId = $param['accessKeyId'];
            static::$accessKeySecret = $param['accessKeySecret'];
        } catch (\Exception $e) {
            echo '<br />';
            echo '出错了: ' . $e->getMessage();
            echo '<br />';
            echo '发生错误文件为: ' . $e->getFile();
            echo '<br />';
            echo '错误的行号为: ' . $e->getLine();
            echo '<br />';
            exit;
        }
    }

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";
        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";
        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = static::$accessKeyId; // AccessKeyId
        $accessKeySecret = static::$accessKeySecret; // AccessKeySecret
        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";
        if (static::$acsClient == null) {
            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function send($info = array())
    {
        try {
            if (!is_array($info)) {
                throw new \Exception('信息参数必须为数组传参');
            }
            //过滤传值中的空格
            foreach ($info as $k => $v) {
                if (is_array($info[$k])) {
                    foreach ($info[$k] as $kk => $vv) {
                        $info[$k][$kk] = trim($info[$k][$kk]);
                    }
                } else {
                    $info[$k] = trim($info[$k]);
                }
            }
            //判断入参的值是否设置以及是否符合格式
            //必填，判断手机号
            if (!isset($info['PhoneNumbers'])) {
                throw new \Exception('PhoneNumbers 未设置，请检查');
            } else {
                if (empty($info['PhoneNumbers'])) {
                    throw new \Exception('PhoneNumbers 为必填项，不能为空');
                }
            }
            //必填，判断短信签名
            if (!isset($info['signName'])) {
                throw new \Exception('signName 未设置，请检查');
            } else {
                if (empty($info['signName'])) {
                    throw new \Exception('signName 为必填项，不能为空');
                }
            }
            //必填，判断短信模板
            if (!isset($info['templateCode'])) {
                throw new \Exception('templateCode 未设置，请检查');
            } else {
                if (empty($info['templateCode'])) {
                    throw new \Exception('templateCode 为必填项，不能为空');
                }
            }
            //选填，如果有data传进来，判断是否符合要求
            if (isset($info['data'])) {
                if (!is_array($info['data'])) {
                    throw new \Exception('如果设置data，data的键值必须为数组格式');
                }
            }
            //选填，如果有 upExtendCode 传进来，判断是否符合要求
            if (isset($info['upExtendCode'])) {
                if (strlen($info['upExtendCode']) > 7) {
                    throw new \Exception('选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）');
                }
            }
        } catch (\Exception $e) {
            echo '<br />';
            echo '出错了: ' . $e->getMessage();
            echo '<br />';
            echo '发生错误文件为: ' . $e->getFile();
            echo '<br />';
            echo '错误的行号为: ' . $e->getLine();
            echo '<br />';
            exit;
        }
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();
        //可选-启用https协议
        //$request->setProtocol("https");
        // 必填，设置短信接收号码
        $request->setPhoneNumbers(is_array($info['PhoneNumbers']) ? implode($info['PhoneNumbers']) : $info['PhoneNumbers']);
        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($info['signName']);
        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($info['templateCode']);
        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode((isset($info['data']) && !empty($info['data'])) ? $info['data'] : ''), JSON_UNESCAPED_UNICODE); // 短信模板中字段的值, JSON_UNESCAPED_UNICODE;
        // 可选，设置流水号
        $request->setOutId((isset($info['outId']) && !empty($info['outId'])) ? $info['outId'] : '');
        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode((isset($info['upExtendCode']) && !empty($info['upExtendCode'])) ? $info['upExtendCode'] : '');
        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);
        return $acsResponse;
    }

    /**
     * 批量发送短信
     * @return stdClass
     */
    public static function sendBatch($info = array())
    {
        try {
            if (!is_array($info)) {
                throw new \Exception('信息参数必须为数组传参');
            }
            //判断入参的值是否设置以及是否符合格式
            //必填，判断手机号
            if (!isset($info['phoneNumbers'])) {
                throw new \Exception('phoneNumbers 未设置，请检查');
            } else {
                if (empty($info['phoneNumbers'])) {
                    throw new \Exception('phoneNumbers 为必填项，不能为空');
                }
                if (!is_array($info['phoneNumbers'])) {
                    throw new \Exception('phoneNumbers 参数请传入数组格式');
                }
            }
            //必填，判断签名
            if (!isset($info['signName'])) {
                throw new \Exception('signName 未设置，请检查');
            } else {
                if (empty($info['signName'])) {
                    throw new \Exception('signName 为必填项，不能为空');
                }
                if (!is_array($info['signName'])) {
                    throw new \Exception('signName 参数请传入数组格式');
                }
            }
            //判断手机号的数量和短信签名的数量是否一致
            if (count($info['phoneNumbers']) !== count($info['signName'])) {
                throw new \Exception('手机号的数量（phoneNumbers）和短信签名的数量（signName）不相等');
            }
            ///必填，判断短信模板
            if (!isset($info['templateCode'])) {
                throw new \Exception('templateCode 未设置，请检查');
            } else {
                if (empty($info['templateCode'])) {
                    throw new \Exception('templateCode 为必填项，不能为空');
                }
            }
            //选填，判断发送数据,如果存在，必须为数组格式传参
            if (isset($info['data'])) {
                if (!is_array($info['data'])) {
                    throw new \Exception('data 参数请传入数组格式');
                }
                if (count($info['phoneNumbers']) !== count($info['data'])) {
                    throw new \Exception('手机号的数量（phoneNumbers）和发送数据的数量（data）不相等');
                }
            }
            //选填，如果有 upExtendCode 传进来，判断是否符合要求，必须为数组
            if (isset($info['upExtendCode'])) {
                if (!is_array($info['upExtendCode'])) {
                    throw new \Exception('upExtendCode 参数请传入数组格式');
                }
            }
        } catch (\Exception $e) {
            echo '<br />';
            echo '出错了: ' . $e->getMessage();
            echo '<br />';
            echo '发生错误文件为: ' . $e->getFile();
            echo '<br />';
            echo '错误的行号为: ' . $e->getLine();
            echo '<br />';
            exit;
        }
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendBatchSmsRequest();
        //可选-启用https协议
        //$request->setProtocol("https");
        // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumberJson(json_encode($info['phoneNumbers'], JSON_UNESCAPED_UNICODE));
        // 必填:短信签名-支持不同的号码发送不同的短信签名
        $request->setSignNameJson(json_encode($info['signName'], JSON_UNESCAPED_UNICODE));
        // 必填:短信模板-可在短信控制台中找到
        $request->setTemplateCode($info['templateCode']);
        // 必填:模板中的变量替换JSON串,如模板内容为"亲爱的${name},您的验证码为${code}"时,此处的值为
        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParamJson(json_encode((isset($info['data']) && !empty($info['data'])) ? $info['data'] : '', JSON_UNESCAPED_UNICODE));
        // 可选-上行短信扩展码(扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段)
        $request->setSmsUpExtendCodeJson((isset($info['upExtendCode']) && !empty($info['upExtendCode'])) ? $info['upExtendCode'] : '');
        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);
        return $acsResponse;
    }

    /**
     * 短信发送记录查询
     * @return stdClass
     */
    public static function querySendDetails($info = array()) {
        try{
            if (!is_array($info)) {
                throw new \Exception('信息参数必须为数组传参');
            }
            //判断入参的值是否设置以及是否符合格式
            //必填，判断手机号
            if (!isset($info['phoneNumber'])) {
                throw new \Exception('phoneNumber 未设置，请检查');
            } else {
                if (empty($info['phoneNumber'])) {
                    throw new \Exception('phoneNumber 为必填项，不能为空');
                }
            }
            //必填，判断发送日期
            if (!isset($info['sendDate'])) {
                throw new \Exception('sendDate 未设置，请检查');
            } else {
                if (empty($info['sendDate'])) {
                    throw new \Exception('sendDate 为必填项，不能为空');
                }
            }
            //必填，分页大小
            if (!isset($info['pageSize'])) {
                throw new \Exception('pageSize 未设置，请检查');
            } else {
                if (empty($info['pageSize'])) {
                    throw new \Exception('pageSize 为必填项，不能为空');
                }
            }
        } catch (\Exception $e) {
            echo '<br />';
            echo '出错了: ' . $e->getMessage();
            echo '<br />';
            echo '发生错误文件为: ' . $e->getFile();
            echo '<br />';
            echo '错误的行号为: ' . $e->getLine();
            echo '<br />';
            exit;
        }
        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();
        //可选-启用https协议
        //$request->setProtocol("https");
        // 必填，短信接收号码
        $request->setPhoneNumber($info['phoneNumber']);
        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate($info['sendDate']);
        // 必填，分页大小
        $request->setPageSize($info['pageSize']);
        // 必填，当前页码
        $request->setCurrentPage((isset($info['CurrentPage']) && !empty($info['CurrentPage'])) ? $info['CurrentPage'] : 1);
        // 选填，短信发送流水号
        $request->setBizId((isset($info['bizId']) && !empty($info['bizId'])) ? $info['bizId'] : '');
        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);
        return $acsResponse;
    }
}
