<?php

###############################################################################
# chinese_gb2312.php
#
# Last Modified:20030312:
# This is the Chinese (gb2312) language page for GeekLog!
#
# Copyright (C) 2003 Crocodile King @  Scarborough,Toronto Canada
# Kingwangwen@hotmail.com &  @truez.com
#
# Note: I have fixed it by referral Chinese_big5.php
#
# Chinese punctuation used in this file
# ；︰、！，。？：『』（）※×……％§÷、《》【】‘’“”￥＃◎！～
#
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

$LANG_CHARSET = "gb2312";

###############################################################################
# Array Format:
# $LANGXX[YY]:$LANG - variable name
#  XX - file id number
#YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
    1 => "投稿者︰",
    2 => "读多些",
    3 => "个评论",
    4 => "编辑",
    5 => "投票",
    6 => "结果",
    7 => "投票结果",
    8 => "投票",
    9 => addslashes("管理者功能︰"),
    10 => "提交物",
    11 => "故事",
    12 => "组件",
    13 => "主题",
    14 => "连结",
    15 => "事件",
    16 => "投票",
    17 => "用户",
    18 => "SQL Query",
    19 => "退出",
    20 => "用户讯息︰",
    21 => "用户名",
    22 => "用户识别号",
    23 => "安全等级",
    24 => "匿名",
    25 => "回复",
    26 => "以下评论只属张贴者个人观点。",
    27 => "最近发表的",
    28 => "删除",
    29 => "没有评论。",
    30 => "旧的故事",
    31 => "允许的 HTML 标记:",
    32 => "错误，无效的用户名",
    33 => "错误，不能写系统日志;",
    34 => "错误",
    35 => "退出",
    36 => "于",
    37 => "没有故事",
    38 => "",
    39 => "使新",
    40 => "",
    41 => "客人",
    42 => "作者:",
    43 => "回复这个",
    44 => "父母",
    45 => "MySQL 错误号码",
    46 => "MySQL 错误讯息",
    47 => addslashes("用户功能"),
    48 => "帐户讯息",
    49 => "风格选择",
    50 => "错误的 SQL statement",
    51 => "帮助",
    52 => "新",
    53 => "管理者首页",
    54 => "不能打开文件。",
    55 => "错处",
    56 => "投票",
    57 => "密码",
    58 => "登入",
    59 => "没有帐户？<a href=\"{$_CONF["site_url"]}/users.php?mode=new\">在此登记</a>",
    60 => "发表评论",
    61 => "新增帐户",
    62 => "字",
    63 => "评论设定",
    64 => "把文章电邮给朋友",
    65 => "观看可列印的版本",
    66 => "我的日历",
    67 => "欢迎来到",
    68 => "首页",
    69 => "联络",
    70 => "搜寻",
    71 => "投稿",
    72 => "网路资源",
    73 => "投票中心",
    74 => "日历",
    75 => "进阶搜索",
    76 => "本站统计数据",
    77 => "Plugins",
    78 => "即将发生的事",
    79 => "新鲜的东西",
    80 => "个新故事(",
    81 => "新的故事(",
    82 => " 小时内)",
    83 => "评论",
    84 => "连结",
    85 => "最近四十八小时",
    86 => "没有新的评论",
    87 => "最近两个星期",
    88 => "没有新的连结",
    89 => "没有事发生",
    90 => "首页",
    91 => "载入这页用了",
    92 => "秒",
    93 => "版权",
    94 => "All trademarks and copyrights on this page are owned by their respective owners.",
    95 => "Powered By",
    96 => "小组",
    97 => "字词单",
    98 => "Plug-ins",
    99 => "故事",
    100 => "没有新的故事",
    101 => "你的事件",
    102 => "本站的事件",
    103 => "资料库备份",
    104 => "由",
    105 => "寄给用户",
    106 => "观看",
    107 => "GL 版本测试",
    108 => "清除缓冲贮存区"
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => "事件日历",
    2 => "抱歉，没有事件。",
    3 => "时",
    4 => "地",
    5 => "事",
    6 => "新增事件",
    7 => "即将发生的事",
    8 => "在将这事加进你的日历之後，你可点击 \"我的日历\" 来观看",
    9 => "加进我的日历",
    10 => "从我的日历中去除",
    11 => "把这事加进 {$_USER["username"]} 的日历",
    12 => "事件",
    13 => "开始",
    14 => "结束",
    15 => "回到日历"
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => "发表评论",
    2 => "发表方式",
    3 => "退出",
    4 => "新增帐户",
    5 => "用户名",
    6 => "本站需要登入才可发表评论，请登入。如果你没有帐户，请使用下面的表格登记。",
    7 => "你最後发表的评论是在 ",
    8 => " 秒之前。本站限定至少 {$_CONF["commentspeedlimit"]} 秒後才可再发表评论",
    9 => "评论",
    10 => "",
    11 => "发表评论",
    12 => "请填写标题注评论栏",
    13 => "供你参考",
    14 => "预览",
    15 => "",
    16 => "标题",
    17 => "错误",
    18 => "重要的东西",
    19 => "请尽量不要离题。",
    20 => "尽可能回复别人的评论，而不是开新的评论。",
    21 => "为避免重复，发表评论之前请先读别人所写的。",
    22 => "请尽量用简洁的标题。",
    23 => "我们不会公开你的电邮地址。",
    24 => "匿名用户"
);

