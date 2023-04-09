drop table if exists [Prefix]SpamGuard;
create table [Prefix]SpamGuard(
	SessionId varchar(35) not null,
	Code varchar(10) not null,
 	AccessTime int unsigned not null,
	TypeId tinyint not null,	
	PRIMARY KEY (SessionId),
	Index AccessTime(AccessTime),	
	Index Code(Code),
	Index Type(TypeId)
);

drop table if exists [Prefix]AddressBook;
create table [Prefix]AddressBook(
	EntryId int unsigned not null auto_increment,
	MemberId int not null,
	ContactId int not null,
	Notes text,
	PRIMARY KEY (EntryId),
	Index Member(MemberId),
	Index Contact(ContactId)
);

drop table if exists [Prefix]Attachments;
create table [Prefix]Attachments(
	AttachmentId int unsigned not null auto_increment, 	
	PostId int unsigned not null,
	FileSize int,
	FileType varchar(5),
	RemovedBy int not null default 0,
	TimesDownload int default 0,
	PRIMARY KEY (AttachmentId),
	Index Post(PostId),
	Index FileType(FileType),
	Index FileSize(FileSize),	
	Index RemovedBy(RemovedBy)
);

drop table if exists [Prefix]Avatars;
create table [Prefix]Avatars(
	AvatarId int unsigned not null auto_increment, 	
	Name varchar(100),
	FileName varchar(30),
	MemberId int unsigned not null default 0,
	Status tinyint not null default 1,
	PRIMARY KEY (AvatarId),
	Index Name(Name),
	Index FileName(FileName),
	Index Member(MemberId),
	Index Status(Status)
);
insert into [Prefix]Avatars (Name,FileName,MemberId,Status) values ("[No Photo]","nophoto.gif",0,1);

drop table if exists [Prefix]BannedIPs;
create table [Prefix]BannedIPs(
	BannedId int unsigned not null auto_increment, 	
	IP varchar(25),
	Notes varchar(255),
	PRIMARY KEY (BannedId),
	Index IP(IP)
);

drop table if exists [Prefix]Boards;
create table [Prefix]Boards(
	BoardId int unsigned not null auto_increment,
	Name varchar(100) not null,
	Description tinytext,
	AccessibleGroups varchar(255),
	DisplayOrder tinyint not null default 0,	
	Status tinyint not null default 1,
	PRIMARY KEY (BoardId),
	Index Name(Name),
	Index DisplayOrder(DisplayOrder),
	Index Status(Status)
);
insert into [Prefix]Boards (Name,Description,AccessibleGroups,DisplayOrder,Status) values ("News","","",0,1);

