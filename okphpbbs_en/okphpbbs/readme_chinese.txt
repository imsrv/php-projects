Okphp BBS v.3.1 Free
----------------------------------
Copyright (C) 2003-2005 Okphp Group
http://www.okphp.com
http://cn.okphp.com (chinese)

###########   授权协议   ############

1.本协议只针对OKPHP程序的免费版，如果您安装了OKPHP免费程序，就表明您接受本协议。
2.本程序仅限个人使用，并且不得用于有商业行为的网站。
3.如果您的使用范围超过了第2条的限制，出于试用的目的您也可以安装本程序，但是自安装之日起，请在十五天之内将本程序删除。
4.不得对本程序进行租售。
5.不得移除程序里的版权信息。
6.如果您未能遵守以上条款，您用本程序构筑的网站会被强行关闭，情节严重者将被追究法律责任。

###########   正式版本   ############

如果购买正式版本，您可获得：
1.高级的使用授权。
2.可靠的安全保障。
3.更高效的程序代码。
4.完善、持久的技术支持。
5.最新的升级补丁。



########### 运行环境 ############

* PHP4.3 with GD2
* MYSQL3.23
* Zend Optimizer 2.1 

########### 安装方法 ############

1、上传所有目录和文件到WEB服务器，注意保持目录结构
如果您使用FTP上传，请使用二进制模式上传。

2、如果服务器是LINUX/UNIX系统，需要把如下目录和文件属性改成777
bbs/images/headp/,bbs/config.php

3、运行bbs/install.php进行安装

4、安装成功后，立即删除bbs/install.php，bbs/install/


（Okphp CMS可以独立运做，也可以和Okphp BBS完美整合）

########### 整合安装 ############

Okphp CMS , Okphp BBS 和Okphp BLOG 可以单独运作，也可以任意组合并整合到一起
整合后的程序会自动统一会员注册、登陆/退出、资料修改、在线统计等信息

下面以把三个程序整合在一起为例，为您介绍一下安装方法：
首先将Okphp CMS, Okphp BBS, Okphp BLOG上传到同一个目录下（一般是上传到根目录），因为三个程序里面都有一个"index.php"文件，所以这里我们保留CMS里面的index.php文件。

然后假设数据库参数为：
服务器地址是"localhost", 数据库名是"okphp", 数据库用户帐号是"test", 数据库用户密码是"123"

Okphp CMS
-----------------------------
MySQL服务器地址 localhost 
数据库名 okphp 
数据库用户帐号 test 
数据库用户密码 123 
表的前缀 cms_ 
与OKPHP其它程序整合 
是否整合 Okphp BBS? 是， BBS表的前缀：bbs_ 
是否整合 Okphp BLOG? 是， BLOG表的前缀：blog_ 
用户数据 Okphp CMS 

Okphp BBS
-----------------------------
MySQL服务器地址 localhost 
数据库名 okphp 
数据库用户帐号 test 
数据库用户密码 123 
表的前缀 bbs_ 
与OKPHP其它程序整合 
是否整合 Okphp CMS? 是， CMS表的前缀：cms_ 
是否整合 Okphp BLOG? 是， BLOG表的前缀：blog_ 
用户数据 Okphp CMS 

Okphp BLOG
-----------------------------
MySQL服务器地址 localhost 
数据库名 okphp 
数据库用户帐号 test 
数据库用户密码 123 
表的前缀 bbs_ 
与OKPHP其它程序整合 
是否整合 Okphp CMS? 是， CMS表的前缀：cms_ 
是否整合 Okphp BBS? 是， BBS表的前缀：bbs_ 
用户数据 Okphp CMS 

--------------

// END