###############################################################################
# users.php

$LANG04 = array(
    1 => "用户概况",
    2 => "用户名",
    3 => "全名",
    4 => "密码",
    5 => "电子邮件",
    6 => "首页",
    7 => "小传",
    8 => "PGP 钥匙",
    9 => "保存设定",
    10 => "给用户的最後十个评论",
    11 => "没有评论",
    12 => "用户设定",
    13 => "每夜电邮文摘",
    14 => "这是个随机的密码，请尽快更改。要更改密码请先登入系统，然後点击帐户讯息。",
    15 => "你在 {$_CONF["site_name" ]} 的帐户已建立了。请使用以下讯息登入系统并保留这邮件作日後参考。",
    16 => "你的帐户讯息",
    17 => "帐户并不存在",
    18 => "你提供的不是一个有效的的电邮",
    19 => "用户名或电邮已经存在",
    20 => "提供的不是一个有效的的电邮",
    21 => "错误",
    22 => "登记用 {$_CONF["site_name"]} ！",
    23 => "在 {$_CONF["site_name"]} 登记的用户可享有的会员好处。他们可以用自己的名字发表评论和存取本站的资源。请注意本站<b><i>绝不会</i></b>公开用户的电邮。",
    24 => "你的密码将被送到你输入的电邮信箱",
    25 => "忘记了你的密码吗？",
    26 => "请你输入的用户名和点击电邮密码，我们会发送一个新的密码到你的电邮信箱。",
    27 => "现在就登记！",
    28 => "电邮密码",
    29 => "logout at",
    30 => "login at",
    31 => "需要登入才可用",
    32 => "署名",
    33 => "绝不会公开",
    34 => "这是你的真名",
    35 => "要改变请输入密码",
    36 => "开始是 http://",
    37 => "将会附加在你发表的评论上",
    38 => "你的简介",
    39 => "你的公共 PGP 钥匙",
    40 => "没有主题图示",
    41 => "愿意主持",
    42 => "日期格式",
    43 => "故事限度",
    44 => "没有组件",
    45 => "显示设定",
    46 => "不包括的",
    47 => "新组件配置为",
    48 => "主题",
    49 => "故事里没有图像",
    50 => "不要打钩如果你不感兴趣",
    51 => "只是新故事",
    52 => "预设值是",
    53 => "每晚接收当日的故事",
    54 => "打钩如果你不看这些主题或作者。",
    55 => "如果你没有选择，这意味你要用预设的组件。如果你选择组件，所有预设的箱将被忽略。预设的东西会用粗笔画显示。",
    56 => "作者",
    57 => "显示方式",
    58 => "排序方式",
    59 => "评论限制(个)",
    60 => "可显示你的评论吗？",
    61 => "最新或最旧的先？",
    62 => "预设是100",
    63 => "密码已被发送，你会很快收到的。",
    64 => "评论设定",
    65 => "请尝试再登入",
    66 => "你可能打错了，请尝试再登入。你是否<a href=\"{$_CONF["site_url"]}/users.php?mode=new\">新用户</a>？",
    67 => "成员自",
    68 => "记住我为",
    69 => "在登入以後，我们应该记住你多久？",
    70 => "定做 {$_CONF["site_name"]} 的布局和内容",
    71 => "一个 {$_CONF["site_name"]} 的主要特点是你可以定做自己的布局和内容，但是你必须是本站的会员。<a href=\"{$_CONF["site_url"]}/users.php?mode=new\">在此登记</a>。如果你已经是登记，请使用左边的区域登入。",
    72 => "题材",
    73 => "语言",
    74 => "改变本站外表",
    75 => "主题已电邮给",
    76 => "请只选择你感兴趣的主题，因为所有当日新张贴的故事将会电邮到你的信箱。",
    77 => "相片",
    78 => "你自己的图片",
    79 => "要删除图片，在这里打钩",
    80 => "登入",
    81 => "发送电子邮件",
    82 => "用户最近发表的十个故事为",
    83 => "用户发表统计",
    84 => "文章总数︰",
    85 => "评论总数︰",
    86 => "寻找所有发表过的文章︰"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => "没有新闻可显示",
    2 => "没有新故事可显示。",
    3 => "这也许是真的没有新主题或是你的 $topic 设定得太过限制性。",
    4 => "今天头条",
    5 => "下一个",
    6 => "前一个"
);

###############################################################################
# links.php

