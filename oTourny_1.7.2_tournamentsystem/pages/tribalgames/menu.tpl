var BLANK_IMAGE="pages/tribalgames/images/b.gif";
//keywords
var code="code";var url="url";var sub="sub";
//styles
var color = {"border":"#666666", "shadow":"#DBD8D1"};
var css = {"ON":"MOn", "OVER":"MOver"};
var STYLE = {"border":0, "color":color, "css":css};
var color2 = {"border":"#666666", "shadow":"#DBD8D1", "bgON":"#CCCCCC","bgOVER":"#DDDDDD"};
var css2 = {"ON":"SOn", "OVER":"SOver"};
var STYLE2 = {"border":0, "color":color2, "css":css2};
//items and formats
var MENU_ITEMS =
[
	{"pos":[0,0], "itemoff":[0,150], "leveloff":[0,24], "style":STYLE, "size":[25,150]},
	{code:"Home", url:"/", "target":"_self",
		sub:[
			{"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
			{code:"Daily News", url:"/?page=news", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
				{code:"- Submit News", url:"{SITE_URL}/forum/viewforum.php?f=1", "target":"_self"},
			]},
			{code:"Security/Privacy Policy", url:"/?page=policy&policy=privacy", "target":"_self"},
			{code:"Member Agreement", url:"/?page=policy&policy=user", "target":"_self"},
		]
	},
	{code:"Forum", url:"{SITE_URL}/forum", "target":"_self",
		sub:[
			{"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
			{code:"General", url:"{SITE_URL}/forum/index.php?c=2", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
				{code:"- Announcements", url:"{SITE_URL}/forum/viewforum.php?f=1", "target":"_self"},
				{code:"- TG Disscussion", url:"{SITE_URL}/forum/viewforum.php?f=2", "target":"_self"},
				{code:"- Tech Support", url:"{SITE_URL}/forum/viewforum.php?f=3", "target":"_self"},
				{code:"- Non TG Disscussion", url:"{SITE_URL}/forum/viewforum.php?f=4", "target":"_self"},
				{code:"- Suggestions", url:"{SITE_URL}/forum/viewforum.php?f=5", "target":"_self"},

			]},
			{code:"America's Army", url:"{SITE_URL}/forum/viewforum.php?f=6", "target":"_self"},
			{code:"Battlefield DC", url:"{SITE_URL}/forum/viewforum.php?f=7", "target":"_self"},
			{code:"Call of Duty", url:"{SITE_URL}/forum/viewforum.php?f=8", "target":"_self"},
			{code:"Halo", url:"{SITE_URL}/forum/viewforum.php?f=9", "target":"_self"},
			{code:"Soldier of Fotune II", url:"{SITE_URL}/forum/viewforum.php?f=10", "target":"_self"},
			{code:"Tribes 2", url:"{SITE_URL}/forum/viewforum.php?f=11", "target":"_self"},
			{code:"Tribes: Vengenace", url:"{SITE_URL}/forum/viewforum.php?f=19", "target":"_self"},
			{code:"Hosting", url:"{SITE_URL}/forum/index.php?c=5", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
				{code:"- Dedicated Chat", url:"{SITE_URL}/forum/viewforum.php?f=12", "target":"_self"},
				{code:"- Game/Web Hosting", url:"{SITE_URL}/forum/viewforum.php?f=13", "target":"_self"},
				{code:"- Staff Applications", url:"{SITE_URL}/forum/viewforum.php?f=14", "target":"_self"},
				{code:"- Support", url:"{SITE_URL}/forum/viewforum.php?f=15", "target":"_self"},

			]},
		]
	},
<template name="USER">
	{code:"{MENU_USER_NAME}", url:"/?page=profile&type=1&id={MENU_USER_ID}", "target":"_self",
		sub:[
			{"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
			{code:"Control Panel", url:"#", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
				{code:"- My Profile", url:"/?page=playercontrol&cmd=profile","target":"_self",
					sub:[
						{"leveloff":[0,151], "style":STYLE2},
						{code:"- View Profile", url:"/?page=profile&type=1&id={MENU_USER_ID}","target":"_self"},
					]
				},
				{code:"- My Teams", url:"#","target":"_self",
					sub:[
						{"leveloff":[0,151], "style":STYLE2},
						{code:"- Create A Team", url:"/?page=playercontrol&cmd=cteam","target":"_self"},
						{code:"- Join A Team", url:"/?page=playercontrol&cmd=jteam","target":"_self"},
						{code:"- My Team Invites", url:"/?page=playercontrol&cmd=iteam","target":"_self"},
					]
				},
				{code:"- My Tournaments", url:"/?page=playercontrol&cmd=tourny","target":"_self"},
			]},
<template name="USER_TEAMS">
			{code:"Teams", url:"#", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
<template name="USER_TEAM">
				{code:"- {MENU_USER_TEAM_NAME}", url:"#","target":"_self",
					sub:[
						{"leveloff":[0,151], "style":STYLE2},
<template name="USER_TEAM_CP_FOUNDER">
						{code:"- Profile", url:"/?page=teamcontrol&teamid={MENU_USER_TEAM_ID}&cmd=profile","target":"_self"},
						{code:"- Dissolve Team", url:"/?page=teamcontrol&teamid={MENU_USER_TEAM_ID}&cmd=dissolve","target":"_self"},
</template name="USER_TEAM_CP_FOUNDER">
<template name="USER_TEAM_CP_CAPT">
						{code:"- Tournaments", url:"/?page=teamcontrol&teamid={MENU_USER_TEAM_ID}&cmd=tourny","target":"_self"},
						{code:"- Members", url:"/?page=teamcontrol&teamid={MENU_USER_TEAM_ID}&cmd=members","target":"_self"},
</template name="USER_TEAM_CP_CAPT">
						{code:"- Leave Team", url:"/?page=teamcontrol&teamid={MENU_USER_TEAM_ID}&cmd=leave","target":"_self"},
					]
				},
</template name="USER_TEAM">
			]
			},
</template name="USER_TEAMS">
<template name="USER_ATOURNY">
			{code:"Admin Tournaments", url:"#", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
<template name="USER_ATOURNY_ROW">
				{code:"{MENU_USER_ATOURNY_NAME}", url:"/?page=tournyc&tournyid={MENU_USER_ATOURNY_ID}","target":"_self"},
</template name="USER_ATOURNY_ROW">
			]},