drop table if exists [Prefix]DefaultSettings;
create table [Prefix]DefaultSettings(
	SettingId int unsigned not null auto_increment, 	
	Type varchar(20),
	Name varchar(100),
	DefaultValue text,
	Description text,
	PRIMARY KEY (SettingId),
	Index Type(Type),
	Index Name(Name)	
);
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","Organization","Pearlinger","Name of your organization");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","WebmasterEmail","info@yoursite.com","Webmaster email, used in outgoing emails");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","membersOnly","0","Forums available to members only if set to 1 (yes).  Must login to view etc.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","checkBannedIPs","0","Check for banned IP on every login if set to yes.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","checkSensoredWords","0","Check for sensored words on every posting if set to yes.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","languagePreference","english","Language preference.  Folder must exists with dependent files, graphics etc.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","allowAttachments","1","Allow attachments");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","allowMessageAttachments","1","Allow attachments on sending private messages.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","allowNotify","1","Allow notification on posting replies.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","displayMemberProfile","1","Display avatar panels on postings.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","showEditTime","1","Show last edit time if posting is modified.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","showModerators","1","Show moderators in forums.  The showForumInfo must be turned on.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","showForumInfo","1","Show forums' descriptions and moderators.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","showBoardDescription","1","Show board descriptions.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","graphicButtons","1","Display links in graphics.  All links will be display as text links if set to no.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","linkColor","#406F85","Links color");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","textColor","#000000","Texts color");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","title","Pearl Forums","Default document title");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","width","95%","Template Width");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","allowableTags","<a><b><blockquote><br><div><dt><em><font><hr><i><img><li><marquee><ol><p><strike><strong><sub><sup><table><tbody><td><tr><u><ul>","Allowable tags in postings");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","badAttributes","javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup","Bad attributes not allowed in postings.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","avatarSize","51200","Avatar file size, in bytes");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","avatarWidth","100","Avatar width, in pixels");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","avatarHeight","130","Avatar height, in pixels");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","avatarTypes","jpg gif bmp png","Allowable Avatar types");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","disallowAttachmentTypes","php","Allowable Avatar types");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","attachmentSize","1024000","Max file size for each attachment, in bytes");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","sessionDuration","86400","Session duration, in seconds.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","postingsPerPage","10","Number of postings per page");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","listingsPerPage","20","Number of entries per page on listings");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","MaxAddressBook","100","Maximum contact entries per member.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","MaxPagingLinks","10","Maximum paging links.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","maxMemberMessages","100","Maximum number of private messages each user can have");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","maxMessageAttachment","1024000","Maximum total file size in all message attachments each user can have.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","RegistrationSpamGuard","1","Antispam with security code required user to enter on registration.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","LoginSpamGuard","0","Antispam with security code required user to enter on login.");
insert into [Prefix]DefaultSettings (Type,Name,DefaultValue,Description) values ("variable","SpamGuardFolder","spamguard","This folder is where the images are stored and needs to be writable.");

drop table if exists [Prefix]ErrorLogs;
create table [Prefix]ErrorLogs(
	LogId int unsigned not null auto_increment, 
	MemberId int unsigned not null default 0,
	ScriptName varchar(255),
	Sql text,
	ErrorMessage text,
	LogTime int,
	PRIMARY KEY (LogId),
	Index Member(MemberId),
	Index GeneratedTime(LogTime)
);

drop table if exists [Prefix]Forums;
create table [Prefix]Forums(
	ForumId int unsigned not null auto_increment, 	
	BoardId int unsigned not null,
	Name varchar(100) not null,
	Description tinytext,
	DisplayOrder tinyint,
	Topics int,
	Posts int,
	LatestPostId int unsigned not null,	
	Moderators tinytext,
	Announcement tinyint not null default 0,
	Status tinyint not null default 1,
	PRIMARY KEY (ForumId),
	Index Name(Name),
	Index Board(BoardId),
	Index DisplayOrder(DisplayOrder),
	Index LatestPost(LatestPostId),
	Index Announcement(Announcement),
	Index Status(Status)
);
insert into [Prefix]Forums (BoardId,Name,Description,DisplayOrder,Topics,Posts,LatestPostId,Moderators,Announcement,Status) values (1,"Welcome","",0,1,1,1,"",0,1);

drop table if exists [Prefix]Groups;
create table [Prefix]Groups(
	GroupId int unsigned not null auto_increment, 
	Name char(30),
	Description text,
	Status tinyint not null default 1,
	PRIMARY KEY (GroupId),
	Index Name(Name),
	Index Status(Status)
);
insert into [Prefix]Groups (Name, Description, Status) values ("PHP Geeks","This is a sample group",1);