$LANG06 = array(
    1 => "网路资源",
    2 => "没有资源可显示",
    3 => "加一连结"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => "投票保存了",
    2 => "你的投票已被保存了",
    3 => "投票",
    4 => "系统中的投票",
    5 => "投票"
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => "发送电子邮件时发生错误。请再尝试。",
    2 => "电邮已送出。",
    3 => "请确定你在回复栏有一个可用的电子邮件地址。",
    4 => "请填写你的名字、回复栏、主题和内容",
    5 => "错误：没有这用户。",
    6 => "发生错误。",
    7 => "用户资料",
    8 => "用户名",
    9 => "用户名的 URL",
    10 => "发送邮件到",
    11 => "你的名字：",
    12 => "回复到：",
    13 => "主题：",
    14 => "内容：",
    15 => "HTML 不会被翻译。",
    16 => "发送邮件",
    17 => "把故事电邮给朋友",
    18 => "收件人名字",
    19 => "收件人电邮",
    20 => "寄件人名字",
    21 => "寄件人电邮",
    22 => "所有栏都要填写",
    23 => "这电子邮件是由 $from ($fromemail) 寄给你的，他认为你也许对这篇在 {$_CONF["site_url"]} 的文章感兴趣。这不是垃圾邮件(SPAM)，你的电邮地址也不会被纪录。",
    24 => "关於这个故事的评论在",
    25 => "为帮助我们防止系统被滥用，你必须登入。",
    26 => "这个表格允许你送电子邮件到你选择的用户中。请填写所有的栏位。",
    27 => "短信",
    28 => "$from 写道：$shortmsg",
    29 => "来自於 {$_CONF["site_name"]} 的每日文摘，给予：",
    30 => " 每日的时事通讯，给予：",
    31 => "标题",
    32 => "日期",
    33 => "完整的文章在：",
    34 => "电邮结束"
);

###############################################################################
# search.php

$LANG09 = array(
    1 => "进阶搜寻",
    2 => "关键词",
    3 => "主题",
    4 => "所有",
    5 => "类型",
    6 => "故事",
    7 => "评论",
    8 => "作者",
    9 => "所有",
    10 => "搜寻",
    11 => "搜寻结果",
    12 => "相配",
    13 => "搜寻结果：没有相配的",
    14 => "没有你寻找的东西︰",
    15 => "请再尝试",
    16 => "主题",
    17 => "日期",
    18 => "作者",
    19 => "搜寻整个 {$_CONF["site_name"]} 的新旧故事资料库",
    20 => "日期",
    21 => "到",
    22 => "(日期格式 YYYY-MM-DD)",
    23 => "采样数",
    24 => "找到",
    25 => "个相配在",
    26 => "个项目中，共用了",
    27 => "秒",
    28 => "没有你所寻找的故事或评论",
    29 => "故事和评论的结果",
    30 => "没有你所寻找的连结",
    31 => "没有你所寻找的 plug-in",
    32 => "事件",
    33 => "URL",
    34 => "地点",
    35 => "所有日子",
    36 => "没有你所寻找的事件",
    37 => "事件的结果",
    38 => "连结的结果",
    39 => "连结",
    40 => "事件",
    41 => '搜寻的关键词最少要有三个字。',
    42 => '请使用 YYYY-MM-DD (年-月-日) 日期格式。'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => "本站统计数据",
    2 => "系统点击总数",
    3 => "故事(评论)总数",
    4 => "投票(获得投票)总数",
    5 => "连结(点击)总数",
    6 => "事件总数",
    7 => "最多观看的十个故事",
    8 => "故事标题",
    9 => "观看",
    10 => "看来本站没有故事或是没人观看过本站的故事。",
    11 => "最多评论的十个故事",
    12 => "评论",
    13 => "看来本站没有故事或是没人评论过本站的故事。",
    14 => "最多人投票的十个选举",
    15 => "投票标题",
    16 => "投票",
    17 => "看来本站没有投票或是没人投过票。",
    18 => "最多人点击的十个连结",
    19 => "连结",
    20 => "点击",
    21 => "看来本站没有连结或是没人点击过本站的连结。",
    22 => "最多人寄出的十个故事",
    23 => "电邮",
    24 => "看来没人寄出过本站的故事"
);

###############################################################################
# article.php

$LANG11 = array(
    1 => "有什麽是相关的",
    2 => "寄故事给朋友",
    3 => "可印的故事格式",
    4 => "故事选项"
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "你需要登入才可发表 $type ",
    2 => "登入",
    3 => "新用户",
    4 => "发表一件事",
    5 => "发表一个连结",
    6 => "发表一个故事",
    7 => "你需要登入",
    8 => "发表",
    9 => "在本站发表东西时请跟随以下建议...<ul><li>填写所有的栏<li>提供完全和准确的讯息<li>再三检查那些 URLs</ul>",
    10 => "标题",
    11 => "连结",
    12 => "开始日期",
    13 => "结束日期",
    14 => "地点",
    15 => "描述",
    16 => "如果是其他，请指定",
    17 => "类别",
    18 => "其他",
    19 => "读这先",
    20 => "错误：缺少类别",
    21 => "当选择\"其他\"请提供一个类别名",
    22 => "错误：缺少栏位",
    23 => "请填写所有的栏位",
    24 => "你发表的已被保存了",
    25 => "你的 $type 已被保存了",
    26 => "限速",
    27 => "用户名",
    28 => "主题",
    29 => "故事",
    30 => "你最後发表的是",
    31 => " 秒之前。本站限定至少 {$_CONF["speedlimit"]} 秒後才可再发表",
    32 => "预览",
    33 => "故事 预览",
    34 => "退出",
    35 => "不准许 HTML 标记",
    36 => "发表模式",
    37 => "加事件到 {$_CONF["site_name"]} 会将你的事件加到主日历中，其他的用户可随意地把它加进自己的个人日历。请<b>不要</b>把你的个人事件譬如生日和周年纪念加进去。<br><br>只要管理员批准你的事件它将出现在主日历上。",
    38 => "加事件到",
    39 => "主日历",
    40 => "个人日历",
    41 => "结束时间",
    42 => "开始时间",
    43 => "整日的事件",
    44 => "地址 1",
    45 => "地址 2",
    46 => "城市/市镇",
    47 => "州",
    48 => "邮政编码",
    49 => "事件类型",
    50 => "编辑事件类型",
    51 => "地点",
    52 => "删除",
    53 => "新加帐户"
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
    1 => "要求认证",
    2 => "拒绝！不正确的登入资料",
    3 => "无效的密码",
    4 => "用户名：",
    5 => "密码：",
    6 => "这页只供授权人员使用。<br>所有存取将被记录和检查。",
    7 => "登入"
);

