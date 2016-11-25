<?php
namespace common\helpers;

use common\models\Service;
use common\models\SmsMtTemplateContent;
use common\models\Subscriber;

/**
 * Show cac kich ban message tuong ung cua he thong
 * Dc dung de tra ve SMS MT hoac message Response ve web/app theo tung truong hop
 * Khi muon them 1 kich ban thi can lam cac buoc sau
 * 1: Khai bao them constant
 * 2: Viet ham de xu ly cho function do
 * 3: chay command: ./yii port-mt/port de add them sms template vao db
 */
class ResMessage
{

    const DANG_KY_LAN_DAU_THANH_CONG_CHUA_CO_TAI_KHOAN = 'DANG_KY_THANH_CONG_LAN_DAU_CHUA_CO_TAI_KHOAN';
    const DANG_KY_LAN_DAU_THANH_CONG = 'DANG_KY_LAN_DAU_THANH_CONG_DA_CO_TAI_KHOAN';
    const DANG_KY_LAI_THANH_CONG = 'DANG_KY_LAN_SAU_DA_CO_TAI_KHOAN';
    const DANG_KY_LOI_TRUNG_GOI_CUOC = 'DANG_KY_THAT_BAI_DO_DANG_SU_DUNG_GOI';
    const DANG_KY_LOI_TRUNG_GOI_CUOC_CUNG_NHOM = 'DANG_KY_THAT_BAI_DO_DANG_SU_DUNG_GOI_CUNG_NHOM';
    const DANG_KY_LOI_DO_LOI_HE_THONG = 'DANG_KY_THAT_BAI_DO_LOI_HE_THONG';
    const DANG_KY_LOI_KHONG_DU_TIEN = 'DANG_KY_THAT_BAI_DO_KHONG_DU_TIEN';

    const HUY_GOI_CUOC_THANH_CONG = 'HUY_THANH_CONG';
    const HUY_GOI_CHUA_THANH_CONG = 'HUY_GOI_CHUA_THANH_CONG';
    const HUY_GOI_CUOC_LOI_CHUA_DANG_KY = 'HUY_THAT_BAI_DO_CHUA_DANG_KY';
    const HUY_GOI_CUOC_LOI_DO_LOI_HE_THONG = 'HUY_THAT_BAI_DO_LOI_HE_THONG';
    const HUY_GOI_DO_GIA_HAN_KHONG_THANH_CONG = 'HUY_GOI_DO_GIA_HAN_KHONG_THANH_CONG';
    const LOI_SAI_CU_PHAP = 'SAI_CU_PHAP';
    const LOI_HE_THONG = 'LOI_HE_THONG';
    const TRO_GIUP = 'HUONG_DAN';
    const GIA_HAN_THANH_CONG = 'GIA_HAN_THANH_CONG';
    const THONG_BAO_TRUOC_KHI_GIA_HAN = 'THONG_BAO_TRUOC_KHI_GIA_HAN';

    const LAY_LAI_MAT_KHAU = 'LAY_LAI_MAT_KHAU';

    public static function listCodeNameRequireMO()
    {
        return [
            self::DANG_KY_LAN_DAU_THANH_CONG,
            self::DANG_KY_LAI_THANH_CONG,

            self::DANG_KY_LOI_TRUNG_GOI_CUOC,
            self::DANG_KY_LOI_KHONG_DU_TIEN,

            self::HUY_GOI_CUOC_THANH_CONG,
            self::HUY_GOI_CUOC_LOI_CHUA_DANG_KY,

            self::TRO_GIUP,

        ];
    }

    public static function listCodeNameRequireService()
    {
        return [
            self::GIA_HAN_THANH_CONG,
            self::HUY_GOI_DO_GIA_HAN_KHONG_THANH_CONG
        ];
    }