drop table if exists [Prefix]Members;
create table [Prefix]Members(
	MemberId int unsigned not null auto_increment, 	
	GroupId int not null default 0,
	AccessLevelId int not null,
	Name varchar(40),
	LoginName varchar(20),
	Passwd varchar(32),
	SecurityCode varchar(20),
	Email varchar(100),
	URL varchar(100),
	HideEmail tinyint default 0,
	DateJoined int,
	LastLogin int,
	NotifyAnnouncements tinyint,
	IP varchar(100),
	AvatarId int not null default 0,
	TotalPosts int unsigned default 0,
	Locked tinyint not null default 0,
	Bio text,
	PRIMARY KEY (MemberId),
	Index MemberGroup(GroupId),
	Index Name(Name),
	Index Login(LoginName),
	Index Pass(Passwd),
	Index SecurityCode(SecurityCode),
	Index Notify(NotifyAnnouncements),
	Index Locked(Locked)
);

drop table if exists [Prefix]Messages;
create table [Prefix]Messages(
	MessageId int unsigned not null auto_increment, 	
	SenderId int not null,
	ReceiverId int unsigned not null,
	Subject varchar(100),
	Message text,
	SendTime int unsigned not null default 0,
	Status tinyint not null,
	PRIMARY KEY (MessageId),
	Index Sender(SenderId),
	Index Receiver(ReceiverId),
	Index Subject(Subject),
	Index SendTime(SendTime),
	Index Status(Status)
);

drop table if exists [Prefix]MessageAttachments;
create table [Prefix]MessageAttachments(
	AttachmentId int unsigned not null auto_increment, 	
	MessageId int unsigned not null,
	FileSize int,
	FileName varchar(25),	
	Status tinyint not null default 1,
	PRIMARY KEY (AttachmentId),
	Index Message(MessageId),
	Index FileName(FileName),
	Index FileSize(FileSize),	
	Index Status(Status)
);

drop table if exists [Prefix]Notify;
create table [Prefix]Notify(
	NotifyId int unsigned not null auto_increment, 	
	MemberId int unsigned not null,
	TopicId int unsigned not null,
	PRIMARY KEY (NotifyId),
	Index Member(MemberId),
	Index Topic(TopicId)
);

drop table if exists [Prefix]Online;
create table [Prefix]Online(
	MemberId int unsigned not null default 0,
	HitTime int unsigned not null default 0,
	PRIMARY KEY (MemberId),
	Index HitTime(HitTime)
);

drop table if exists [Prefix]Polls;
create table [Prefix]Polls(
	PollId int unsigned not null auto_increment, 	
	TopicId int not null,
	Question text,
	Option1 varchar(100),
	Option2 varchar(100),
	Option3 varchar(100),
	Option4 varchar(100),			
	Option5 varchar(100),
	Option6 varchar(100),
	Option7 varchar(100),
	Option8 varchar(100),
	Option9 varchar(100),
	Option10 varchar(100),
	Voted1 int default 0,
	Voted2 int default 0,
	Voted3 int default 0,
	Voted4 int default 0,
	Voted5 int default 0,
	Voted6 int default 0,
	Voted7 int default 0,
	Voted8 int default 0,
	Voted9 int default 0,
	Voted10 int default 0,
	StartDate int unsigned,
	EndDate int unsigned,
	Status tinyint not null default 1,
	PRIMARY KEY (PollId),
	Index Topic(TopicId),
	Index Status(Status)
);

drop table if exists [Prefix]PollVotes;
create table [Prefix]PollVotes(
	VoteId int unsigned not null auto_increment, 	
	PollId int not null,
	MemberId int not null,
	OptionId tinyint not null,
	VotedDate int unsigned,
	PRIMARY KEY (VoteId),
	Index Poll(PollId),
	Index Member(MemberId)
);

