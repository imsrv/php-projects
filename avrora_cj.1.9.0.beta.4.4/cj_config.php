<?php
ini_set('error_log','./sys_log/error.log');
ini_set('log_errors','1');
ini_set('display_errors','0');
error_reporting(7);

// ��������� ������ �������� � ����
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASS','');
define('DB_DEVICE','www_av_cj');

define('LICENSE_TYPE','Trial');
define('LICENSE_DATE','0000-00-00');
define('LICENSE_KEY','5e6dd69e99d0c127eddd83c09e496c30');

define('EXT','.php');		// ���������� ���� �������
define('CRONTAB','0');	// ���������� ������� ��� ���
define('IP_EXP_HOUR','12');	// ��� ����� ����� ���� ip � �������� �����
define('DEF_P','30');		// �� ��������� ������� ������ �� �������� �������
define('HOUR_STAT','24');		// ����������� ������ ������ ������ ������ �� ��������� n �����
define('MAX_HOUR_STAT','1');	// ������� ���������� ��������� �� ����� ������ �� ��������� n ����
define('BACK_PRD','150');	//  ���������� ������� � ������������� ���������������
define('IGNORE_BACK_PRD','1');	//  ������������ ����� �������� ������
define('FORCE_PRIO','150');	//  ��������� ������
define('MAX_CLICK','7');	// ������������ ����� ������ ������ ip
define('NEW_TRADER','yes'); // ��������� ����� ��������� ��� ���
define('USE_TOP','1'); // ������������ ��� ��� ���
define('SYS_VERSION','1.9.0 beta 4.4'); // ������ �������

define('PATH',dirname(__FILE__));
?>