###############################################################################
# block.php

$LANG21 = array(
    1 => "权力不足",
    2 => "你没有权去编辑这个组件。",
    3 => "组件编辑器",
    4 => "",
    5 => "组件标题",
    6 => "主题",
    7 => "所有",
    8 => "组件安全水平",
    9 => "组件次序",
    10 => "组件类型",
    11 => "入口组件",
    12 => "正常组件",
    13 => "入口组件选项",
    14 => "RDF URL",
    15 => "最後的 RDF 更新",
    16 => "正常组件选项",
    17 => "组件内容",
    18 => "请填写组件的标题、安全水平和内容。",
    19 => "组件管理员",
    20 => "组件标题",
    21 => "组件安全水平",
    22 => "组件类型",
    23 => "组件次序",
    24 => "组件主题",
    25 => "点击下面的组件可修改或删除它，点击上面的新组件可创造一个新的。",
    26 => "版面组件",
    27 => "PHP 组件",
    28 => "PHP 组件选项",
    29 => "组件函数",
    30 => "如果你想用自己的 PHP 函数组件，请在上面输入函数的名字。为防止执行任性的编码，PHP 组件函数名必须以 \"phpblock_\" 作开始 (e.g. phpblock_getweather)。请不要把空的圆括号 \"()\" 放在函数後。最後，建议你把所有的 PHP 组件放在 /path/to/geeklog/system/lib-custom.php 里以方便系统升级。",
    31 => "PHP 组件错误︰函数 $function 并不存在。",
    32 => "错误︰缺少栏位。",
    33 => "在入口组件你必须把 URL 输入到 .rdf 档案",
    34 => "在 PHP 组件你必须输入主题和函数",
    35 => "在正常组件你必须输入主题和内容",
    36 => "在版面组件你必须输入内容",
    37 => "不适当的 PHP 组件函数名",
    38 => "为防止执行任性的编码，PHP 组件函数名必须以 \"phpblock_\" 作开始 (e.g. phpblock_getweather)。",
    39 => "放在那边",
    40 => "左",
    41 => "右",
    42 => "在 Geeklog 预设组件你必须输入组件次序和安全水平",
    43 => "只可是首页",
    44 => "存取被拒绝",
    45 => "企图存取不允许的组件已被记录。请<a href=\"{$_CONF["site_admin_url"]}/block.php\">反回组件管理员昼面</a>。",
    46 => "新组件",
    47 => "管理员首页",
    48 => "组件名",
    49 => " (不可有空隔和必须是唯一的)",
    50 => "求助文件的 URL",
    51 => "包括 http://",
    52 => "如果这里留白，组件的求助文件图示将不被显示",
    53 => "使有效",
    54 => "保存",
    55 => "取消",
    56 => "删除"
);

###############################################################################
# event.php

$LANG22 = array(
    1 => "事件编辑器",
    2 => "",
    3 => "事件标题",
    4 => "事件 URL",
    5 => "事件开始日期",
    6 => "事件结束日期",
    7 => "事件地点",
    8 => "事件描述",
    9 => "(包括 http://)",
    10 => "你必须提供日期或时间、描述和事件地点！",
    11 => "事件管理员",
    12 => "点击下面的事件可修改或删除它，点击上面的新事件可创造一个新的。",
    13 => "事件标题",
    14 => "开始日期",
    15 => "结束日期",
    16 => "存取被拒绝",
    17 => "企图存取不允许的事件已被记录。请<a href=\"{$_CONF["site_admin_url"]}/event.php\">反回事件管理员昼面</a>。",
    18 => "新事件",
    19 => "管理员首页",
    20 => "保存",
    21 => "取消",
    22 => "删除"
);

###############################################################################
# link.php

