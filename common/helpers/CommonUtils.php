<?php
/**
 *
 * @author Nguyen Chi Thuc
 */

namespace common\helpers;

use common\models\SubscriberTransaction;
use Yii;

class CommonUtils
{
    public static function pre($content)
    {
        echo '<pre>';
        print_r($content);
        echo '</pre>';
        die;
    }

    public static function rrmdir($path)
    {
        $path = rtrim($path, '/') . '/';

        // Remove all child files and directories.
        $items = glob($path . '*');

        foreach ($items as $item) {
            is_dir($item) ? self::rrmdir($item) : unlink($item);
        }

        // Remove directory.
        rmdir($path);
    }

    public static function getListParent($item, &$result = [])
    {
        if ($item->parent === null) {
            return $result;
        } else {
            if (!in_array($item->parent->id, $result)) {
                $result[] = $item->parent->id;
                CommonUtils::getListParent($item->parent, $result);
            }
            return $result;
        }
    }

    public static function columnLabel($value, $data)
    {
        if (array_key_exists($value, $data)) {
            return $data[$value];
        }
        return $value;
    }

    public static function displayDate($ts, $format = "d/m/Y")
    {
        if (!$ts) return '';
        $date = new \DateTime("@$ts");
        return $date->format($format);
    }

    public static function displayDateTime($ts, $format = "d/m/Y , H:i:s")
    {
        if (!$ts) return '';
        $date = new \DateTime("@$ts");
        return $date->format($format);
    }

    public static function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    /**
     *
     * @param string $mobileNumber
     * @param int type format: 0: format 84xxx, 1: format 0xxxx, 2: format xxxx
     * @return String valid mobile
     */
    public static function validateMobile($mobileNumber, $typeFormat = 0)
    {
        $valid_number = '';

        // Remove string "+"
        $mobileNumber = str_replace('+84', '84', $mobileNumber);

        if (substr($mobileNumber, 0, 1) != '0') {
            if (substr($mobileNumber, 0, 2) != '84') {
                $mobileNumber = "0" . $mobileNumber;
            }
        }
        //TODO: for testing: dung so dung cua VMS goi qua charging test ko thanh cong
        if (preg_match('/^(84|0)(987878787)$/', $mobileNumber, $matches)) {
            return "84987878787";
        }

        if (preg_match('/^(84|0)(84|88|91|94|123|124|125|127|129)\d{7}$/', $mobileNumber, $matches)) {
            /**
             * $typeFormat == 0: 8491xxxxxx
             * $typeFormat == 1: 091xxxxxx
             * $typeFormat == 2: 91xxxxxx
             */
            if ($typeFormat == 0) {
                if ($matches[1] == '0' || $matches[1] == '') {
                    $valid_number = preg_replace('/^(0|)/', '84', $mobileNumber);
                } else {
                    $valid_number = $mobileNumber;
                }
            } else if ($typeFormat == 1) {
                if ($matches[1] == '84' || $matches[1] == '') {
                    $valid_number = preg_replace('/^(84|)/', '0', $mobileNumber);
                } else {
                    $valid_number = $mobileNumber;
                }
            } else if ($typeFormat == 2) {
                if ($matches[1] == '84' || $matches[1] == '0') {
                    $valid_number = preg_replace('/^(84|0)/', '', $mobileNumber);
                } else {
                    $valid_number = $mobileNumber;
                }
            }

        }
        return $valid_number;
    }

    public static function formatNumber($number)
    {
        return (new \yii\i18n\Formatter())->asInteger($number);
    }


    public static function getStringFromArray($arr)
    {
        $str = "";
        foreach ($arr as $item) {
            $str .= "$item,";
        }
        if ($str != "") {
            substr($str, 0, strlen($str) - 1);
        }
        return $str;
    }

    public static function getPlatform($channel)
    {
        switch ($channel) {
            case "API":
                return SubscriberTransaction::CHANNEL_TYPE_API_VNPT;
            case "SMS":
                return SubscriberTransaction::CHANNEL_TYPE_SMS;
            case "WEB":
                return SubscriberTransaction::CHANNEL_TYPE_WEB;
            case "WAP":
                return SubscriberTransaction::CHANNEL_TYPE_WAP;
            case "CLIENT":
                return SubscriberTransaction::CHANNEL_TYPE_ANDROID;
            case "SYSTEM":
                return SubscriberTransaction::CHANNEL_TYPE_SYSTEM;
            case "CSKH":
                return SubscriberTransaction::CHANNEL_TYPE_SYSTEM;
            default:
                return SubscriberTransaction::CHANNEL_TYPE_WEB;
        }
    }

    public static function get_vas_channel($channel)
    {
        switch ($channel) {
            case SubscriberTransaction::CHANNEL_TYPE_API_VNPT:
                return 'API';
            case SubscriberTransaction::CHANNEL_TYPE_SMS:
                return "SMS";
            case SubscriberTransaction::CHANNEL_TYPE_WEB:
                return 'WEB';
            case SubscriberTransaction::CHANNEL_TYPE_WAP:
                return 'WAP';
            case SubscriberTransaction::CHANNEL_TYPE_ANDROID:
                return "CLIENT";
            case SubscriberTransaction::CHANNEL_TYPE_SYSTEM:
                return "SYSTEM";
            default:
                return "WAP";
        }
    }

    public static function toTimeStamp($format, $date)
    {
        $date = \DateTime::createFromFormat($format, $date);
        if($date){
            return $date->getTimestamp();
        }
        return time();
    }
}
