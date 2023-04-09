<%            
  mDBName = "SELECT name from sysdatabases where name='"&Request("FileName")&"'"
  mUseDB = "USE "&Request("FileName")
  mTblName1 = "IF EXISTS (Select * from sysobjects where id = object_id('[ad_data]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) SELECT 'AD_DATA' "
  mTblName2 = "IF EXISTS (Select * from sysobjects where id = object_id('[admin]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) SELECT 'ADMIN' "  
  mTblName3 = "IF EXISTS (Select * from sysobjects where id = object_id('[Companies]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) SELECT 'Companies' "  
  mTblName4 = "IF EXISTS (Select * from sysobjects where id = object_id('[stats]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) SELECT 'stats' "

  mDropTable1 = "IF EXISTS (Select * from sysobjects where id = object_id('[ad_data]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [AD_DATA]"
  mDropTable2 = "IF EXISTS (Select * from sysobjects where id = object_id('[admin]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [ADMIN]"  
	mDropTable3 = "IF EXISTS (Select * from sysobjects where id = object_id('[Companies]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [Companies]"  
  mDropTable4 = "IF EXISTS (Select * from sysobjects where id = object_id('[stats]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [stats]"
  mDropTable5 = "IF EXISTS (Select * from sysobjects where id = object_id('[Campaign]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [Campaign]"
	
  mSQL1 = "CREATE DATABASE adnow"
  mSQL2 = "CREATE TABLE [dbo].[ad_data] ( " & _
	  "[AdID] [int] IDENTITY (1, 1) NOT NULL ," & _
	  "[CampaignID] [int] NOT NULL ," & _
	  "[CustomerID] [int] NULL DEFAULT (0)," & _
	  "[AdName] [nvarchar] (255) NOT NULL ," & _
	  "[Status] [nvarchar] (50) NOT NULL DEFAULT ('Active')," & _
	  "[ImageURL] [nvarchar] (255) NULL ," & _
	  "[Url] [nvarchar] (255) NOT NULL ," & _
	  "[ImpressionsPurchased] [int] NULL DEFAULT (0)," & _
	  "[ALT] [nvarchar] (255) NULL ," & _
	  "[adweight] [int] NOT NULL DEFAULT (1)," & _
	  "[TempWeight] [int] NULL DEFAULT (0)," & _
	  "[adwidth] [nvarchar] (4) NULL ," & _
	  "[adheight] [nvarchar] (4) NULL ," & _
	  "[adborder] [nvarchar] (4) NULL ," & _
	  "[DateStart] [nvarchar] (10) NOT NULL ," & _
	  "[DateEnd] [nvarchar] (10) NULL ," & _
	  "[Target] [nvarchar] (50) NOT NULL ," & _
	  "[TextMsg] [ntext] NULL ," & _
	  "[ClickExpire] [int] NULL DEFAULT (0)," & _ 
	  "[Actualenddate] [nvarchar] (10) NULL ," & _ 	  
	  "[adtarget] [nvarchar] (255) NULL " & _ 	  
	  "CONSTRAINT [PK_ad_data] PRIMARY KEY  NONCLUSTERED (" & _
	  "[AdId]" & _
	  ")  ON [PRIMARY] " & _ 
	  ") ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]"
  mSQL3 = "CREATE TABLE [dbo].[admin] ( " & _
	  "[adminID] [int] IDENTITY (1, 1) NOT NULL ," & _
	  "[Username] [nvarchar] (50) NOT NULL ," & _
	  "[Password] [nvarchar] (50) NOT NULL " & _
	  "CONSTRAINT [PK_admin] PRIMARY KEY  NONCLUSTERED (" & _
	  "[AdminID]" & _
	  ")  ON [PRIMARY]" & _
	  ") ON [PRIMARY]"
  mSQL4 = "CREATE TABLE [dbo].[Campaign] ( " & _
	  "[CampaignID] [int] IDENTITY (1, 1) NOT NULL ," & _
	  "[CampaignName] [nvarchar] (255) NOT NULL ," & _
	  "[CampaignDescription] [ntext] NULL ," & _
	  "[CustomerID] [int] NOT NULL DEFAULT (0)" & _
	  "CONSTRAINT [PK_Campaign] PRIMARY KEY  NONCLUSTERED (" & _
	  "[CampaignID]" & _
	  ")  ON [PRIMARY]" & _
 	  ") ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]"
  mSQL5 = "CREATE TABLE [dbo].[Companies] ( " & _
	  "[CustomerID] [int] IDENTITY (1, 1) NOT NULL, " & _
	  "[CompanyName] [nvarchar] (100) NULL, " & _
	  "[CompanyAddress1] [nvarchar] (100) NULL, " & _
	  "[CustomerSince] [nvarchar] (20) NULL, " & _
	  "[CompanyAddress2] [nvarchar] (100) NULL, " & _
	  "[CompanyCity] [nvarchar] (100) NULL, " & _
	  "[CompanyState] [nvarchar] (20) NULL, " & _
	  "[CompanyPostalCode] [nvarchar] (20) NULL, " & _
	  "[ContactName] [nvarchar] (50) NULL, " & _
	  "[CompanyCountry] [nvarchar] (50) NULL, " & _
	  "[ContactEmail] [nvarchar] (255) NULL, " & _
	  "[CompanyURL] [nvarchar] (255) NULL, " & _
	  "[CompanyPhoneVoice] [nvarchar] (50) NULL, " & _
	  "[CompanyPhoneFax] [nvarchar] (50) NULL, " & _
	  "[CompanyUserName] [nvarchar] (50) NOT NULL, " & _
	  "[CompanyPassword] [nvarchar] (50) NOT NULL, " & _
	  "[Notes] [ntext] NULL, " & _
	  "[fromname] [nvarchar] (255) NULL, " & _
	  "[fromaddress] [nvarchar] (255) NULL, " & _
	  "[EmailReport] [nvarchar] (255) NULL, " & _
	  "[name] [nvarchar] (255) NULL, " & _
	  "[cc] [nvarchar] (255) NULL, " & _
	  "[subject] [nvarchar] (255) NULL, " & _
	  "[body] [ntext] NULL, " & _
	  "[DReport] [int] NULL, " & _
	  "[IReport] [int] NULL, " & _
	  "[LastSend] [nvarchar] (50) NULL " & _
	  "CONSTRAINT [PK_Companies] PRIMARY KEY  NONCLUSTERED (" & _
	  "[CustomerID]" & _
	  ")  ON [PRIMARY]" & _
	  ") ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]"
  mSQL6 = "CREATE TABLE [dbo].[stats] ( " & _
	  "[ID] [int] IDENTITY (1, 1) NOT NULL ," & _
	  "[AdID] [int] NOT NULL ," & _
	  "[Datelog] [nvarchar] (50) NOT NULL ," & _
	  "[Impressions] [int] NOT NULL ," & _
	  "[Clicks] [int] NOT NULL " & _
	  "CONSTRAINT [PK_stats] PRIMARY KEY  NONCLUSTERED (" & _
	  "[AdID], [Datelog]" & _
	  ")  ON [PRIMARY]" & _
          ") ON [PRIMARY]"	
  mAlterSQL1 = "ALTER TABLE ad_data ADD [ClickExpire] [int] NULL DEFAULT (0), " & _
                                       "[CampaignID] [int] NOT NULL DEFAULT (0), " & _
                                       "[Actualenddate] [nvarchar] (10), " & _
				       "[adtarget] [nvarchar] (255)"	  
  
  mAlterSQL2 = "ALTER TABLE companies ADD [Notes] [ntext] NULL, " & _
                                         "[fromname] [nvarchar] (255) NULL, " & _
                                         "[fromaddress] [nvarchar] (255) NULL, " & _
                                         "[EmailReport] [nvarchar] (255) NULL, " & _
               				 "[name] [nvarchar] (255) NULL, " & _
               				 "[cc] [nvarchar] (255) NULL, " & _
               				 "[subject] [nvarchar] (255) NULL, " & _
               				 "[body] [ntext] NULL, " & _
               				 "[DReport] [int] NULL, " & _
               				 "[IReport] [int] NULL, " & _
               				 "[LastSend] [nvarchar] (50) NULL"
  mDropDB = "DROP DATABASE "&Request("FileName")
  
  mAlterACCESS1 = "ALTER TABLE ad_data ADD COLUMN " & _
  		  "ClickExpire INTEGER NULL, CampaignID INTEGER NOT NULL, " & _
  		  "Actualenddate TEXT (10) NULL, adtarget TEXT (255) NULL;"
  		  
  mAlterACCESS2 = "ALTER TABLE companies ADD COLUMN " & _
  		  "Notes MEMO NULL, fromname TEXT (255) NULL, fromaddress TEXT (255) NULL, " & _
  		  "EmailReport TEXT (255) NULL, name TEXT (255) NULL, cc TEXT (255) NULL, " & _
  		  "subject TEXT (255) NULL, body MEMO NULL, DReport INTEGER NULL, IReport INTEGER NULL, LastSend TEXT (50) NULL;"
  		  
  mAccess1 = "CREATE TABLE Campaign " & _
             "(CampaignID COUNTER, CampaignName TEXT (255) NOT NULL," & _
             " CampaignDescription MEMO NULL, CustomerID INTEGER NOT NULL," & _
             " CONSTRAINT myCampaignID PRIMARY KEY (CampaignID));"
%>