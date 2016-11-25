<?php
/**
 * Created by PhpStorm.
 * User: Hoan
 * Date: 2/26/2016
 * Time: 10:32 AM
 */

namespace common\helpers;


class View360Helper {
    const ROLE_UNKNOWN = 0;
    const ROLE_VIEW = 1;
    const ROLE_ADMIN = 2;

    public static function getUser($token){
        $url = "http://10.211.0.250:8080/SSO/SSOService.svc/user/ValidateTokenUrl?token=" . $token . "<@-@>10020";
        $content = file_get_contents($url);
        \Yii::info($content);
        $user_info = json_decode($content, TRUE);
        $jsonIterator = isset($user_info['ValidateTokenUrlResult']) ? $user_info['ValidateTokenUrlResult'] : [];

        $User = "";
        foreach ($jsonIterator as $key => $val) {
            if (!is_array($val)) {
                if ($key = 'Username') {
                    $User = $val;
                }
            }
        }

        return $User;
    }


    public static function getRole($User){
        $urlRole = "http://10.211.0.250:8080/Role/ServiceRole.svc/user/CheckRole?username=" . $User;
        $contentRole = file_get_contents($urlRole);

        $user_role = json_decode($contentRole, TRUE);
        $role = isset($user_role['CheckRoleResult']) ? $user_role['CheckRoleResult'] : 0;

        return $role;
    }
} 