$LANG23 = array(
    1 => "连结编辑器",
    2 => "",
    3 => "连结标题",
    4 => "连结 URL",
    5 => "类别",
    6 => "(包括 http://)",
    7 => "其他",
    8 => "连结被击次数",
    9 => "连结描述",
    10 => "你需要提供连结标题、 URL 和描述！",
    11 => "连结管理员",
    12 => "点击下面的连结可修改或删除它，点击上面的新连结可创造一个新的。",
    13 => "连结标题",
    14 => "连结类别",
    15 => "连结 URL",
    16 => "存取被拒绝",
    17 => "企图存取不允许的连结已被记录。请<a href=\"{$_CONF["site_admin_url"]}/link.php\">反回连结管理员昼面</a>。",
    18 => "新连结",
    19 => "管理员首页",
    20 => "如果是其他，请指定",
    21 => "保存",
    22 => "取消",
    23 => "删除"
);

###############################################################################
# story.php

$LANG24 = array(
    1 => "上一个故事",
    2 => "下一个故事",
    3 => "模式",
    4 => "发表模式",
    5 => "故事编辑器",
    6 => "没有故事",
    7 => "作者",
    8 => "保存",
    9 => "预览",
    10 => "取消",
    11 => "删除",
    12 => "",
    13 => "标题",
    14 => "主题",
    15 => "日期",
    16 => "故事简介",
    17 => "故事内容",
    18 => "点击次数",
    19 => "评论",
    20 => "",
    21 => "",
    22 => "故事清单",
    23 => "点击下面的故事编号可修改或删除它，点击下面的故事标题可观看它，点击上面的新故事可创造一个新的。",
    24 => "",
    25 => "",
    26 => "故事预览",
    27 => "",
    28 => "",
    29 => "",
    30 => "",
    31 => "你需要提供作者、标题和故事简介！",
    32 => "头条的",
    33 => "只可有一个头条故事",
    34 => "草稿",
    35 => "是",
    36 => "否",
    37 => "更多来自於",
    38 => "更多发表於",
    39 => "电邮",
    40 => "存取被拒绝",
    41 => "企图存取不允许的故事已被记录。你可以以唯读模式观看下面文章。看完後请<a href=\"{$_CONF["site_admin_url"]}/story.php\">反回故事管理员昼面</a>。",
    42 => "企图存取不允许的故事已被记录。请<a href=\"{$_CONF["site_admin_url"]}/story.php\">反回故事管理员昼面</a>。",
    43 => "新故事",
    44 => "管理员首页",
    45 => "存取权",
    46 => "<b>注意︰</b>如果你把日期改成将来，在那个日期前这篇文章将不会被发表。并且 意味着这篇故事不会包括在你的 RDF 标题内，在搜寻和统计页中会被忽略。",
    47 => "图像",
    48 => "image",
    49 => "right",
    50 => "left",
    51 => "请用特别格式的文字([imageX]、[imageX_right] 或 [imageX_left])来插入图像， X 是你附加图像的编号。注意︰你只可使用你附加的图像否则你将无法保存你的故事。<BR><P><B>预览</B>︰最佳预览故事的方法是把故事保存成草稿而不是直击预览按钮。只有没有附加图像时才用预览按钮。",
    52 => "删除",
    53 => "没有被使用。保存前，你必须把这个图像包含在故事简介或故事内容中。",
    54 => "附加图像未被使用",
    55 => "保存你的故事时发生以下错误。请改正这些错误再保存",
    56 => "显示主题图示"
);

###############################################################################
# poll.php

$LANG25 = array(
    1 => "模式",
    2 => "",
    3 => "投票发起日",
    4 => "投票 $qid 被保存了",
    5 => "编辑投票",
    6 => "投票编号",
    7 => "(不可有空隔)",
    8 => "出现在首页上",
    9 => "问题",
    10 => "答案 / 投票",
    11 => "取得投票 ($qid) 答案时发生错误。",
    12 => "取得投票 ($qid) 问题时发生错误。",
    13 => "新加投票",
    14 => "保存",
    15 => "取消",
    16 => "删除",
    17 => "",
    18 => "投票清单",
    19 => "点击下面的投票可修改或删除它，点击上面的新投票可创造一个新的。",
    20 => "投票者",
    21 => "存取被拒绝",
    22 => "企图存取不允许的投票已被记录。请<a href=\"{$_CONF["site_admin_url"]}/poll.php\">反回投票管理员昼面</a>。",
    23 => "新投票",
    24 => "管理员首页",
    25 => "是",
    26 => "否"
);

###############################################################################
# topic.php

$LANG27 = array(
    1 => "主题编辑器",
    2 => "主题编号",
    3 => "主题名",
    4 => "主题图像",
    5 => "(不可有空隔)",
    6 => "删除主题会同时删除所有有关的故事和组件！",
    7 => "你需要提供主题编号和主题名！",
    8 => "主题管理员",
    9 => "点击下面的主题可修改或删除它，点击上面的新主题可创造一个新的。在括号里你将发现你的存取级别。",
    10=> "排序次序",
    11 => "故事 / 页",
    12 => "存取被拒绝",
    13 => "企图存取不允许的主题已被记录。请<a href=\"{$_CONF["site_admin_url"]}/topic.php\">反回主题管理员昼面</a>.",
    14 => "排序方法",
    15 => "按字母排序",
    16 => "预设是",
    17 => "新主题",
    18 => "管理员首页",
    19 => "保存",
    20 => "取消",
    21 => "删除"
);

