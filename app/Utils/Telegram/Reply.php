<?php

namespace App\Utils\Telegram;

use App\Services\Config;

class Reply
{
    public static function getUserTrafficInfo($user)
    {
        $text = [
            '您当前的流量状况：',
            '',
            '今日已使用 ' . $user->TodayusedTrafficPercent() . '% ：' . $user->TodayusedTraffic(),
            '之前已使用 ' . $user->LastusedTrafficPercent() . '% ：' . $user->LastusedTraffic(),
            '流量约剩余 ' . $user->unusedTrafficPercent() . '% ：' . $user->unusedTraffic(),
        ];
        return implode(PHP_EOL, $text);
    }

    public static function getUserInfo($user)
    {
        $text = [
            '当前余额：' . $user->money,
            '在线设备：' . ($user->node_connector != 0 ? $user->online_ip_count() . ' / ' . $user->node_connector : $user->online_ip_count() . ' / 不限制'),
            '端口速率：' . ($user->node_speedlimit != 0 ? $user->node_speedlimit . 'Mbps' : '无限制'),
            '上次使用：' . $user->lastSsTime(),
            '过期时间：' . $user->class_expire,
        ];
        return implode(PHP_EOL, $text);
    }

    public static function getUserTitle($user)
    {
        if ($user->class > 0) {
            $text = '尊敬的 VIP ' . $user->class . ' 您好：';
        } else {
            $text = '尊敬的用户您好：';
        }
        return $text;
    }

    public static function getUserInfoFromAdmin($user, $ChatID)
    {
        $strArray = [
            '#' . $user->id . ' ' . $user->user_name . ' 的用户信息',
            '',
            '用户邮箱：' . TelegramTools::getUserEmail($user->email, $ChatID),
            '账户余额：' . $user->money,
            '是否启用：' . $user->enable,
            '用户等级：' . $user->class,
            '剩余流量：' . $user->unusedTraffic(),
            '等级到期：' . $user->class_expire,
            '账户到期：' . $user->expire_in,
        ];
        return implode(PHP_EOL, $strArray);
    }
}
