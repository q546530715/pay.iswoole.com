<?php
/**
 * Created by PhpStorm.
 * author: Liang
 * Date: 2018/9/8
 * Time: 下午6:38
 */
include 'config.php';

file_get_contents(CRONTAB_URL . "/server/index/checkServiceHeartbeat");
file_put_contents('crontab.txt',date("Y-m-d H:i:s") . "===========/r/n");
file_get_contents(CRONTAB_URL . "/server/index//checkAlipayHeartbeat");
file_get_contents(CRONTAB_URL . "/server/index/checkWechatHeartbeat");