###############################################################################
# user.php

$LANG28 = array(
    1 => "用户编辑器",
    2 => "用户编号",
    3 => "用户名",
    4 => "全名",
    5 => "密码",
    6 => "安全级别",
    7 => "电邮地址",
    8 => "首页",
    9 => "(不可有空隔)",
    10 => "你需要提供用户名、全名、安全级别和电邮地址。",
    11 => "用户管理员",
    12 => "点击下面的用户可修改或删除它，点击上面的新用户可创造一个新的。在下面的表格中输入部份的用户名、电邮地址或全名 (e.g.*son* or *.edu) ，可做简单的寻找。",
    13 => "安全级别",
    14 => "登记日",
    15 => "新用户",
    16 => "管理员首页",
    17 => "改密码",
    18 => "取消",
    19 => "删除",
    20 => "保存",
    18 => "取消",
    19 => "删除",
    20 => "保存",
    21 => "用户名已经存在",
    22 => "错误",
    23 => "大量增加",
    24 => "大量输入用户",
    25 => "你可一次过输入大量的用户到 Geeklog 。输入档案必须是一个用 tab 分隔的文字档案，栏位的顺序是︰全名、用户名、电邮地址。每一个被输入的用户将会收到一个以电子邮件发送的随机密码。档案中每一行是一个用户。没遵守这些要求将造成问题，也许需要手动作业，请再三检查你档案！",
    26 => "寻找",
    27 => "结果范围",
    28 => "在这里打钩可删除这张图片",
    29 => "路径",
    30 => "输入",
    31 => "新用户",
    32 => "处理完成。输入了 $successes 个；$failures 个失败",
    33 => "递交",
    34 => "错误︰你必须指定上载档案。"
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "批准",
    2 => "删除",
    3 => "编辑",
    4 => "简要描述",
    10 => "标题",
    11 => "开始日期",
    12 => "URL",
    13 => "类别",
    14 => "日期",
    15 => "主题",
    16 => "用户名",
    17 => "全名",
    18 => "电子邮件",
    34 => "命令和控制",
    35 => "已递交的故事",
    36 => "已递交的连结",
    37 => "已递交的事件",
    38 => "递交",
    39 => "此时没有递交的东西",
    40 => "申请的用户"
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => "日",
    2 => "一",
    3 => "二",
    4 => "三",
    5 => "四",
    6 => "五",
    7 => "六",
    8 => "新增事件",
    9 => "Geeklog 事件",
    10 => "事件给",
    11 => "主日历",
    12 => "我的日历",
    13 => "一月",
    14 => "二月",
    15 => "三月",
    16 => "四月",
    17 => "五月",
    18 => "六月",
    19 => "七月",
    20 => "八月",
    21 => "九月",
    22 => "十月",
    23 => "十一月",
    24 => "十二月",
    25 => "回到",
    26 => "整日",
    27 => "星期",
    28 => "个人日历︰",
    29 => "公众日历",
    30 => "删除事件",
    31 => "新增",
    32 => "事件",
    33 => "星期",
    34 => "时间",
    35 => "迅速增加",
    36 => "递交",
    37 => "抱歉，本站并不提供个人日历。",
    38 => "个人事件编辑器",
    39 => "日",
    40 => "周",
    41 => "月"
);