    /**
     * Lay message hien thi cho truong hop dang ky lan dau thanh cong
     * Dong thoi co the cho phep gui sms di hay ko
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date //Date format d-m-Y
     * @param bool $send_sms
     * @param bool $first
     * @param $mo_id
     * @return mixed|string
     */
    public static function firstRegisterSuccess($subscriber, $service, $expired_date, $send_sms = true, $first = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        if ($first) {
            $mtParam->code_name = ResMessage::DANG_KY_LAN_DAU_THANH_CONG_CHUA_CO_TAI_KHOAN;
        } else {
            $mtParam->code_name = ResMessage::DANG_KY_LAN_DAU_THANH_CONG;
        }

        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message hien thi cho truong hop dang ky lan dau chua co tai khoan thanh cong
     * Dong thoi co the cho phep gui sms di hay ko
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date //Date format d-m-Y
     * @param bool $send_sms
     * @return mixed|string
     */
    public static function firstRegisterNoAccountSuccess($subscriber, $service, $password, $expired_date, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LAN_DAU_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_PASSWORD => $password,
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message hien thi cho truong hop dang ky thanh cong lan thu 2 tro di
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date
     * @param $mo_id
     * @param bool $send_sms
     * @return mixed|string
     */
    public static function registerSuccess($subscriber, $service, $expired_date, $send_sms = true, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LAI_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Thong bao khi dang ky ko thanh cong do trung lap goi cuoc
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function registerFailByDuplicate($subscriber, $service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LOI_TRUNG_GOI_CUOC;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Thong bao khi dang ky ko thanh cong do trung lap goi cuoc trong group
     * @param Subscriber $subscriber
     * @param Service $used_service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function registerFailByDuplicateGroup($subscriber, $used_service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LOI_TRUNG_GOI_CUOC_CUNG_NHOM;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $used_service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $used_service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $used_service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Thong bao dang ky khong thanh cong do thieu tien
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function registerFailByMoney($subscriber, $service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LOI_KHONG_DU_TIEN;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Thong bao dang ky khong thanh cong do loi he thong
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function registerFailBySystemError($subscriber, $service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::DANG_KY_LOI_DO_LOI_HE_THONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Thong bao dang ky khong thanh cong do loi he thong
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function cancelFailBySystemError($subscriber, $service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::HUY_GOI_CUOC_LOI_DO_LOI_HE_THONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function cancelServiceSuccess($subscriber, $service, $send_sms = true, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::HUY_GOI_CUOC_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_MSISDN => $subscriber->msisdn,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay thong tin hien thi khi huy goi cuoc ko thanh cong
     * @param Subscriber $subscriber
     * @param bool $send_sms
     * @return mixed
     */
    public static function cancelServiceFail($subscriber, $send_sms = false)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::HUY_GOI_CHUA_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_MSISDN => $subscriber->msisdn,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message hien thi khi huy goi cuoc ko thanh cong do chua dang ky goi cuoc
     * @param Subscriber $subscriber
     * @param Service $service
     * @param bool $send_sms
     * @param $mo_id
     * @return mixed
     */
    public static function cancelFailByNotRegister($subscriber, $service, $send_sms = false, $mo_id = 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::HUY_GOI_CUOC_LOI_CHUA_DANG_KY;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $mtParam->moId = $mo_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message khi gia han thanh cong
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date
     * @param bool $send_sms
     * @return mixed
     */
    public static function extendSuccess($subscriber, $service, $expired_date, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::GIA_HAN_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message khi truoc khi gia han
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date
     * @param bool $send_sms
     * @return mixed
     */
    public static function extendBefore($subscriber, $service, $expired_date, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::THONG_BAO_TRUOC_KHI_GIA_HAN;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message khi huy goi cuoc do gia han ko thanh cong
     * @param Subscriber $subscriber
     * @param Service $service
     * @param $expired_date
     * @param bool $send_sms
     * @return mixed
     */
    public static function cancelByExtendFail($subscriber, $service, $expired_date, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::HUY_GOI_DO_GIA_HAN_KHONG_THANH_CONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_MSISDN => $subscriber->msisdn,
            ResMtParams::PARAM_SERVICE_PRICE => intval($service->price),
            ResMtParams::PARAM_SERVICE_NAME => $service->display_name,
            ResMtParams::PARAM_SERVICE_EXPIRED_DATE => $expired_date,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam, $service);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam, $service);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message khi lay lai mat khau
     * @param $subscriber
     * @param $password
     * @param bool $send_sms
     * @return mixed
     */
    public static function resetPassword($subscriber, $password, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::LAY_LAI_MAT_KHAU;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;

        $msgParam = [
            ResMtParams::PARAM_PASSWORD => $password,
        ];

        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, $msgParam);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, $msgParam);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    /**
     * Lay message tro giup
     * @param $msisdn
     * @param $sp_id
     * @param $mo_id
     * @param bool $send_sms
     * @return mixed
     */
    public static function help($msisdn, $sp_id, $mo_id, $send_sms = true)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::TRO_GIUP;
        $mtParam->destination = $msisdn;
        $mtParam->sp_id = $sp_id;
        $mtParam->moId = $mo_id;


        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, []);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, []);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    public static function errorSyntax($msisdn, $sp_id, $send_sms = true, $mo_id= 0)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::LOI_SAI_CU_PHAP;
        $mtParam->destination = $msisdn;
        $mtParam->sp_id = $sp_id;
        $mtParam->moId = $mo_id;



        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, []);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, []);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    public static function errorSystem($subscriber, $send_sms = false)
    {
        $mtParam = new MTParam();
        $mtParam->code_name = ResMessage::LOI_HE_THONG;
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;


        if ($send_sms) {
            $message = SMSGW::sendMT($mtParam, []);
        } else {
            $SmsMtTemplateContent = SmsMtTemplateContent::getMtContent($mtParam, []);
            $message = $SmsMtTemplateContent['web_content'];
        }

        return $message;
    }

    public static function resend($subscriber, $message)
    {
        $mtParam = new MTParam();
        $mtParam->destination = $subscriber->msisdn;
        $mtParam->sp_id = $subscriber->service_provider_id;
        $res = SMSGW::resendMT($mtParam, $message);
        return $res;
    }

}