drop table if exists [Prefix]Posts;
create table [Prefix]Posts(
	PostId int unsigned not null auto_increment, 	
	TopicId int unsigned not null,
	MemberId int unsigned not null,
	Subject varchar(100) not null,	
	Message text,
	SmileyId int not null default 0,
	IP varchar(100),
	PostDate int unsigned not null default 0,
	ModifiedBy int not null default 0,
	ModifiedDate int unsigned not null default 0,
	FirstPost tinyint not null default 0,
	Status tinyint not null default 1,
	PRIMARY KEY (PostId),
	Index Topic(TopicId),
	Index Member(MemberId),
	Index Subject(Subject),
	Index Icon(SmileyId),
	Index Modifier(ModifiedBy),
	Index FirstPost(FirstPost),
	Index Status(Status)	
);
insert into [Prefix]Posts (TopicId,MemberId,Subject,Message,SmileyId,IP,PostDate,ModifiedBy,ModifiedDate,FirstPost,Status) values (1,1,"Welcome to Pearl!","Please go directly to your administrative section if you haven't done so.  For updates, bugs and other issues, please visit pearlinger.com.",15,"",1076181427,1,1076181427,1,1);

drop table if exists [Prefix]ReservedUsernames;
create table [Prefix]ReservedUsernames(
	ReservedId int unsigned not null auto_increment, 	
	Username varchar(20),
	Notes varchar(255),
	PRIMARY KEY (ReservedId),
	Index Username(Username)
);

drop table if exists [Prefix]SensoredWords;
create table [Prefix]SensoredWords(
	SensoredId int unsigned not null auto_increment, 	
	Word varchar(25),
	Substitute varchar(25),
	WholeWord tinyint,
	PRIMARY KEY (SensoredId),	
	Index Word(Word),
	Index WholeWord(WholeWord)
);
insert into [Prefix]SensoredWords (Word,Substitute,WholeWord) values ("fuck","f**k",0);

drop table if exists [Prefix]Smileys;
create table [Prefix]Smileys(
	SmileyId int unsigned not null auto_increment, 	
	Name varchar(20),
	FileName varchar(30),
	Status tinyint not null default 1,
	PRIMARY KEY (SmileyId),
	Index Name(Name),
	Index FileName(FileName),
	Index Status(Status)
);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Angry","angry.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Attachments","attachments.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Blush","blush.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Cool","cool.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Cry","cry.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Explaination","explaination.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Grin","grin.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("GoAway!","goaway.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Hehe!","hehe.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Love","love.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Love Talk","lovetalk.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Mad","mad.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Robin","robin.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Sad","sad.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Smile","smile.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Sneaky","sneaky.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Stare","stare.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values (" Subject icon","default.gif",0);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Wink","wink.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Wonder","wonder.gif",1);
insert into [Prefix]Smileys (Name,FileName,Status) values ("Link","link.gif",1);

drop table if exists [Prefix]Topics;
create table [Prefix]Topics(
	TopicId int unsigned not null auto_increment, 	
	ForumId int unsigned not null,
	StartPostId int unsigned not null,
	LatestPostId int unsigned not null,
	Replies int,
	Views int,
	Sticky tinyint not null default 0,
	Locked tinyint not null default 0,
	Poll int unsigned not null,
	PRIMARY KEY (TopicId),
	Index Forum(ForumId),
	Index StartPost(StartPostId),
	Index LatestPost(LatestPostId),
	Index Sticky(Sticky)
);
insert into [Prefix]Topics (ForumId,StartPostId,LatestPostId,Replies,Views,Sticky,Locked,Poll) values (1,1,1,0,0,0,0,0);

drop table if exists [Prefix]ViewedForums;
create table [Prefix]ViewedForums(
	LogId int unsigned not null auto_increment, 	
	MemberId int not null,
	ForumId int unsigned not null,
	LogTime int unsigned not null default 0,
	PRIMARY KEY (LogId),
	Index Member(MemberId),
	Index Forum(ForumId),
	Index LogTime(LogTime)
);

drop table if exists [Prefix]ViewedTopics;
create table [Prefix]ViewedTopics(
	LogId int unsigned not null auto_increment, 	
	MemberId int not null,
	TopicId int unsigned not null,
	LogTime int unsigned not null default 0,
	PRIMARY KEY (LogId),
	Index Member(MemberId),
	Index Topic(TopicId),
	Index LogTime(LogTime)
);