###############################################################################
# admin/mail.php
$LANG31 = array(
    1 => $_CONF["site_name"] . " 邮件程式",
    2 => "寄件人",
    3 => "回复到",
    4 => "主题",
    5 => "内容",
    6 => "收件人︰",
    7 => "所有用户",
    8 => "管理员",
    9 => "选项",
    10 => "HTML",
    11 => "迫切的讯息！",
    12 => "发送",
    13 => "重设",
    14 => "忽略用户设定",
    15 => "错误，当发送到︰",
    16 => "讯息已发送到︰",
    17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>发送其它信件</a>",
    18 => "收件人",
    19 => "注意︰如果你希望发送讯息到本站所有的成员，请在小组选择栏位中选择 Logged-in Users group。",
    20 => "已发送 <successcount> 个讯息，有 <failcount> 个不能发送。发送的细节在下面。如不想看细节，你可<a href=\"" . $_CONF["site_admin_url"] . "/mail.php\">发送其它讯息</a> 或 <a href=\"" . $_CONF["site_admin_url"] . "/moderation.php\">反回管理员首页</a>。",
    21 => "失败",
    22 => addslashes("成功 "),
    23 => addslashes("全部成功 "),
    24 => "全部失败",
    25 => "-- 请选小组 --",
    26 => "请填写所有表格上的栏位和选择一个小组。"
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
    1 => "我们已电邮了你的密码到你的电邮信箱，请跟随邮件中的指示。多谢使用 " . $_CONF["site_name"],
    2 => "多谢递交你的故事到 {$_CONF["site_name"]} 。只要经过我们员工的核对，你的故事将出现在我们的纲页上。",
    3 => "多谢递交连结到 {$_CONF["site_name"]} 。只要经过我们员工的核对，你的连结将出现在我们的纲页上。",
    4 => "多谢递交事件到 {$_CONF["site_name"]} 。只要经过我们员工的核对，你的事件将出现在我们的<a href={$_CONF["site_url"]}/calendar.php>日历</a>上。",
    5 => "你的帐户设定已被保存了。",
    6 => "你的个性界面设定已被保存了。",
    7 => "你的评论界面设定已被保存了。",
    8 => "你已退出。",
    9 => "你的故事已被保存了。",
    10 => "你的故事已被删除了。",
    11 => "你的组件已被保存了。",
    12 => "你的组件已被删除了。",
    13 => "你的主题已被保存了。",
    14 => "你的主题和所有相关的故事已被删除了。",
    15 => "你的连结已被保存了。",
    16 => "你的连结已被删除了。",
    17 => "你的事件已被保存了。",
    18 => "你的事件已被删除了。",
    19 => "你的投票已被保存了。",
    20 => "你的投票已被删除了。",
    21 => "新用户已被保存了。",
    22 => "用户已被删除了。",
    23 => "增加事件到你的日历时发生错误，缺少了事件编号。",
    24 => "事件已增加到你的日历中。",
    25 => "你要登入才可开启你的个人日历。",
    26 => "事件已从你的日历中移除。",
    27 => "信息已发送。",
    28 => "Plug-in 已被保存了。",
    29 => "抱歉，本站并不提供个人日历。",
    30 => "存取被拒绝",
    31 => "抱歉，你不能进入故事管理的首页。请注意你的企图已被记录。",
    32 => "抱歉，你不能进入主题管理的首页。请注意你的企图已被记录。",
    33 => "抱歉，你不能进入组件管理的首页。请注意你的企图已被记录。",
    34 => "抱歉，你不能进入连结管理的首页。请注意你的企图已被记录。",
    35 => "抱歉，你不能进入事件管理的首页。请注意你的企图已被记录。",
    36 => "抱歉，你不能进入投票管理的首页。请注意你的企图已被记录。",
    37 => "抱歉，你不能进入用户管理的首页。请注意你的企图已被记录。",
    38 => "抱歉，你不能进入 Plug-in 管理的首页。请注意你的企图已被记录。",
    39 => "抱歉，你不能进入电邮管理的首页。请注意你的企图已被记录。",
    40 => "系统讯息",
   41 => "抱歉，你不能进入字词替换的首页。请注意你的企图已被记录。",
    42 => "你的字词已被保存了。",
    43 => "你的字词已被删除了。",
   44 => "Plug-in 已被安装了。",
    45 => "Plug-in 已被删除了。",
    46 => "抱歉，你不能进入资料库备份程式。请注意你的企图已被记录。",
    47 => "这只适用於 *nix 如果你的作业系统是 *nix，那麽你的缓冲器已被清除了。如果你的作业系统是 Windows，你要手动寻找文件命名为 adodb _ *.php 的档案并把它们除去。",
    48 => "感谢你申请成为 {$_CONF["site_name"]} 的会员。只要经过我们员工的核对，我们会把密码寄到你所登记的电邮中。",
    49 => "你的小组已被保存了。",
    50 => "小组已被删除了。"
);

// for plugins.php

$LANG32 = array (
    1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system. It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems. It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites. Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin. In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
    2 => "Plug-in 安装声明",
    3 => "Plug-in 安装表格",
    4 => "Plug-in 档案",
    5 => "Plug-in 清单",
    6 => "警告︰Plug-in 已经被安装过！",
    7 => "你想安装的 plug-in 已经存在，请先把它删除再安装。",
    8 => "Plugin 不能通过兼容性校验。",
    9 => "这 plugin 要求一个更新版本的 Geeklog. 你可以升级你的<a href=\"http://www.geeklog.net\">Geeklog</a>或是另找一个适合的版本。",
    10 => "<br><b>没有安装的 plugin 。</b><br><br>",
    11 => "点击下面 plugin 的编号可修改或删除它，点击 plugin 的名字会带你到那 plugin 的网站。要安装或升级 plugin 请咨询它是文件。",
    12 => "plugineditor() 找不到 plugin 名",
    13 => "Plugin 编辑器",
    14 => "新 Plug-in",
    15 => "管理员首页",
    16 => "Plug-in 名字",
    17 => "Plug-in 版本",
    18 => "Geeklog 版本",
    19 => "使有效",
    20 => "是",
    21 => "否",
    22 => "安装",
    23 => "保存",
    24 => "取消",
    25 => "删除",
    26 => "Plug-in 名字",
    27 => "Plug-in 首页",
    28 => "Plug-in 版本",
    29 => "Geeklog 版本",
    30 => "删除 Plug-in？",
    31 => "你肯定要删除这个 Plug-in 吗？这麽会删除所有有关这 Plug-in 的文件、资料和资料结构。如果你肯定的，请再点击下面表格中的删除钮。"
);