</template name="USER_ATOURNY">
<template name="USER_TOURNY">
			{code:"Tournaments", url:"#", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
<template name="USER_TOURNY_SINGLE">
				{code:"- Single Player", url:"#","target":"_self",
					sub:[
						{"leveloff":[0,151], "style":STYLE2},
<template name="USER_TOURNY_SINGLE_ROW">
						{code:"- {MENU_USER_STOURNY_NAME}", url:"/?page=tourny&tournyid={MENU_USER_STOURNY_ID}","target":"_self"}
</template name="USER_TOURNY_SINGLE_ROW">
					]
				},
</template name="USER_TOURNY_SINGLE">
<template name="USER_TOURNY_TEAM">
				{code:"- {MENU_USER_TEAM_NAME}", url:"/?page=profile&type=2&id={MENU_USER_TEAM_ID}","target":"_self",
					sub:[
						{"leveloff":[0,151], "style":STYLE2},
<template name="USER_TOURNY_TEAM_ROW">
						{code:"- {MENU_USER_TEAM_TOURNY_NAME}", url:"/?page=tourny&tournyid={MENU_USER_TEAM_TOURNY_ID}","target":"_self"},
</template name="USER_TOURNY_TEAM_ROW">
					]
				},
</template name="USER_TOURNY_TEAM">
			]},
</template name="USER_TOURNY">
<template name="USER_ADMINCONSOLE">
		{code:"Admin Console", url:"/?page=admin", "target":"_self"},
		{code:"Update News", url:"/?page=updatenews", "target":"_self"},
</template name="USER_ADMINCONSOLE">
		{code:"Create Tournament", url:"/?page=reqtourny", "target":"_self"},
		{code:"Log Out", url:"/?page=logout", "target":"_self"},
		]
	},
</template name="USER">
<template name="TOURNYS">
	{code:"Tournaments", url:"#", "target":"_self",
		sub:[ {"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
<template name="TOURNYS_ROWS">
			{code:"{MENU_TOURNY_NAME}", url:"/?page=tourny&tournyid={MENU_TOURNY_ID}", "target":"_self",
			sub:[
				{"leveloff":[0,151], "style":STYLE2},
				{code:"- Join", url:"/?page=tourny&tournyid={MENU_TOURNY_ID}&cmd=join", "target":"_self"},
				{code:"- Summary", url:"/?page=tourny&tournyid={MENU_TOURNY_ID}", "target":"_self"},
				{code:"- Servers", url:"/?page=tourny&tournyid={MENU_TOURNY_ID}&cmd=servers", "target":"_self"},
				{code:"- Matchs",  url:"/?page=tourny&tournyid={MENU_TOURNY_ID}&cmd=matchs", "target":"_self"},
<template name="TOURNYS_ROWS_DRAFT">
                                {code:"- Player Draft",  url:"/?page=tourny&tournyid={MENU_TOURNY_ID}&cmd=draft", "target":"_self"},
</template name="TOURNYS_ROWS_DRAFT">
<template name="TOURNYS_ROWS_MODULE">
				{code:"- {MENU_MODULE_NAME}", url:"/?page=tourny&tournyid={MENU_TOURNY_ID}&cmd=module&module={MENU_MODULE_ID}", "target":"_self"},
</template name="TOURNYS_ROWS_MODULE">
			]},
</template name="TOURNYS_ROWS">
		]
	},
</template name="TOURNYS">
<template name="SIGNUP">
	{code:"Sign-Up", url:"/?page=playersignup", "target":"_self", sub: [
	  {"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
	  {code:"Lost Password", url:"/?page=login&cmd=lostpass", "target":"_self"}
	 ]},
</template name="SIGNUP">
	{code:"Contact", url:"{SITE_URL}/forum/viewforum.php?f=2", "target":"_self",
	sub:[
		{"leveloff":[24,0], "itemoff":[27,0], "style":STYLE2},
		{code:"Report a Bug", url:"{SITE_URL}/forum/viewforum.php?f=3","target":"_self"},
		{code:"Site Comments", url:"{SITE_URL}/forum/viewforum.php?f=2","target":"_self"},
		{code:"Forum", url:"{SITE_URL}/forum/","target":"_self"},
	]},

];
