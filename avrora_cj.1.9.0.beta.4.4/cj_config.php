<?php
ini_set('error_log','./sys_log/error.log');
ini_set('log_errors','1');
ini_set('display_errors','0');
error_reporting(7);

// указываем данные коннекта к базе
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASS','');
define('DB_DEVICE','www_av_cj');

define('LICENSE_TYPE','Trial');
define('LICENSE_DATE','0000-00-00');
define('LICENSE_KEY','5e6dd69e99d0c127eddd83c09e496c30');

define('EXT','.php');		// расширения морд страниц
define('CRONTAB','0');	// используем кронтаб или нет
define('IP_EXP_HOUR','12');	// как долго живут наши ip в качестве уника
define('DEF_P','30');		// по умолчанию процент выхода на реальный контент
define('HOUR_STAT','24');		// расчитывать отдачу трейда только исходя из последних n часов
define('MAX_HOUR_STAT','1');	// хранить статистику трейдеров по часам только за последнии n дней
define('BACK_PRD','150');	//  возвращаем обратно с установленной продуктивностью
define('IGNORE_BACK_PRD','1');	//  игнорировать лимит обратной отдачи
define('FORCE_PRIO','150');	//  приоритет форсов
define('MAX_CLICK','7');	// максимальное число кликов одного ip
define('NEW_TRADER','yes'); // принимать новых трейдеров или нет
define('USE_TOP','1'); // генерировать топ или нет
define('SYS_VERSION','1.9.0 beta 4.4'); // версия скрипта

define('PATH',dirname(__FILE__));
?>