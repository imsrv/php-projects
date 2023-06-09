if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Categories]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Categories]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Configuration]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Configuration]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Errors]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Errors]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_NewsletterList]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_NewsletterList]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Reviews]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Reviews]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Sites]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Sites]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Templates]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Templates]
GO

if exists (select * from sysobjects where id = object_id(N'[dbo].[del_Directory_Users]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[del_Directory_Users]
GO

CREATE TABLE [dbo].[del_Directory_Categories] (
	[ID] [int] NULL ,
	[CategoryName] [nvarchar] (50) NULL ,
	[ListingCount] [int] NULL ,
	[ParentID] [int] NULL ,
	[AllowLinks] [bit] NOT NULL ,
	[Created] [smalldatetime] NULL ,
	[LastUpdated] [smalldatetime] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Configuration] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[DirectoryName] [nvarchar] (50) NULL ,
	[NavigationSeperator] [nvarchar] (50) NULL ,
	[ShowSubCategoryCount] [int] NULL ,
	[EmailObjectToUse] [nvarchar] (50) NULL ,
	[SendEmailAfterLinkAddition] [bit] NOT NULL ,
	[SendEmailAfterReviewSubmission] [bit] NOT NULL ,
	[SendEmailAfterErrorSubmission] [bit] NOT NULL ,
	[EmailAddress] [nvarchar] (255) NULL ,
	[HowManyNewLinksToShow] [int] NULL ,
	[HowManyPopularLinksToShow] [int] NULL ,
	[HowManyResourcesInNewsletter] [int] NULL ,
	[HowManyFavoritesToShow] [int] NULL ,
	[LinksPerPage] [int] NULL ,
	[SearchResultsPerPage] [int] NULL ,
	[MailServer] [nvarchar] (255) NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Errors] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[SiteID] [int] NULL ,
	[FullName] [nvarchar] (255) NULL ,
	[EmailAddress] [nvarchar] (255) NULL ,
	[NatureOfError] [nvarchar] (255) NULL ,
	[Comments] [nvarchar] (255) NULL ,
	[Created] [smalldatetime] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_NewsletterList] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[EmailAddress] [nvarchar] (255) NULL ,
	[Created] [smalldatetime] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Reviews] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[SiteID] [int] NULL ,
	[Title] [nvarchar] (250) NULL ,
	[FullName] [nvarchar] (100) NULL ,
	[EmailAddress] [nvarchar] (100) NULL ,
	[Comments] [ntext] NULL ,
	[Rated] [int] NULL ,
	[PublishOnWeb] [bit] NOT NULL ,
	[Created] [smalldatetime] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Sites] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[Title] [nvarchar] (255) NULL ,
	[Description] [nvarchar] (255) NULL ,
	[URL] [nvarchar] (255) NULL ,
	[Created] [smalldatetime] NULL ,
	[LastAccessed] [smalldatetime] NULL ,
	[Hits] [int] NULL ,
	[HitsToday] [int] NULL ,
	[HitsTodayDate] [int] NULL ,
	[HitsThisMonth] [int] NULL ,
	[HitsThisMonthDate] [int] NULL ,
	[ContactName] [nvarchar] (255) NULL ,
	[ContactEmail] [nvarchar] (255) NULL ,
	[Favorite] [bit] NOT NULL ,
	[Sponsor] [bit] NOT NULL ,
	[CategoryID] [int] NULL ,
	[PublishOnWeb] [bit] NOT NULL ,
	[DuplicateURL] [bit] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Templates] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TemplateName] [nvarchar] (255) NULL ,
	[SubjectLine] [nvarchar] (255) NULL ,
	[Template] [ntext] NULL ,
	[Created] [smalldatetime] NULL ,
	[DefaultTemplate] [bit] NOT NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[del_Directory_Users] (
	[UserID] [int] IDENTITY (1, 1) NOT NULL ,
	[FullName] [nvarchar] (255) NULL ,
	[UserName] [nvarchar] (255) NULL ,
	[UPassword] [nvarchar] (255) NULL ,
	[LoginCount] [int] NULL ,
	[Admin] [bit] NOT NULL ,
	[Created] [smalldatetime] NULL ,
	[LastAccessed] [smalldatetime] NULL 
) ON [PRIMARY]
GO