$LANG_ACCESS = array(
    access => "存取",
    ownerroot => "所有者/Root",
    group => "小组",
    readonly => "唯读",
    accessrights => "存取权",
    owner => "所有者",
    grantgrouplabel => "给予之上小组编辑权利",
    permmsg => "注意︰会员是指所有注册和登入的用户；而匿名是指所有非注册的浏览者或没有登入的用户。",
    securitygroups => "安全小组",
    editrootmsg => "即使你是用户管理员；但你不能编辑 root 用户。你能编辑所有的用户除了 root 用户。请注意所有企图非法地编辑 root 用户的动作已被记录。请回到<a href=\"{$_CONF["site_admin_url"]}/user.php\">用户管理页</a>去。",
    securitygroupsmsg => "选择这位用户属於的小组。",
    groupeditor => "小组编辑器",
    description => "描述",
    name => "名字",
    rights => "权限",
    missingfields => "缺少栏位",
    missingfieldsmsg => "你必须提供小组的名字和描述",
    groupmanager => "小组管理员",
    newgroupmsg => "点击下面的小组可修改或删除它，点击上面的新小组可创造一个新的。请注意所核心小组不能被删除。",
    groupname => "组名",
    coregroup => "核心小组",
    yes => "是",
    no => "否",
    corerightsdescr => "这个小组的权限不能被编辑，因为这是个 {$_CONF["site_name"]} 的核心小组。以下是这小组的权限清单(唯读的)。",
    groupmsg => "安全小组在这纲站是有等级制度的。当增加这个小组到另一组别，这个小组将得到那组别的权限。请尽可能小组加下列的组别去。如果这小组需要特别的权限，你可以在以下的\"权利\"区域中挑选。要把小组加到组别去，你只需要在组别旁边的挑选盒打钩。",
    coregroupmsg => "因为这是个 {$_CONF["site_name"]} 的核心小组，这个小组的权限不能被编辑。以下是这小组的组别清单(唯读的)。",
    rightsdescr => "小组的权限可以是来自於小组本身或是这小组所属的组别。以下的权限中如没有检验盒即代表这权限是来自於小组所属的组别；如有检验盒即代表你可以直接把权限给予这小组。",
    lock => "锁住",
    members => "成员",
    anonymous => "匿名",
    permissions => "权限",
    permissionskey => "R = 唯读， E = 编辑，有编辑权即有唯读权",
    edit => "编辑",
    none => "没有",
    accessdenied => "存取被拒绝",
    storydenialmsg => "因未被批准，你不可以观看这个故事。这是可能是因为你并不是 {$_CONF["site_name"]} 的会员。请<a href=users.php?mode=new>成为会员</a>。",
    eventdenialmsg => "因未被批准，你不可以观看这个事件。这是可能是因为你并不是 {$_CONF["site_name"]} 的会员。请<a href=users.php?mode=new>成为会员</a>。",
    nogroupsforcoregroup => "这小组不属於任何其它的小组",
    grouphasnorights => " 这小组没有管理权。",
    newgroup => "新小组",
    adminhome => "管理员首页",
    save => "保存",
    cancel => "取消",
    delete => "删除",
    canteditroot => "因为你不属于 Root 小组，所以你对 Root 小组的修改被拒绝了。如有问题请与系统管理员联系。"
);

#admin/word.php
$LANG_WORDS = array(
    editor => "字词替换编辑器",
    wordid => "字词编号",
    intro => "点击下面的字词可修改或删除它，点击左边的新字词可创造一个新的。",
    wordmanager => "字词管理员",
    word => "字词",
    replacmentword => "替代字词",
    newword => "新字词"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => "最後十个备份",
    do_backup => "做备份",
    backup_successful => "资料库备份完成。",
    no_backups => "没有备份",
    db_explanation => "要做新的 Geeklog 备份，点击以下的按钮",
    not_found => "不正确的路径或 mysqldump 程式不可执行。<br>检查<strong>\$_DB_mysqldump_path</strong>定义在 config.php.<br>变数现在被定义为︰<var>{$_DB_mysqldump_path}</var>",
    zero_size => "备份失败︰档案是 0 大小",
    path_not_found => "{$_CONF["backup_path"]} 不存在或不是目录",
    no_access => "错误︰目录 {$_CONF["backup_path"]} ，不能存取。",
    backup_file => "备份档案",
    size => "大小",
    bytes => "位元组"
);

$LANG_BUTTONS = array(
    1 => "首页",
    2 => "联络",
    3 => "出版",
    4 => "连结",
    5 => "投票",
    6 => "日历",
    7 => "本站统计数据",
    8 => "个人化",
    9 => "搜索",
    10 => "进阶搜寻"
);

$LANG_404 = array(
    1 => "404 错误",
    2 => "咦，我到处都看过了但找不到<b>%s</b>.",
    3 => "<p>很抱歉，但你要求的文件不存在。请检查<a href=\"{$_CONF["site_url"]}\">主页</a>或<a href=\"{$_CONF["site_url"]}/search.php\">搜索页</a>看看能发现什麽。"
);

$LANG_LOGIN = array (
    1 => "要求登入",
    2 => "抱歉，要求登入才可存取这个区域。",
    3 => "登入",
    4 => "新用户"
);

?>
