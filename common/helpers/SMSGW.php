<?php
/**
 * Description of SMSGW
 *
 * @author Nguyen Chi Thuc
 * @email gthuc.nguyen@gmail.com
 * @skype ngoaho85
 */
namespace common\helpers;
use common\models\ContentPackage;
use common\models\Service;
use common\models\SmsMtTemplateContent;
use common\models\SmsMessage;
use common\models\Subscriber;
use common\models\SubscriberServiceAsm;
use common\models\User;
use common\models\UserPackageAsm;
use Yii;
use yii\base\Component;
use common\helpers\ResMessage;

/**
 * Class SMSGW
 * @property MyCurl $ch
 */
class SMSGW extends Component
{
    const SMS_TEMPLATE_PASSWORD_CHANGE = "Mat khau truy cap dich vu cua ban la: '%s'"; // %s la mat khau moi
    const MO_STATUS = "999: Receive message ok";

    /**
     * @param $mtParam MTParam
     * @return SmsMessage|null
     */
    public static function sendSMS($mtParam)
    {
        $params = (isset(Yii::$app->params['sms_proxy'])) ? Yii::$app->params['sms_proxy'] : [];

        $ch = new MyCurl();
        $sms_gw = (isset($params['url'])) ? $params['url'] : 'http://localhost';
        $username = (isset($params['username'])) ? $params['username'] : 'tester';
        $password = (isset($params['password'])) ? $params['password'] : 'foobar';
        $debug = (isset($params['debug'])) ? $params['debug'] : true;

        $destination = CUtils::validateMobile($mtParam->destination);
        $mt_status = '';
        if (empty($destination)) {
            Yii::error("Empty destination to send mt", 'SMSGW');
            return null;
        }

        $sp = $mtParam->getServiceProvider();
        if ($sp == null) {
            Yii::error("Empty service provider to send mt", 'SMSGW');
            return null;
        }
        if ($mtParam->brand) {
            $serviceSender = $sp->service_brand_name;
        } else {
            $serviceSender = $sp->service_sms_number;
        }

        $response = null;

        if ($debug) {
            $response = new \stdClass();
            $response->body = "0: Accept for delivery";
        } else {
            try {
                $response = $ch->get($sms_gw, array(
                    'username' => $username,
                    'password' => $password,
                    'smsc' => $sp->service_smsc_id,
                    'from' => $serviceSender,
                    'to' => $destination,
                    'text' => $mtParam->msg
                ));

            } catch (\Exception $e) {
                $mt_status = $e->getMessage();
            }
        }

        if ($response == null) {
            $mt_status = '400: Connections time out';
            Yii::info($ch->error(), 'SMSGW');
        } else {
            $mt_status = $response->body;
        }
        //TODO
        Yii::info("*** TDB ***: send SMS \"$mtParam->msg\" from " . $serviceSender . " to $destination status: $mt_status");
        /** @var  $subscriber Subscriber */
        $subscriber = Subscriber::findByMsisdn($destination, $sp->id, true);

        if ($mtParam->saveToDb && ($subscriber != null)) {
            $smsRec = new SmsMessage();
            $smsRec->source = $serviceSender;
            $smsRec->destination = $destination;
            $smsRec->message = $mtParam->getSmsToSave();
            $smsRec->mt_status = $mt_status;
            if($mtParam->moId){
                $smsRec->mo_id = $mtParam->moId;
            }
            $smsRec->type = SmsMessage::TYPE_MT;
            $smsRec->sent_at = time();
            $smsRec->subscriber_id = $subscriber->id;
            $smsRec->msisdn = $subscriber->msisdn;
            $smsRec->sms_template_id = $mtParam->mt_template_id;
            $smsRec->service_provider_id = $sp->id;
            $smsRec->save();
            return $smsRec;
        } else {
            $smsRec = new SmsMessage();
            $smsRec->status = $mt_status;
        }

        return $smsRec;
    }

    /**
     * @param $mtParam
     * @param $msgParam
     * @param null $service
     * @return mixed
     */
    public static function sendMT($mtParam, $msgParam, $service = null)
    {
        $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
        $mt_msg = $SmsMtTemplateContent['mt'];
        $web_content = $SmsMtTemplateContent['web_content'];
        $mt_template_id = $SmsMtTemplateContent['mt_template_id'];
        $mtParam->msg = $mt_msg;
        SMSGW::sendSMS($mtParam);
        return $web_content;
    }

    /**
     * @param $mtParam
     * @param $message
     * @return mixed
     */
    public static function resendMT($mtParam, $message)
    {
        $mtParam->msg = $message;
        $smsRec = SMSGW::sendSMS($mtParam);
        return $smsRec;
    }

}

?>
