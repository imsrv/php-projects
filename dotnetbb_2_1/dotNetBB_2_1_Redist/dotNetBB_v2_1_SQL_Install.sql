if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ActivateAvatar]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ActivateAvatar]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ActiveAvatars]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ActiveAvatars]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ActiveEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ActiveEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddAuthUserAccount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddAuthUserAccount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddCategory]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddCategory]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddClonedEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddClonedEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddEmailBan]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddEmailBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddFilterWord]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddFilterWord]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddIPBan]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddIPBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddNewForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddNewForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddUserTitle]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddUserTitle]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AdminMenuAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AdminMenuAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AllUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AllUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ApproveMailer]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ApproveMailer]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ChangeForumOrder]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ChangeForumOrder]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_CheckAdminAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_CheckAdminAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_CheckNameForProfileUpdate]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_CheckNameForProfileUpdate]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeactivateAllAvatars]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeactivateAllAvatars]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeactivateAvatar]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeactivateAvatar]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeleteCategory]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeleteCategory]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeleteFilterWord]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeleteFilterWord]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeleteForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeleteForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeleteUserAndPosts]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeleteUserAndPosts]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DeleteUserTitle]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DeleteUserTitle]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DisableEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DisableEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_DoThreadPrune]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_DoThreadPrune]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_EditMenuAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_EditMenuAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_EditModeratorAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_EditModeratorAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_EditWordFilter]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_EditWordFilter]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_EmptyCatgegoryList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_EmptyCatgegoryList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_EnableEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_EnableEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ForumEditable]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ForumEditable]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ForumListForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ForumListForEdit]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetAdminMenu]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetAdminMenu]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetAdminMenuUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetAdminMenuUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetDescriptionForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetDescriptionForEdit]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetEmailBanList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetEmailBanList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetEmotForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetEmotForEdit]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetFilterWords]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetFilterWords]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetForEnc]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetForEnc]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetForumCategories]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetForumCategories]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetForumTopics]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetForumTopics]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetIPBanList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetIPBanList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetMailerCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetMailerCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetMailerInfo]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetMailerInfo]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetMenuAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetMenuAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetNonPrivateUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetNonPrivateUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetPendingMailers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetPendingMailers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetPollListing]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetPollListing]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetPrivateUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetPrivateUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetTitleForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetTitleForEdit]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetUserForResend]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetUserForResend]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetUserProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetUserProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetWhoVoted]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetWhoVoted]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ListModerators]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ListModerators]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ListTitles]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ListTitles]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_LockThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_LockThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_LogAction]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_LogAction]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_MakeNonSticky]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_MakeNonSticky]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_MakeSticky]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_MakeSticky]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateForums]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateForums]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateLockedThreads]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateLockedThreads]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateNonStickyThreads]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateNonStickyThreads]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateStickyThreads]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateStickyThreads]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModerateUnlockedThreads]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModerateUnlockedThreads]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ModifyUserTitle]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ModifyUserTitle]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_MoveCategory]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_MoveCategory]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_MoveThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_MoveThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_NoAdminMenuAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_NoAdminMenuAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_NonAdminUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_NonAdminUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_NonModerateAccess]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_NonModerateAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_PrivateForumDropListing]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_PrivateForumDropListing]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ProfileList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ProfileList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_RemoveEmailBan]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_RemoveEmailBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_RemoveIPBan]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_RemoveIPBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ThreadPruneCheck]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ThreadPruneCheck]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UnLockThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UnLockThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateCategory]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateCategory]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateFilterWord]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateFilterWord]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateForumHeader]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateForumHeader]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateNonPrivateUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateNonPrivateUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdatePrivateUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdatePrivateUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ActiveAvatars]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ActiveAvatars]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ActiveEmoticon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ActiveEmoticon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddNewPM]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddNewPM]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddNewPollTopic]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddNewPollTopic]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddNewProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddNewProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddNewProfile2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddNewProfile2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddNewTopic]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddNewTopic]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddPollValues]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddPollValues]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddReplyPost]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddReplyPost]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddUserToIgnore]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddUserToIgnore]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_BanIPFromThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_BanIPFromThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_BanUserFromThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_BanUserFromThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPForumSubscribeList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPForumSubscribeList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPListIgnored]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPListIgnored]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPNewSubscribeList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPNewSubscribeList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPRemoveForumSubscribe]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPRemoveForumSubscribe]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPRemoveIgnoreUser]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPRemoveIgnoreUser]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPRemoveThreadSubscribe]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPRemoveThreadSubscribe]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPSubscribeList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPSubscribeList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPUnreadPMs]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPUnreadPMs]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPUpdateOptions]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPUpdateOptions]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CPUpdateProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CPUpdateProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CastVote]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CastVote]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckEmailBan]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckEmailBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckGUIDLock]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckGUIDLock]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckIPLock]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckIPLock]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckIfIgnored]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckIfIgnored]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckIfSubscribed]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckIfSubscribed]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckIfVoted]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckIfVoted]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckUserExist]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckUserExist]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CheckUserForPM]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CheckUserForPM]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_CreateEditableMessage]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_CreateEditableMessage]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_DeleteForumPost]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_DeleteForumPost]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_DeleteMyPM]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_DeleteMyPM]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_EditPost]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_EditPost]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumAccessList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumAccessList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumAccessList2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumAccessList2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumDropListing]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumDropListing]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumDropListing2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumDropListing2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumTitle]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumTitle]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ForumTopicCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ForumTopicCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetCanModerate]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetCanModerate]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetEmoticonMini]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetEmoticonMini]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetFilterWords]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetFilterWords]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForEdit]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForPMReply]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForPMReply]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForQuote]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForQuote]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForumList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForumList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForumListPaged]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForumListPaged]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetForumSubscribe]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetForumSubscribe]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetLastPostTime]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetLastPostTime]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMailNotify]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMailNotify]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMemberCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMemberCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMemberList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMemberList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMemberOrdered]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMemberOrdered]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMessageThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMessageThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMessageThreadPaged]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMessageThreadPaged]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMissingEditMessages]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMissingEditMessages]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMyPMs]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMyPMs]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMySentPMs]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMySentPMs]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetPMMessage]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetPMMessage]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetPMNotifyInfo]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetPMNotifyInfo]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetParentID]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetParentID]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetPollValues]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetPollValues]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetReConfirmInfo]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetReConfirmInfo]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetSignature]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetSignature]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetSiteStats]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetSiteStats]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetStickyThreads]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetStickyThreads]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetTitles]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetTitles]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserForPM]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserForPM]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserGUIDFROMNTAuth]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserGUIDFROMNTAuth]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserProfile2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserProfile2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetWhoCanPost]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetWhoCanPost]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_LookupLogin]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_LookupLogin]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_MailerVerify]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_MailerVerify]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_MessageTitle]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_MessageTitle]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_MissingEditMessageCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_MissingEditMessageCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_MyNewPMCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_MyNewPMCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_MyPMCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_MyPMCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_SetEncPass]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_SetEncPass]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_SubscribeToForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_SubscribeToForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ThreadCount]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ThreadCount]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_TopListing]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_TopListing]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_TopListing2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_TopListing2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_Unsubscribe]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_Unsubscribe]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UnsubscribeToForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UnsubscribeToForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UpdateOnlineUsers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UpdateOnlineUsers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UpdateOnlineUsers2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UpdateOnlineUsers2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UpdateProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UpdateProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UpdateProfile2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UpdateProfile2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UpdateStats]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UpdateStats]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UserEncLogon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UserEncLogon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UserLogon]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UserLogon]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UserLogon2]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UserLogon2]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_UserNameFromGUID]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_UserNameFromGUID]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ViewProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ViewProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_WhosOnlineNow]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_WhosOnlineNow]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_ActiveVisiting]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_ActiveVisiting]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_AdminActions]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_AdminActions]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_AdminCategory]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_AdminCategory]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_AdminMenuAccess]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_AdminMenuAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_AdminMenuTitles]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_AdminMenuTitles]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Avatars]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Avatars]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_EmailBan]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_EmailBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_EmailNotify]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_EmailNotify]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Emoticons]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Emoticons]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_FilterWords]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_FilterWords]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_ForumCategories]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_ForumCategories]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_ForumSubscribe]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_ForumSubscribe]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Forums]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Forums]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_IPBan]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_IPBan]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Ignored]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Ignored]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_MailConfirm]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_MailConfirm]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Messages]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Messages]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Moderators]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Moderators]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_PollQs]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_PollQs]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_PollVs]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_PollVs]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_PrivateAccess]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_PrivateAccess]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_PrivateMessage]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_PrivateMessage]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Profiles]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Profiles]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Stats]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Stats]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_Titles]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_Titles]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[SMB_UserExperience]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[SMB_UserExperience]
GO

CREATE TABLE [dbo].[SMB_ActiveVisiting] (
	[UserGUID] [uniqueidentifier] NULL ,
	[UserIP] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[LastView] [datetime] NULL ,
	[LastForum] [int] NULL ,
	[tempID] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_AdminActions] (
	[LogID] [int] IDENTITY (1, 1) NOT NULL ,
	[LogDate] [datetime] NOT NULL ,
	[UserID] [int] NOT NULL ,
	[AdminAction] [varchar] (400) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_AdminCategory] (
	[CategoryName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[CategoryID] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_AdminMenuAccess] (
	[UserID] [int] NOT NULL ,
	[MenuID] [int] NOT NULL ,
	[MACID] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_AdminMenuTitles] (
	[MenuTitle] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[MenuID] [int] IDENTITY (1, 1) NOT NULL ,
	[CategoryID] [int] NOT NULL ,
	[MenuOrder] [int] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Avatars] (
	[imageName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[imageID] [int] IDENTITY (1, 1) NOT NULL ,
	[inUseCount] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_EmailBan] (
	[EmailAddress] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[eaid] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_EmailNotify] (
	[ParentMsgID] [int] NULL ,
	[UserGUID] [uniqueidentifier] NULL ,
	[NotifyID] [int] IDENTITY (1, 1) NOT NULL ,
	[NotifySent] [bit] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Emoticons] (
	[imageName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[imageKeys] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[imageID] [int] IDENTITY (1, 1) NOT NULL ,
	[imageAltText] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_FilterWords] (
	[badWord] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[goodWord] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[wordID] [int] IDENTITY (1, 1) NOT NULL ,
	[applyFilter] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_ForumCategories] (
	[CategoryName] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[CategoryID] [int] IDENTITY (1, 1) NOT NULL ,
	[CategoryOrder] [int] NULL ,
	[CategoryDesc] [varchar] (250) COLLATE SQL_Latin1_General_CP1_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_ForumSubscribe] (
	[UserGUID] [uniqueidentifier] NOT NULL ,
	[ForumID] [int] NOT NULL ,
	[tbsid] [int] IDENTITY (1, 1) NOT NULL ,
	[NotifySent] [bit] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Forums] (
	[ForumID] [int] IDENTITY (1, 1) NOT NULL ,
	[ForumName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[ForumDesc] [varchar] (150) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[CategoryID] [int] NOT NULL ,
	[TotalPosts] [int] NULL ,
	[TotalTopics] [int] NULL ,
	[LastPostDate] [datetime] NULL ,
	[LastPostTopic] [int] NULL ,
	[LastPostID] [int] NULL ,
	[IsPrivate] [bit] NULL ,
	[AllowedIDs] [varchar] (402) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[ModeratorUserIDs] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[AccessPermission] [int] NOT NULL ,
	[ForumOrder] [int] NULL ,
	[WhoPost] [int] NULL ,
	[ActiveState] [bit] NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_IPBan] (
	[IPMask] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[IPID] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Ignored] (
	[UserID] [int] NOT NULL ,
	[IgnoreID] [int] NOT NULL ,
	[dateAdded] [datetime] NULL ,
	[iid] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_MailConfirm] (
	[UserGUID] [uniqueidentifier] NOT NULL ,
	[ConfirmGUID] [uniqueidentifier] NOT NULL ,
	[CID] [int] IDENTITY (1, 1) NOT NULL ,
	[DateEntered] [datetime] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Messages] (
	[ForumID] [int] NULL ,
	[MessageID] [int] IDENTITY (1, 1) NOT NULL ,
	[MessageTitle] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[MessageText] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[IsParentMsg] [bit] NULL ,
	[ParentMsgID] [int] NULL ,
	[PostDate] [datetime] NULL ,
	[TotalReplies] [int] NULL ,
	[TotalViews] [int] NULL ,
	[UserGUID] [uniqueidentifier] NULL ,
	[LastReplyDate] [datetime] NULL ,
	[PostIcon] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[IsPoll] [bit] NULL ,
	[PollID] [int] NULL ,
	[VotedAlready] [varchar] (8000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[LastReplyUserID] [uniqueidentifier] NULL ,
	[PostIPAddr] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[TopicLocked] [bit] NULL ,
	[PostAnonymous] [bit] NULL ,
	[LastPostType] [bit] NULL ,
	[EditableText] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[IsSticky] [bit] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Moderators] (
	[userID] [int] NOT NULL ,
	[forumID] [int] NOT NULL ,
	[smbfid] [int] IDENTITY (1, 1) NOT NULL ,
	[adminID] [int] NOT NULL ,
	[dateModified] [datetime] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_PollQs] (
	[messageID] [int] NOT NULL ,
	[pollID] [int] IDENTITY (1, 1) NOT NULL ,
	[pollText] [varchar] (150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[voteCount] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_PollVs] (
	[UserID] [int] NOT NULL ,
	[MessageID] [int] NOT NULL ,
	[PollID] [int] NOT NULL ,
	[DateVoted] [datetime] NOT NULL ,
	[VoteID] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_PrivateAccess] (
	[UserID] [int] NOT NULL ,
	[ForumID] [int] NOT NULL ,
	[DateModified] [datetime] NOT NULL ,
	[AdminID] [int] NOT NULL ,
	[spaID] [int] IDENTITY (1, 1) NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_PrivateMessage] (
	[ToID] [int] NOT NULL ,
	[FromID] [int] NOT NULL ,
	[Subject] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[MessageEdit] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[MessageHTML] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[DateTimeSent] [datetime] NOT NULL ,
	[BeenViewed] [bit] NOT NULL ,
	[umpid] [int] IDENTITY (1, 1) NOT NULL ,
	[IsSentItem] [bit] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Profiles] (
	[RealName] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[UserName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[uPassword] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[euPassword] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[EmailAddress] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[ShowAddress] [int] NULL ,
	[Homepage] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[AIMName] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[ICQNumber] [int] NULL ,
	[TimeOffset] [decimal](10, 0) NULL ,
	[EditableSignature] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[Signature] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[TotalPosts] [int] NULL ,
	[CreateDate] [datetime] NULL ,
	[LastPostDate] [datetime] NULL ,
	[LastPostID] [int] NULL ,
	[LastIPAddress] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[LastLoginDate] [datetime] NULL ,
	[UserID] [int] IDENTITY (1, 1) NOT NULL ,
	[PostAllowed] [int] NULL ,
	[IsGlobalAdmin] [bit] NULL ,
	[IsModerator] [bit] NULL ,
	[UserGUID] [uniqueidentifier] NULL ,
	[MSNM] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[YPager] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[HomeLocation] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[Occupation] [varchar] (150) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[Interests] [text] COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[Avatar] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[UsePM] [bit] NULL ,
	[PMPopUp] [bit] NULL ,
	[PMEmail] [bit] NULL ,
	[PMAdminLock] [bit] NULL ,
	[MailVerify] [bit] NULL ,
	[AdminBan] [bit] NULL ,
	[UserTheme] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[UserTitle] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[NTAuth] [bit] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Stats] (
	[totalPosts] [int] NOT NULL ,
	[totalThreads] [int] NOT NULL ,
	[totalUsers] [int] NOT NULL ,
	[newestUser] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_Titles] (
	[titleID] [int] IDENTITY (1, 1) NOT NULL ,
	[minPosts] [int] NOT NULL ,
	[maxPosts] [int] NOT NULL ,
	[titleText] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[SMB_UserExperience] (
	[eu1] [bit] NOT NULL ,
	[eu2] [bit] NOT NULL ,
	[eu3] [bit] NOT NULL ,
	[eu4] [bit] NOT NULL ,
	[eu5] [bit] NOT NULL ,
	[eu6] [bit] NOT NULL ,
	[eu7] [bit] NOT NULL ,
	[eu8] [bit] NOT NULL ,
	[eu9] [bit] NOT NULL ,
	[eu10] [bit] NOT NULL ,
	[eu11] [int] NOT NULL ,
	[eu12] [bit] NOT NULL ,
	[eu13] [bit] NOT NULL ,
	[eu14] [bit] NOT NULL ,
	[eu15] [bit] NOT NULL ,
	[eu16] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[eu17] [bit] NOT NULL ,
	[eu18] [bit] NOT NULL ,
	[eu19] [bit] NOT NULL ,
	[eu20] [bit] NOT NULL ,
	[eu21] [bit] NOT NULL ,
	[eu22] [bit] NOT NULL ,
	[eu23] [bit] NOT NULL ,
	[eu24] [bit] NOT NULL ,
	[eu25] [varchar] (150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[eu26] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[eu27] [int] NOT NULL ,
	[eu28] [bit] NOT NULL ,
	[eu29] [int] NOT NULL ,
	[eu30] [bit] NOT NULL ,
	[eu31] [decimal](10, 0) NOT NULL ,
	[eu32] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[eu33] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[eu34] [varchar] (400) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
	[eu35] [bit] NULL ,
	[eu36] [bit] NULL ,
	[eu37] [bit] NULL 
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[SMB_ActiveVisiting] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_ActiveVisiting] PRIMARY KEY  CLUSTERED 
	(
		[tempID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_AdminActions] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_AdminActions] PRIMARY KEY  CLUSTERED 
	(
		[LogID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_AdminMenuAccess] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_AdminMenuAccess] PRIMARY KEY  CLUSTERED 
	(
		[MACID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_AdminMenuTitles] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_AdminMenuTitles] PRIMARY KEY  CLUSTERED 
	(
		[MenuID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Avatars] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Avatars] PRIMARY KEY  CLUSTERED 
	(
		[imageID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_EmailBan] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_EmailBan] PRIMARY KEY  CLUSTERED 
	(
		[eaid]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_EmailNotify] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_EmailNotify] PRIMARY KEY  CLUSTERED 
	(
		[NotifyID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Emoticons] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Emoticons] PRIMARY KEY  CLUSTERED 
	(
		[imageID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_FilterWords] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_FilterWords] PRIMARY KEY  CLUSTERED 
	(
		[wordID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_ForumCategories] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_ForumCategories] PRIMARY KEY  CLUSTERED 
	(
		[CategoryID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_ForumSubscribe] WITH NOCHECK ADD 
	CONSTRAINT [PK_TB_ForumSubscribe] PRIMARY KEY  CLUSTERED 
	(
		[tbsid]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Forums] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Forums] PRIMARY KEY  CLUSTERED 
	(
		[ForumID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_IPBan] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_IPBan] PRIMARY KEY  CLUSTERED 
	(
		[IPID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Ignored] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Ignored] PRIMARY KEY  CLUSTERED 
	(
		[iid]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_MailConfirm] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_MailConfirm] PRIMARY KEY  CLUSTERED 
	(
		[CID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Messages] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Messages] PRIMARY KEY  CLUSTERED 
	(
		[MessageID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Moderators] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Moderators] PRIMARY KEY  CLUSTERED 
	(
		[smbfid]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_PollQs] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_PollQs] PRIMARY KEY  CLUSTERED 
	(
		[pollID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_PollVs] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_PollVs] PRIMARY KEY  CLUSTERED 
	(
		[VoteID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_PrivateAccess] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_PrivateAccess] PRIMARY KEY  CLUSTERED 
	(
		[spaID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_PrivateMessage] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_PrivateMessage] PRIMARY KEY  CLUSTERED 
	(
		[umpid]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Profiles] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Profiles] PRIMARY KEY  CLUSTERED 
	(
		[UserID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Titles] WITH NOCHECK ADD 
	CONSTRAINT [PK_SMB_Titles] PRIMARY KEY  CLUSTERED 
	(
		[titleID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [dbo].[SMB_Avatars] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_Avatars_inUseCount] DEFAULT (0) FOR [inUseCount]
GO

ALTER TABLE [dbo].[SMB_Messages] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_Messages_TotalReplies] DEFAULT (0) FOR [TotalReplies],
	CONSTRAINT [DF_SMB_Messages_TotalViews] DEFAULT (0) FOR [TotalViews],
	CONSTRAINT [DF_SMB_Messages_VotedAlready] DEFAULT (0) FOR [VotedAlready],
	CONSTRAINT [DF_SMB_Messages_TopicLocked] DEFAULT (0) FOR [TopicLocked],
	CONSTRAINT [DF_SMB_Messages_PostAnonymous] DEFAULT (0) FOR [PostAnonymous]
GO

ALTER TABLE [dbo].[SMB_PollQs] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_PollQs_voteCount] DEFAULT (0) FOR [voteCount]
GO

ALTER TABLE [dbo].[SMB_PrivateMessage] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_PrivateMessage_BeenViewed] DEFAULT (0) FOR [BeenViewed]
GO

ALTER TABLE [dbo].[SMB_Profiles] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_Profiles_PostAllowed] DEFAULT (0) FOR [PostAllowed]
GO

ALTER TABLE [dbo].[SMB_UserExperience] WITH NOCHECK ADD 
	CONSTRAINT [DF_SMB_UserExperience_eu11] DEFAULT (0) FOR [eu11],
	CONSTRAINT [DF_SMB_UserExperience_eu28] DEFAULT (0) FOR [eu28]
GO



SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_UpdateForumHeader
	@ForumID	INT
AS
DECLARE @LID		INT

UPDATE SMB_Forums
SET TotalPosts = (SELECT COUNT(*) 
                  FROM SMB_Messages
                  WHERE ForumID = @ForumID),
    TotalTopics = (SELECT COUNT(*)
                   FROM SMB_Messages
                   WHERE ForumID = @ForumID
                     AND IsParentMsg = 1)
WHERE ForumID = @ForumID

SET @LID = NULL	-- set to null for process
SET @LID = (SELECT MAX(MessageID) 
            FROM SMB_Messages
            WHERE ForumID = @ForumID)
IF (SELECT IsParentMsg
    FROM SMB_Messages
    WHERE MessageID = @LID) = 0
  BEGIN
    SET @LID = (SELECT ParentMsgID
                FROM SMB_Messages
                WHERE MessageID = @LID)
  END
UPDATE SMB_Forums
SET LastPostTopic = @LID,
    LastPostDate = (SELECT MAX(PostDate)
                    FROM SMB_Messages
                    WHERE ForumID = @ForumID)
WHERE ForumID = @ForumID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_UpdateStats
AS
DECLARE @TP	INT
DECLARE @TT	INT
DECLARE @TU	INT
DECLARE @NU	INT

SET @TP = (SELECT COUNT(messageID) FROM SMB_Messages)
SET @TT = (SELECT COUNT(messageID) FROM SMB_Messages WHERE IsParentMsg = 1)
SET @TU = (SELECT COUNT(UserID) FROM SMB_Profiles)
SET @NU = (SELECT TOP 1 UserID FROM SMB_Profiles WHERE CreateDate = (SELECT MAX(CreateDate) FROM SMB_Profiles))

UPDATE SMB_Stats
SET totalPosts = @TP,
    totalThreads = @TT,
    totalUsers = @TU,
    newestUser = @NU



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO



SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE   PROCEDURE TB_ADMIN_UpdatePrivateUsers
	@UserID		INT,
	@ForumID	INT,
	@AddRemove	INT,
        @UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @AdminID	INT
DECLARE @spaID		INT
SET @AdminID = (SELECT UserID
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @AdminID IS NOT NULL
  BEGIN    
    SET @spaID = (SELECT spaID
                  FROM SMB_PrivateAccess
                  WHERE ForumID = @ForumID
                    AND UserID = @UserID)
    IF @AddRemove = 1		-- Add
      BEGIN
        IF @spaID IS NULL
          BEGIN
            INSERT INTO SMB_PrivateAccess(UserID, ForumID, DateModified, AdminID)
            VALUES(@UserID, @ForumID, GETDATE(), @AdminID)      
          END
      END
    IF @AddRemove = 2
      BEGIN
        DELETE SMB_PrivateAccess
        WHERE ForumID = @ForumID
          AND UserID = @UserID          
      END
  END




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO








SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_AddNewTopic
	@MessageTitle		varchar(100),
	@NotifyUser		int,
	@ForumID		int,
	@PostIcon		varchar(50),
	@MessageText		text,
	@EditText		text,
	@PostIPAddr		varchar(50),
	@UserGUID		uniqueidentifier,
	@MessID			int			OUTPUT

AS

--DECLARE @MessID			int
DECLARE @PostDT 		datetime

SET @PostDT = GETUTCDATE()


--  First Add the post
INSERT INTO SMB_Messages(ForumID,
				MessageTitle,
				MessageText,
				IsParentMsg,
				PostDate,
				PostIcon,
				TotalReplies,
				TotalViews,
				LastReplyDate,				
				LastReplyUserID,
				PostIPAddr,
				UserGUID,
                                EditableText,
                                IsSticky)
VALUES(@ForumID,
	@MessageTitle,
	@MessageText,
	1,
	@PostDT,
	@PostIcon,
	0,
	0,
	@PostDT,
	@UserGUID,
	@PostIPAddr,
	@UserGUID,
        @EditText,
        0)

SET @MessID = (SELECT @@IDENTITY)


-- Update Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = @PostDT,
	LastPostTopic = @MessID
WHERE ForumID = @ForumID


-- Update Posting user profile
UPDATE SMB_Profiles
SET LastPostDate = @PostDT,
	LastPostID = @MessID,
	TotalPosts = TotalPosts + 1	
WHERE UserGUID = @UserGUID


-- Add to mailer if set
IF @NotifyUser = 1 
INSERT INTO SMB_EmailNotify(ParentMsgID, UserGUID)
VALUES(@MessID, @UserGUID)

-- update site stats
EXEC TB_UpdateStats



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ActivateAvatar
	@imageName	VARCHAR(50),
	@goodAdd	INT	OUTPUT
AS
SET @goodAdd = 0
DECLARE @imageID	INT
SET @imageID = (SELECT imageID 
                FROM SMB_Avatars
                WHERE imageName = @imageName)
IF @imageID IS NULL
  BEGIN
    INSERT INTO SMB_Avatars(imageName, inUseCount)
    VALUES(@imageName, 0)
    SET @goodAdd = 1
  END
ELSE
  BEGIN
    SET @goodAdd = 0
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_ActiveAvatars

AS
SELECT imageID, 
       imageName, 
       (SELECT COUNT(Avatar) FROM SMB_Profiles WHERE Avatar = a.imageName)
FROM SMB_Avatars a
ORDER BY imageName



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_ADMIN_ActiveEmoticon
AS
SELECT imageID, 
       imageName,
       imageKeys,
       imageAltText
FROM SMB_Emoticons
ORDER BY imageName, imageKeys



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_AddAuthUserAccount
	@AUTH_USER	VARCHAR(100),
	@UserGUID	UNIQUEIDENTIFIER,
	@UserAdded	INT			OUTPUT,
	@outGUID	UNIQUEIDENTIFIER	OUTPUT
AS
DECLARE @NTExist	BIT
DECLARE @UID		INT
DECLARE @NUID		INT
DECLARE @nGUID		UNIQUEIDENTIFIER

SET @nGUID = NEWID()

SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserName = @AUTH_USER)
IF @UID IS NOT NULL	-- dont allow dup names
  BEGIN
    SET @UserAdded = 0
    SET @outGUID = @UserGUID
  END
ELSE
  BEGIN  
    SET @NTExist = (SELECT NTAuth FROM SMB_Profiles WHERE UserGUID = @UserGUID AND UserName = @AUTH_USER)
    IF @NTExist = 1	-- already exists with nt auth
      BEGIN
        SET @UserAdded = 1
        SET @outGUID = @UserGUID
      END
    ELSE
      BEGIN
        SET @UserAdded = 2
        SET @outGUID = @nGUID
	SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
        INSERT INTO SMB_Profiles(RealName,
                                 UserName,
                                 EmailAddress,
                                 ShowAddress,
                                 HomePage,
                                 AIMName,
                                 ICQNumber,
                                 TimeOffset,
                                 EditableSignature,
                                 Signature,
                                 TotalPosts,
                                 CreateDate,
                                 LastPostDate,
                                 LastPostID,
                                 LastIPAddress,
                                 LastLoginDate,
                                 PostAllowed,
                                 IsGlobalAdmin,
                                 IsModerator,
                                 UserGUID,
                                 MSNM,
                                 YPager,
                                 HomeLocation,
                                 Occupation,
                                 Interests,
                                 Avatar,
                                 UsePM,
                                 PMPopUP,
                                 PMEmail,
                                 PMAdminLock,
                                 MailVerify,
                                 AdminBan,
                                 UserTheme)
        SELECT RealName,
               @AUTH_USER,
               EmailAddress,
               ShowAddress,
               HomePage,
               AIMName,
               ICQNumber,
               TimeOffset,
               EditableSignature,
               Signature,
               0,
               GETUTCDATE(),
               NULL,
               0,
               '',
               GETUTCDATE(),
               PostAllowed,
               IsGlobalAdmin,
               IsModerator,
               @nGUID,
               MSNM,
               YPager,
               HomeLocation,
               Occupation,
               Interests,
               Avatar,
               UsePM,
               PMPopUP,
               PMEmail,
               PMAdminLock,
               MailVerify,
               AdminBan,
               UserTheme 
         FROM SMB_PROFILES 
         WHERE UserID = @UID

         SET @NUID = (SELECT @@IDENTITY)

         INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
         SELECT @NUID, MenuID
         FROM SMB_AdminMenuAccess
         WHERE UserID = @UID

      END
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_AddCategory
	@CategoryName	VARCHAR(50),
	@CategoryDesc	VARCHAR(150)
AS
DECLARE @NM	INT
SET @NM = (SELECT MAX(CategoryOrder) FROM SMB_ForumCategories)
IF @NM IS NULL
  BEGIN
    SET @NM = 0
  END
SET @NM = @NM + 1

INSERT INTO SMB_ForumCategories(CategoryName, CategoryOrder, CategoryDesc)
VALUES(@CategoryName, @NM, @CategoryDesc)


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_AddClonedEmoticon
	@ImageName	VARCHAR(50),
	@ImageKeys	VARCHAR(50),
	@ImageAltText	VARCHAR(50),
	@GoodKey	INT	OUTPUT
AS 
DECLARE @ImageID	INT
SET @ImageID = (SELECT ImageID
                FROM SMB_Emoticons
                WHERE imageKeys = @ImageKeys)
IF @ImageID IS NULL
  BEGIN
    INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
    VALUES(@ImageName, @ImageKeys, @ImageAltText)
    SET @GoodKey = 1
  END
ELSE
  BEGIN
    SET @GoodKey = 0
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_AddEmailBan
	@EmailAddress	VARCHAR(64)
AS
DECLARE @EAID	INT
SET @EAID = (SELECT eaid
             FROM SMB_EmailBan
             WHERE EmailAddress = @EmailAddress)
IF @EAID IS NULL
  BEGIN
    INSERT INTO SMB_EmailBan(EmailAddress)
    VALUES(@EmailAddress)
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_AddFilterWord
	@applyFilter	INT,
	@badWord	VARCHAR(50),
	@goodWord	VARCHAR(50),
	@didAdd		BIT	OUTPUT
AS
DECLARE @WID	INT
SET @WID = (SELECT wordID
            FROM SMB_FilterWords
            WHERE badWord = @badWord)
IF @WID IS NULL
  BEGIN
    SET @didAdd = 1
    INSERT INTO SMB_FilterWords(badWord, goodWord, applyFilter)
    VALUES(@badWord, @goodWord, @applyFilter)
  END
ELSE
  BEGIN
    SET @didAdd = 0
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_AddIPBan
	@IPMask		VARCHAR(16)
AS
DECLARE @IPID	INT
SET @IPID = (SELECT IPID
             FROM SMB_IPBan
             WHERE IPMask = @IPMask)
IF @IPID IS NULL
  BEGIN
    INSERT INTO SMB_IPBan(IPMask)
    VALUES(@IPMask)
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_AddNewForum
	@ForumName		VARCHAR(50),
	@ForumDesc		VARCHAR(150),
	@AccessPermission	INT,
	@CategoryID		INT,
	@WhoPost		INT,
        @UserGUID		UNIQUEIDENTIFIER
AS
DECLARE @UserID		INT
DECLARE @UserStr	VARCHAR(6)
DECLARE @ForumID	INT
DECLARE @IsPrivate	BIT
DECLARE @NextOrder	INT

SET @NextOrder = (SELECT COUNT(ForumID) FROM SMB_Forums WHERE CategoryID = @CategoryID)
IF @NextOrder IS NULL
  BEGIN
    SET @NextOrder = 0
  END

SET @NextOrder = @NextOrder + 1


IF @AccessPermission = 3 
  BEGIN
    SET @IsPrivate = 1
  END
ELSE
  BEGIN
    SET @IsPrivate = 0
  END

INSERT INTO SMB_Forums(ForumName,
                       ForumDesc,
                       TotalPosts,
                       TotalTopics,
                       LastPostDate,
                       LastPostTopic,
                       IsPrivate,
                       AccessPermission,
                       CategoryID,
                       ForumOrder,
                       WhoPost)
VALUES (@ForumName,
        @ForumDesc,
        0,
        0,
        GETUTCDATE(),
        0,
        @IsPrivate,
        @AccessPermission,
        @CategoryID,
        @NextOrder,
        @WhoPost)
SET @ForumID = (SELECT @@IDENTITY)

-- Create welcome posting
DECLARE @NewPostID	int	-- just a placeholder for the new topic posting
EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     @ForumID, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @UserGUID, 
                     @NewPostID

IF @AccessPermission = 3
  BEGIN
    SET @UserID = (SELECT UserID
                   FROM SMB_Profiles
                   WHERE UserGUID = @UserGUID)

    EXEC TB_ADMIN_UpdatePrivateUsers @UserID, @ForumID, 1, @UserGUID
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_AddUserTitle
	@minPosts	INT,
	@maxPosts	INT,
	@titleText	VARCHAR(50),
	@GoodTitle	BIT	OUTPUT
AS 


DECLARE @tID		INT

SET @tID = (SELECT titleID
            FROM SMB_Titles
            WHERE (@minPosts BETWEEN minPosts AND maxPosts)
             OR (@maxPosts BETWEEN minPosts AND maxPosts))

IF @tID IS NULL
  BEGIN
    INSERT INTO SMB_Titles(minPosts, maxPosts, titleText)
    VALUES(@minPosts, @maxPosts, @titleText)
    SET @GoodTitle = 1
  END

ELSE
  BEGIN
    IF (SELECT COUNT(titleText) FROM SMB_Titles) = 1 AND (SELECT TOP 1 titleText FROM SMB_Titles) = 'Registered Member' 
      BEGIN
        DELETE SMB_Titles WHERE titleID = @tID
    
        INSERT INTO SMB_Titles(minPosts, maxPosts, titleText)
        VALUES(@minPosts, @maxPosts, @titleText)
        SET @GoodTitle = 1 
      END

    ELSE
      BEGIN
        SET @GoodTitle = 0 
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_AdminMenuAccess
	@UserID		INT
AS
SELECT MenuID, 
       MenuTitle
FROM SMB_AdminMenuTitles
WHERE MenuID IN (SELECT MenuID
                      FROM SMB_AdminMenuAccess
                      WHERE UserID = @UserID)
ORDER BY CategoryID, MenuOrder
                                   
IF (SELECT COUNT(UserID)
    FROM SMB_AdminMenuAccess
    WHERE UserID = @UserID) > 0
  BEGIN
    UPDATE SMB_Profiles
    SET IsGlobalAdmin = 1
    WHERE UserID = @UserID
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_AllUsers

AS

SELECT UserID, UserName
FROM SMB_Profiles
ORDER BY UserName



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_ApproveMailer
	@UserID		INT
AS
UPDATE SMB_Profiles
SET MailVerify = 1
WHERE UserID = @UserID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_ChangeForumOrder
	@ForumID	INT,
	@MoveVal	INT

AS 

DECLARE @CO		INT
DECLARE @MIO		INT
DECLARE @MAO		INT
DECLARE @CID		INT
SET @CID = (SELECT CategoryID FROM SMB_Forums WHERE ForumID = @ForumID)
SET @MIO = (SELECT MIN(ForumOrder) FROM SMB_Forums WHERE CategoryID = @CID)
SET @MAO = (SELECT MAX(ForumOrder) FROM SMB_Forums WHERE CategoryID = @CID)
SET @CO = (SELECT ForumOrder FROM SMB_Forums WHERE ForumID = @ForumID)

IF @MoveVal = 1
  BEGIN
    IF @CO + @MoveVal <= @MAO
      BEGIN
        UPDATE SMB_Forums
        SET ForumOrder = @CO
        WHERE ForumOrder = @CO + 1
          AND CategoryID = @CID
        UPDATE SMB_Forums
        SET ForumOrder = @CO + 1
        WHERE ForumID = @ForumID
      END
  END
ELSE
  BEGIN
    IF @CO + @MoveVal >= @MIO
      BEGIN
        UPDATE SMB_Forums
        SET ForumOrder = @CO
        WHERE ForumOrder = @CO - 1
          AND CategoryID = @CID
        UPDATE SMB_Forums
        SET ForumOrder = @CO - 1
        WHERE ForumID = @ForumID
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_CheckAdminAccess
	@UserGUID	UNIQUEIDENTIFIER,
	@IsGlobalAdmin	BIT	OUTPUT,
	@IsModerator	BIT	OUTPUT
AS
SET @IsGlobalAdmin = (SELECT IsGlobalAdmin
                      FROM SMB_Profiles
                      WHERE UserGUID = @UserGUID)
SET @IsModerator = (SELECT IsModerator
                      FROM SMB_Profiles
                      WHERE UserGUID = @UserGUID)

SELECT @IsGlobalAdmin, @IsModerator


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO




CREATE   PROCEDURE TB_ADMIN_CheckNameForProfileUpdate
	@UserName	VARCHAR(50),
	@UserID		INT
	
AS
DECLARE @CanUse		BIT
DECLARE @UN		VARCHAR(50)
SET @UN = (SELECT UserName 
           FROM SMB_Profiles
           WHERE UserName = @UserName
             AND UserID != @UserID)
IF @UN IS NULL
  BEGIN
    SET @CanUse = 1
  END
ELSE
  BEGIN
    SET @CanUse = 0
  END

SELECT @CanUse



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DeactivateAllAvatars

AS
DELETE SMB_Avatars


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DeactivateAvatar
	@imageID	INT
AS
DELETE SMB_Avatars
WHERE imageID = @imageID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DeleteCategory
	@CategoryID	INT,
	@tCount		INT	OUTPUT
AS
DECLARE @CO	INT
SET @CO = (SELECT CategoryOrder
           FROM SMB_ForumCategories
           WHERE CategoryID = @CategoryID)

SET @tCount = (SELECT COUNT(ForumID) 
               FROM SMB_Forums 
               WHERE CategoryID = @CategoryID)

IF @tCount = 0
  BEGIN
    DELETE SMB_ForumCategories
    WHERE CategoryID = @CategoryID
    
    UPDATE SMB_ForumCategories
    SET CategoryOrder = CategoryOrder - 1
    WHERE CategoryOrder > @CO
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DeleteFilterWord
	@wordID		INT
AS
DELETE SMB_FilterWords
WHERE wordID = @wordID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_DeleteForum
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @IsAdmin	BIT
SET @IsAdmin = (SELECT IsGlobalAdmin 
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 1
  BEGIN 
    DELETE SMB_Messages
    WHERE ForumID = @ForumID
    
    DELETE SMB_Forums
    WHERE ForumID = @ForumID
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_DeleteUserAndPosts
	@UserID		INT
AS

DECLARE @MessageID	INT
DECLARE @PMessageID	INT
DECLARE @IsP		BIT
DECLARE @LID		INT	-- Last reply ID
DECLARE @FID		INT	-- Forum ID


DECLARE dCurs CURSOR FAST_FORWARD
FOR
SELECT m.MessageID,
       m.ParentMsgID,
       m.IsParentMsg
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
WHERE p.UserID = @UserID
OPEN dCurs
FETCH NEXT FROM dCurs
INTO @MessageID, @PMessageID, @IsP
WHILE @@FETCH_STATUS = 0
  BEGIN
    SET @FID = (SELECT ForumID
                FROM SMB_Messages
                WHERE MessageID = @MessageID)

    IF @IsP = 0 
      BEGIN
        PRINT 'DELETE Message Reply for ' + CAST(@MessageID AS VARCHAR(5))        
        DELETE SMB_Messages
        WHERE MessageID = @MessageID

        PRINT 'UPDATE Parent Thread ' + CAST(@PMessageID AS VARCHAR(5))
        SET @LID = (SELECT MAX(MessageID) 
                    FROM SMB_Messages
                    WHERE ParentMsgID = @PMessageID)
        IF @LID IS NULL	-- no additional replies
          BEGIN
            UPDATE SMB_Messages
            SET LastReplyUserID = UserGUID,
                LastReplyDate = PostDate,
                TotalReplies = 0
            WHERE MessageID = @PMessageID
          END	-- additional replies
        ELSE
          BEGIN
            UPDATE SMB_Messages
            SET LastReplyUserID = (SELECT UserGUID 
                                   FROM SMB_Messages
                                   WHERE MessageID = @LID),
                LastReplyDate = (SELECT PostDate
                                 FROM SMB_Messages
                                 WHERE MessageID = @LID),
                TotalReplies = (SELECT COUNT(*)
                                FROM SMB_Messages
                                WHERE ParentMsgID = @PMessageID)
            WHERE MessageID = @PMessageID
          END  -- no additional replies
      END

    ELSE
      BEGIN
        PRINT 'DELETE Parent Message and Threads for ' + CAST(@MessageID AS VARCHAR(5))
        DELETE SMB_Messages
        WHERE ParentMsgID = @MessageID
          OR MessageID = @MessageID
      END

-- Finished thread now do the forum updates
    UPDATE SMB_Forums
    SET TotalPosts = (SELECT COUNT(*) 
                      FROM SMB_Messages
                      WHERE ForumID = @FID),
        TotalTopics = (SELECT COUNT(*)
                       FROM SMB_Messages
                       WHERE ForumID = @FID
                         AND IsParentMsg = 1)
    WHERE ForumID = @FID

    SET @LID = NULL	-- set to null for process
    SET @LID = (SELECT MAX(MessageID) 
                FROM SMB_Messages
                WHERE ForumID = @FID)
    IF (SELECT IsParentMsg
        FROM SMB_Messages
        WHERE MessageID = @LID) = 0
      BEGIN
        SET @LID = (SELECT ParentMsgID
                    FROM SMB_Messages
                    WHERE MessageID = @LID)
      END
    UPDATE SMB_Forums
    SET LastPostTopic = @LID,
        LastPostDate = (SELECT MAX(PostDate)
                        FROM SMB_Messages
                        WHERE ForumID = @FID)
    WHERE ForumID = @FID

    FETCH NEXT FROM dCurs
    INTO @MessageID, @PMessageID, @IsP
  END
CLOSE dCurs
DEALLOCATE dCurs

DELETE SMB_Profiles
WHERE UserID = @UserID

exec TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_DeleteUserTitle
	@titleID	INT
AS
DELETE SMB_Titles
WHERE titleID = @titleID

IF (SELECT COUNT(*) FROM SMB_Titles) = 0
  BEGIN
    INSERT INTO SMB_Titles(minPosts, maxPosts, titleText)
    VALUES(1, 999999, 'Registered Member')
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DisableEmoticon
	@imageID	INT
AS
DELETE SMB_Emoticons
WHERE imageID = @imageID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_DoThreadPrune
	@ForumID	INT,
	@MinDays	INT
AS
DECLARE @FID		INT

IF @ForumID > 0 
  BEGIN
    DELETE SMB_Messages
    WHERE IsParentMsg = 1 
      AND MessageID NOT IN (SELECT DISTINCT ParentMsgID
                            FROM SMB_Messages
                            WHERE IsParentMsg = 0)
      AND IsSticky = 0
      AND PostDate < DATEADD(day, @MinDays, GETDATE())
      AND ForumID = @ForumID
   
-- update forum header
    EXEC TB_ADMIN_UpdateForumHeader @ForumID
  END
ELSE
  BEGIN

    DELETE SMB_Messages
    WHERE IsParentMsg = 1 
      AND MessageID NOT IN (SELECT DISTINCT ParentMsgID
                            FROM SMB_Messages
                            WHERE IsParentMsg = 0)
      AND IsSticky = 0
      AND PostDate < DATEADD(day, @MinDays, GETDATE())

-- update all forum headers
    DECLARE dCurs CURSOR FAST_FORWARD FOR
      SELECT ForumID
      FROM SMB_Forums
    OPEN dCurs
    FETCH NEXT FROM dCurs
    INTO @FID
    WHILE @@FETCH_STATUS = 0
      BEGIN
        EXEC TB_ADMIN_UpdateForumHeader @FID
        
        FETCH NEXT FROM dCurs
        INTO @FID
      END
    CLOSE dCurs
    DEALLOCATE dCurs
  END

-- update site stats
EXEC TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_EditMenuAccess
	@UserID		INT,
	@MenuID		INT,
	@AddRemove	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID		INT
DECLARE @MACID		INT
SET @UID = (SELECT UserID 
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID
              AND IsGlobalAdmin = 1)
IF @UID IS NOT NULL		-- only global admins can add moderators
  BEGIN
    SET @MACID = (SELECT MACID 
                   FROM SMB_AdminMenuAccess
                   WHERE UserID = @UserID
                     AND MenuID = @MenuID)
    IF @AddRemove = 1 AND @MACID IS NULL    -- dont insert duplicates
      BEGIN
        INSERT INTO SMB_AdminMenuAccess(userID, 
                                   MenuID)
        VALUES(@UserID,
               @MenuID)
     
      END

    IF @AddRemove = 2 AND @MACID IS NOT NULL
      BEGIN
        DELETE SMB_AdminMenuAccess
        WHERE MACID = @MACID
      END
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_EditModeratorAccess
	@UserID		INT,
	@ForumID	INT,
	@AddRemove	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID		INT
DECLARE @smbfid		INT
SET @UID = (SELECT UserID 
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID
              AND IsGlobalAdmin = 1)
IF @UID IS NOT NULL		-- only global admins can add moderators
  BEGIN
    SET @smbfid = (SELECT smbfid 
                   FROM SMB_Moderators
                   WHERE UserID = @UserID
                     AND ForumID = @ForumID)
    IF @AddRemove = 1 AND @smbfid IS NULL    -- dont insert duplicates
      BEGIN
        INSERT INTO SMB_Moderators(userID, 
                                   forumID,
                                   adminID,
                                   dateModified)
        VALUES(@UserID,
               @ForumID,
               @UID,
               GETDATE())
     
      END

    IF @AddRemove = 2 AND @smbfid IS NOT NULL
      BEGIN
        DELETE SMB_Moderators
        WHERE smbfid = @smbfid
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_EditWordFilter
	@wordID		INT,
	@badWord	VARCHAR(50)	OUTPUT,
	@goodWord	VARCHAR(50)	OUTPUT,
	@applyFilter	INT		OUTPUT
AS
SET @badWord = (SELECT badWord
                FROM SMB_FilterWords
                WHERE wordID = @wordID)
SET @goodWord = (SELECT goodWord
                 FROM SMB_FilterWords
                 WHERE wordID = @wordID)
SET @applyFilter = (SELECT applyFilter
                    FROM SMB_FilterWords
                    WHERE wordID = @wordID)

IF @badWord IS NULL
  BEGIN
    SET @badWord = ''
  END
IF @goodWord IS NULL
  BEGIN
    SET @goodWord = ''
  END
IF @applyFilter IS NULL
  BEGIN
    SET @applyFilter = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_EmptyCatgegoryList

AS
SELECT CategoryID,
       CategoryName,
       CategoryDesc
FROM SMB_ForumCategories
WHERE CategoryID NOT IN (SELECT DISTINCT CategoryID FROM SMB_Forums)

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_ADMIN_EnableEmoticon
	@Emoticon	VARCHAR(50)
AS
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES(@Emoticon + '.gif', ':' + @Emoticon + ':', @Emoticon)



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_ForumEditable
	@ForumID	INT
AS
SELECT ForumName,
       ForumDesc,
       AccessPermission,
       CategoryID,
       WhoPost
FROM SMB_Forums
WHERE ForumID = @ForumID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_ForumListForEdit

AS
SELECT  f.ForumID, 
	f.ForumName, 
	f.TotalPosts, 
	f.TotalTopics, 
	f.LastPostDate, 
	f.LastPostTopic, 
	m.MessageTitle,
	m.LastPostType,
	p.UserID,
        p.UserName,
	f.IsPrivate,
        f.ForumDesc,
        f.AccessPermission,
        c.CategoryName,
        c.CategoryDesc,
        (SELECT MAX(MessageID) FROM SMB_Messages WHERE MessageID = f.LastPostTopic OR ParentMsgID = f.LastPostTopic),
        f.ForumOrder,
	(SELECT COUNT(ForumID) FROM SMB_Forums WHERE CategoryID = f.CategoryID), 
        f.CategoryID,
        (SELECT COUNT(CategoryID) FROM SMB_ForumCategories WHERE CategoryID IN (SELECT DISTINCT CategoryID FROM SMB_Forums)),
        f.WhoPost
FROM SMB_Forums f
LEFT JOIN SMB_ForumCategories c
  ON c.CategoryID = f.CategoryID
LEFT JOIN SMB_Messages m
  ON f.LastPostTopic = m.MessageID
LEFT JOIN SMB_Profiles p
  ON m.LastReplyUserID = p.UserGUID
ORDER BY c.CategoryOrder, f.ForumOrder, f.ForumName


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetAdminMenu
	@UserGUID	UNIQUEIDENTIFIER
AS
SELECT m.MenuID,
       t.MenuTitle,
       c.CategoryName
FROM SMB_AdminMenuAccess m
INNER JOIN SMB_AdminMenuTitles t
  ON t.MenuID = m.MenuID
INNER JOIN SMB_AdminCategory c
  ON c.CategoryID = t.CategoryID
INNER JOIN SMB_Profiles p
  ON p.UserID = m.UserID
WHERE p.UserGUID = @UserGUID
ORDER BY c.CategoryName, t.MenuOrder



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetAdminMenuUsers
AS
SELECT m.MenuID,
       t.MenuTitle,
       p.UserID,
       p.UserName,
       p.RealName,
       c.CategoryName
FROM SMB_AdminMenuAccess m
INNER JOIN SMB_AdminMenuTitles t
  ON t.MenuID = m.MenuID
INNER JOIN SMB_Profiles p
  ON p.UserID = m.UserID
INNER JOIN SMB_AdminCategory c
  ON c.CategoryID = t.CategoryID  
ORDER BY p.UserName, c.CategoryID, t.MenuOrder



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetDescriptionForEdit
	@CategoryID	INT
AS
SELECT CategoryID, CategoryName, CategoryDesc
FROM SMB_ForumCategories
WHERE CategoryID = @CategoryID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetEmailBanList
AS
SELECT eaid,
       EmailAddress       
FROM SMB_EmailBan
ORDER BY EmailAddress


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetEmotForEdit
	@ImageID	INT
AS 
SELECT ImageID,
       imageName,
       imageKeys,
       imageAltText
FROM SMB_Emoticons
WHERE imageID = @ImageID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetFilterWords
AS
SELECT wordID,
       badWord,
       goodWord,
       applyFilter
FROM SMB_FilterWords
ORDER BY badWord


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetForEnc
AS
SELECT UserGUID,
       uPassword,
       UserName
FROM SMB_Profiles


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO



CREATE   PROCEDURE TB_ADMIN_GetForumCategories

AS
SELECT c.CategoryID,
       c.CategoryName,
       c.CategoryOrder,
       c.CategoryDesc,
       (SELECT MAX(CategoryOrder) FROM SMB_ForumCategories),
       (SELECT MIN(CategoryOrder) FROM SMB_ForumCategories),
       (SELECT COUNT(ForumID) FROM SMB_Forums WHERE CategoryID = c.CategoryID)
FROM SMB_ForumCategories c
ORDER BY c.CategoryOrder




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetForumTopics
	@ForumID	INT
AS 
SELECT MessageID,
       MessageTitle
FROM SMB_Messages
WHERE ForumID = @ForumID
ORDER BY PostDate DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetIPBanList
AS
SELECT IPID,
       IPMask
FROM SMB_IPBan
ORDER BY IPMask


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetMailerCount
	@SendTo		INT,
	@MCount		INT	OUTPUT
AS
IF @SendTo = 1
  BEGIN
    SET @MCount = (SELECT COUNT(DISTINCT EmailAddress)
                   FROM SMB_Profiles
                   WHERE EmailAddress IS NOT NULL
                     AND EmailAddress != ''
                     AND AdminBan != 1
                     AND MailVerify = 1)
  END  
IF @SendTo = 2
  BEGIN
    SET @MCount = (SELECT COUNT(DISTINCT EmailAddress)
                   FROM SMB_Profiles
                   WHERE EmailAddress IS NOT NULL
                     AND EmailAddress != ''
                     AND IsGlobalAdmin != 1
                     AND IsModerator != 1
                     AND AdminBan != 1
                     AND MailVerify = 1)
  END
IF @SendTo = 3
  BEGIN
    SET @MCount = (SELECT COUNT(DISTINCT EmailAddress)
                   FROM SMB_Profiles
                   WHERE EmailAddress IS NOT NULL
                     AND EmailAddress != ''
                     AND IsModerator = 1
                     AND AdminBan != 1
                     AND MailVerify = 1)

  END
IF @SendTo = 4
  BEGIN
    SET @MCount = (SELECT COUNT(DISTINCT EmailAddress)
                   FROM SMB_Profiles
                   WHERE EmailAddress IS NOT NULL
                     AND EmailAddress != ''
                     AND IsGlobalAdmin = 1
                     AND AdminBan != 1
                     AND MailVerify = 1)
  END
IF @MCount IS NULL
  BEGIN
     SET @MCount = 0
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetMailerInfo
	@SendTo		INT
AS
IF @SendTo = 1
  BEGIN
    SELECT DISTINCT EmailAddress, UserName
    FROM SMB_Profiles
    WHERE EmailAddress IS NOT NULL
      AND EmailAddress != ''
      AND AdminBan != 1
      AND MailVerify = 1
  END  
IF @SendTo = 2
  BEGIN
    SELECT DISTINCT EmailAddress, UserName
    FROM SMB_Profiles
    WHERE EmailAddress IS NOT NULL
      AND EmailAddress != ''
      AND IsGlobalAdmin != 1
      AND IsModerator != 1
      AND AdminBan != 1
      AND MailVerify = 1
  END
IF @SendTo = 3
  BEGIN
    SELECT DISTINCT EmailAddress, UserName
    FROM SMB_Profiles
    WHERE EmailAddress IS NOT NULL
      AND EmailAddress != ''
      AND IsModerator = 1
      AND AdminBan != 1
      AND MailVerify = 1

  END
IF @SendTo = 4
  BEGIN
    SELECT DISTINCT EmailAddress, UserName
    FROM SMB_Profiles
    WHERE EmailAddress IS NOT NULL
      AND EmailAddress != ''
      AND IsGlobalAdmin = 1
      AND AdminBan != 1
      AND MailVerify = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetMenuAccess
	@UserGUID	UNIQUEIDENTIFIER,
	@MenuID		INT,
	@hasAccess	BIT	OUTPUT
AS
DECLARE @MACID		INT
SET @MACID = (SELECT MACID
              FROM SMB_AdminMenuAccess a
              INNER JOIN SMB_Profiles p
                ON p.UserID = a.UserID
              WHERE p.UserGUID = @UserGUID
                AND a.MenuID = @MenuID)
IF @MACID IS NULL
  BEGIN
    SET @hasAccess = 0
  END
ELSE
  BEGIN
    SET @hasAccess = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_GetNonPrivateUsers
	@ForumID	int
AS
SELECT UserID, 
       UserName
FROM SMB_Profiles
WHERE UserID NOT IN (SELECT UserID 
                     FROM SMB_PrivateAccess 
                     WHERE ForumID = @ForumID)
ORDER BY UserName




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetPendingMailers
AS
SELECT p.UserName,
       p.EmailAddress,
       p.UserID
FROM SMB_Profiles p
WHERE MailVerify = 0
 AND (SELECT COUNT(MessageID) FROM SMB_Messages WHERE UserGUID = p.UserGUID) = 0
ORDER BY UserName

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetPollListing
AS
SELECT m.MessageID, 
       m.MessageTitle, 
       m.PostDate,
       f.ForumName,
       (SELECT COUNT(MessageID) FROM SMB_PollVs WHERE MessageID = m.MessageID)
FROM SMB_Messages m
INNER JOIN SMB_Forums f
  ON f.ForumID = m.ForumID
INNER JOIN SMB_ForumCategories c
  ON c.CategoryID = f.CategoryID
WHERE IsPoll = 1
ORDER BY c.CategoryOrder, f.ForumOrder, m.Postdate DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_GetPrivateUsers
	@ForumID	int
AS
SELECT UserID, 
       UserName
FROM SMB_Profiles
WHERE UserID IN (SELECT UserID 
                 FROM SMB_PrivateAccess 
                 WHERE ForumID = @ForumID)
ORDER BY UserName




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_GetTitleForEdit
	@titleID	INT
AS
SELECT minPosts,
       maxPosts,
       titleText
FROM SMB_Titles
WHERE titleID = @titleID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetUserExperience
AS
SELECT eu1,
       eu2,
       eu3,
       eu4,
       eu5,
       eu6,
       eu7,
       eu8,
       eu9,
       eu10,
       eu11,
       eu12,
       eu13,
       eu14,
       eu15,
       eu16,
       eu17,
       eu18,
       eu19,
       eu20,
       eu21,
       eu22,
       eu23,
       eu24,
       eu25,
       eu26,
       eu27,
       eu28,
       eu29,
       eu30,
       eu31,
       eu32,
       eu33,
       eu34,
       eu35,
       eu36
FROM SMB_UserExperience


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetUserForResend
	@UserID		INT,
	@RealName	VARCHAR(100)		OUTPUT,
	@EmailAddress	VARCHAR(64)		OUTPUT,
	@mGUID		UNIQUEIDENTIFIER	OUTPUT
AS
SET @RealName = (SELECT RealName FROM SMB_Profiles WHERE UserID = @UserID)
SET @EmailAddress = (SELECT EmailAddress FROM SMB_Profiles WHERE UserID = @UserID)
SET @mGUID = (SELECT COnfirmGUID FROM SMB_MailConfirm WHERE UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserID = @UserID))
IF @RealName IS NULL
  BEGIN
   SET @RealName = ''
  END
IF @mGUID IS NULL
  BEGIN
   SET @mGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END
IF @EmailAddress IS NULL
  BEGIN
   SET @EmailAddress = ''
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE      PROCEDURE TB_ADMIN_GetUserProfile
	@UserID		INT
AS
SELECT RealName,
       UserName,
       euPassword,
       EmailAddress,
       ShowAddress,
       HomePage,
       AIMName,
       ICQNumber,
       TimeOffset,
       EditableSignature,
       Signature,
       Avatar,
       MSNM,
       YPager,
       HomeLocation,
       Occupation,
       Interests,
       UsePM,
       PMPopUp,
       PMEmail,
       PMAdminLock,
       MailVerify,
       AdminBan
FROM SMB_Profiles
WHERE UserID = @UserID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetWhoVoted
	@MessageID	INT
AS
SELECT UserName
FROM SMB_Profiles
WHERE UserID IN (SELECT UserID FROM SMB_PollVs WHERE MessageID = @MessageID)

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ListModerators
AS
SELECT p.RealName,
       p.UserName,
       f.ForumName,
       m.UserID
FROM SMB_Moderators m
INNER JOIN SMB_Profiles p
  ON p.UserID = m.UserID
INNER JOIN SMB_Forums f
  ON f.ForumID = m.ForumID
ORDER BY UserName, ForumName
      


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ListTitles
AS
SELECT titleID,
       minPosts,
       maxPosts,
       titleText
FROM SMB_Titles
ORDER BY minPosts


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_LockThread
	@ForumID	INT,
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @CanLock	BIT
SET @CanLock = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @CanLock = 0
  BEGIN
  IF (SELECT m.smbfid
      FROM SMB_Moderators m
      INNER JOIN SMB_Profiles p
        ON p.UserID = m.UserID
      WHERE p.UserGUID = @UserGUID
        AND ForumID = @ForumID) IS NOT NULL
    BEGIN
     SET @CanLock = 1
    END
  ELSE
    BEGIN
      SET @CanLock = 0
    END
  END

IF @CanLock = 1
  BEGIN
    UPDATE SMB_Messages
    SET TopicLocked = 1
    WHERE ForumID = @ForumID
      AND MessageID = @MessageID

  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_LogAction
	@UserGUID	UNIQUEIDENTIFIER,
	@AdminAction	VARCHAR(400)
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
IF @UID IS NOT NULL
  BEGIN
    INSERT INTO SMB_AdminActions(LogDate, UserID, AdminAction)
    VALUES(GETUTCDATE(), @UID, @AdminAction)
  END
ELSE
  BEGIN
    INSERT INTO SMB_AdminActions(LogDate, UserID, AdminAction)
    VALUES(GETUTCDATE(), 1, @AdminAction)
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_MakeNonSticky
	@MessageID	INT
AS
UPDATE SMB_Messages
SET IsSticky = 0
WHERE MessageID = @MessageID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_MakeSticky
	@MessageID	INT
AS
UPDATE SMB_Messages
SET IsSticky = 1
WHERE MessageID = @MessageID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_ModerateAccess
	@UserID		INT
AS
SELECT ForumID, 
               ForumName
FROM SMB_Forums
WHERE ForumID IN (SELECT ForumID
                      FROM SMB_Moderators
                      WHERE UserID = @UserID)
                                   
UPDATE SMB_Profiles
SET IsModerator = 1
WHERE UserID = @UserID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE   PROCEDURE TB_ADMIN_ModerateForums
	@UserGUID	UNIQUEIDENTIFIER
AS

DECLARE @IsAdmin	BIT
DECLARE @UID		INT
SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 0
  BEGIN
  SET @UID = (SELECT UserID 
              FROM SMB_Profiles
              WHERE UserGUID = @UserGUID)
  IF @UID IS NOT NULL
    BEGIN
      SELECT f.ForumID,
            f.ForumName
      FROM SMB_Forums f
      INNER JOIN SMB_Moderators m
        ON m.forumID = f.ForumID
      WHERE m.UserID = @UID
      ORDER BY IsPrivate, ForumName
    PRINT @UID
    END
  END

IF @IsAdmin = 1
  BEGIN
    SELECT ForumID,
           ForumName
    FROM SMB_Forums
    ORDER BY IsPrivate, ForumName
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_ModerateLockedThreads
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS

DECLARE @IsAdmin	BIT

SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 0
  BEGIN
    SELECT m.MessageID,
           m.MessageTitle
    FROM SMB_Messages m
    INNER JOIN SMB_Moderators mo
      ON mo.forumID = m.ForumID
    INNER JOIN SMB_Profiles p
      ON p.UserID = mo.userID
    WHERE p.UserGUID = @UserGUID
      AND m.IsParentMsg = 1
      AND m.ForumID = @ForumID
      AND TopicLocked = 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END

IF @IsAdmin = 1
  BEGIN
    SELECT MessageID,
           MessageTitle
    FROM SMB_Messages
    WHERE ForumID = @ForumID
      AND IsParentMsg = 1
      AND TopicLocked = 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END





GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO




CREATE   PROCEDURE TB_ADMIN_ModerateNonStickyThreads
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS

DECLARE @IsAdmin	BIT

SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 0
  BEGIN
    SELECT m.MessageID,
           m.MessageTitle
    FROM SMB_Messages m
    INNER JOIN SMB_Moderators mo
      ON mo.forumID = m.ForumID
    INNER JOIN SMB_Profiles p
      ON p.UserID = mo.userID
    WHERE p.UserGUID = @UserGUID
      AND m.IsParentMsg = 1
      AND m.ForumID = @ForumID
      AND IsSticky != 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END

IF @IsAdmin = 1
  BEGIN
    SELECT MessageID,
           MessageTitle
    FROM SMB_Messages
    WHERE ForumID = @ForumID
      AND IsParentMsg = 1
      AND IsSticky != 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END






GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_ModerateStickyThreads
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS

DECLARE @IsAdmin	BIT

SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 0
  BEGIN
    SELECT m.MessageID,
           m.MessageTitle
    FROM SMB_Messages m
    INNER JOIN SMB_Moderators mo
      ON mo.forumID = m.ForumID
    INNER JOIN SMB_Profiles p
      ON p.UserID = mo.userID
    WHERE p.UserGUID = @UserGUID
      AND m.IsParentMsg = 1
      AND m.ForumID = @ForumID
      AND IsSticky = 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END

IF @IsAdmin = 1
  BEGIN
    SELECT MessageID,
           MessageTitle
    FROM SMB_Messages
    WHERE ForumID = @ForumID
      AND IsParentMsg = 1
      AND IsSticky = 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END





GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ModerateUnlockedThreads
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS

DECLARE @IsAdmin	BIT

SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 0
  BEGIN
    SELECT m.MessageID,
           m.MessageTitle
    FROM SMB_Messages m
    INNER JOIN SMB_Moderators mo
      ON mo.forumID = m.ForumID
    INNER JOIN SMB_Profiles p
      ON p.UserID = mo.userID
    WHERE p.UserGUID = @UserGUID
      AND m.IsParentMsg = 1
      AND m.ForumID = @ForumID
      AND TopicLocked != 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END

IF @IsAdmin = 1
  BEGIN
    SELECT MessageID,
           MessageTitle
    FROM SMB_Messages
    WHERE ForumID = @ForumID
      AND IsParentMsg = 1
      AND TopicLocked != 1
    ORDER BY LastReplyDate DESC, PostDate DESC
  END




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ModifyUserTitle
	@minPosts	INT,
	@maxPosts	INT,
	@titleText	VARCHAR(50),
	@titleID	INT,
	@GoodTitle	BIT	OUTPUT
AS 


DECLARE @tID		INT

SET @tID = (SELECT titleID
            FROM SMB_Titles
            WHERE (@minPosts BETWEEN minPosts AND maxPosts
             OR @maxPosts BETWEEN minPosts AND maxPosts)
             AND titleID != @titleID)
IF @tID IS NULL
  BEGIN
    UPDATE SMB_Titles
    SET minPosts = @minPosts,
        maxPosts = @maxPosts,
        titleText = @titleText
    WHERE titleID = @titleID
    SET @GoodTitle = 1
  END

ELSE
  BEGIN
    SET @GoodTitle = 0
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_MoveCategory
	@CategoryID	INT,
	@MoveVal	INT

AS 

DECLARE @CO		INT
DECLARE @MIO		INT
DECLARE @MAO		INT

SET @MIO = (SELECT MIN(CategoryOrder) FROM SMB_ForumCategories)
SET @MAO = (SELECT MAX(CategoryOrder) FROM SMB_ForumCategories)
SET @CO = (SELECT CategoryOrder FROM SMB_ForumCategories WHERE CategoryID = @CategoryID)

IF @MoveVal = 1
  BEGIN
    IF @CO + @MoveVal <= @MAO
      BEGIN
        UPDATE SMB_ForumCategories
        SET CategoryOrder = @CO
        WHERE CategoryOrder = @CO + 1
        UPDATE SMB_ForumCategories
        SET CategoryOrder = @CO + 1
        WHERE CategoryID = @CategoryID
      END
  END
ELSE
  BEGIN
    IF @CO + @MoveVal >= @MIO
      BEGIN
        UPDATE SMB_ForumCategories
        SET CategoryOrder = @CO
        WHERE CategoryOrder = @CO - 1
        UPDATE SMB_ForumCategories
        SET CategoryOrder = @CO - 1
        WHERE CategoryID = @CategoryID
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_MoveThread
	@ForumID	INT,
	@MessageID	INT
AS 
DECLARE @FID	INT

SET @FID = (SELECT ForumID FROM SMB_Messages WHERE MessageID = @MessageID)

UPDATE SMB_Messages
SET ForumID = @ForumID
WHERE MessageID = @MessageID
  OR ParentMsgId = @MessageID


-- Update New Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = (SELECT Max(PostDate) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostTopic = (SELECT Max(MessageID) FROM SMB_Messages WHERE ForumID = @ForumID)
WHERE ForumID = @ForumID

-- Update old Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @FID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @FID),
	LastPostDate = (SELECT Max(PostDate) FROM SMB_Messages WHERE ForumID = @FID),
	LastPostTopic = (SELECT Max(MessageID) FROM SMB_Messages WHERE ForumID = @FID)
WHERE ForumID = @FID

-- update site stats
EXEC TB_UpdateStats

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_NoAdminMenuAccess
	@UserID		INT
AS
SELECT MenuID, 
       MenuTitle
FROM SMB_AdminMenuTitles
WHERE MenuID NOT IN (SELECT MenuID
                      FROM SMB_AdminMenuAccess
                      WHERE UserID = @UserID)
ORDER BY CategoryID, MenuOrder
                                   
IF (SELECT COUNT(UserID)
    FROM SMB_AdminMenuAccess
    WHERE UserID = @UserID) = 0
  BEGIN
    UPDATE SMB_Profiles
    SET IsGlobalAdmin = 0
    WHERE UserID = @UserID
  END
ELSE
  BEGIN
    UPDATE SMB_Profiles
    SET IsGlobalAdmin = 1
    WHERE UserID = @UserID
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_NonAdminUsers

AS

SELECT UserID, UserName
FROM SMB_Profiles
WHERE IsGlobalAdmin = 0
ORDER BY UserName


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_ADMIN_NonModerateAccess
	@UserID		INT
AS
SELECT ForumID, 
               ForumName
FROM SMB_Forums
WHERE ForumID NOT IN (SELECT ForumID
                      FROM SMB_Moderators
                      WHERE UserID = @UserID)
                                   
IF (SELECT COUNT(UserID)
    FROM SMB_Moderators
    WHERE UserID = @UserID) = 0
  BEGIN
    UPDATE SMB_Profiles
    SET IsModerator = 0
    WHERE UserID = @UserID
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_PrivateForumDropListing

AS

SELECT ForumID, 
       ForumName, 
       IsPrivate
FROM SMB_FORUMS
WHERE IsPrivate = 1
ORDER BY ForumName




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_ADMIN_ProfileList
	@FilterChar	VARCHAR(1)
AS
IF @FilterChar = '*'
  BEGIN
    SELECT UserID,
           RealName,
           UserName,
           EmailAddress,
           IsGlobalAdmin,
           IsModerator
    FROM SMB_Profiles
    WHERE UPPER(LEFT(UserName, 1)) NOT BETWEEN 'A' AND 'Z'
    ORDER BY UserName


  END
IF @FilterChar = '1'
  BEGIN
    SELECT UserID,
           RealName,
           UserName,
           EmailAddress,
           IsGlobalAdmin,
           IsModerator
    FROM SMB_Profiles
    WHERE IsGlobalAdmin != 1
      AND IsModerator != 1
    ORDER BY UserName
  END
IF @FilterChar = '2'
  BEGIN
    SELECT UserID,
           RealName,
           UserName,
           EmailAddress,
           IsGlobalAdmin,
           IsModerator
    FROM SMB_Profiles
    WHERE IsModerator = 1
    ORDER BY UserName
  END
IF @FilterChar = '3'
  BEGIN
    SELECT UserID,
           RealName,
           UserName,
           EmailAddress,
           IsGlobalAdmin,
           IsModerator
    FROM SMB_Profiles
    WHERE IsGlobalAdmin = 1
    ORDER BY UserName
  END
ELSE
  BEGIN
    SELECT UserID,
           RealName,
           UserName,
           EmailAddress,
           IsGlobalAdmin,
           IsModerator
    FROM SMB_Profiles
    WHERE UPPER(LEFT(UserName, 1)) = @FilterChar
    ORDER BY UserName
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_RemoveEmailBan
	@EAID	INT
AS
DELETE SMB_EmailBan
WHERE EAID = @EAID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_RemoveIPBan
	@IPID	INT
AS
DELETE SMB_IPBan
WHERE IPID = @IPID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_ThreadPruneCheck
	@ForumID	INT,
	@MinDays	INT,
	@ForumName	VARCHAR(50) 	OUTPUT,
	@ThreadCount	INT		OUTPUT
AS

IF @ForumID > 0 
  BEGIN
    SET @ThreadCount = (SELECT COUNT(*)
                        FROM SMB_Messages
                        WHERE IsParentMsg = 1 
                          AND MessageID NOT IN (SELECT DISTINCT ParentMsgID
                                                FROM SMB_Messages
                                                WHERE IsParentMsg = 0)
                          AND IsSticky = 0
                          AND PostDate < DATEADD(day, @MinDays, GETDATE())
                          AND ForumID = @ForumID)
    SET @ForumName = (SELECT ForumName
                      FROM SMB_Forums
                      WHERE ForumID = @ForumID)
  END
ELSE
  BEGIN
    SET @ThreadCount = (SELECT COUNT(*)
                        FROM SMB_Messages
                        WHERE IsParentMsg = 1 
                          AND MessageID NOT IN (SELECT DISTINCT ParentMsgID
                                                FROM SMB_Messages
                                                WHERE IsParentMsg = 0)
                          AND IsSticky = 0
                          AND PostDate < DATEADD(day, @MinDays, GETDATE()))
    SET @ForumName = 'All Forums'
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_UnLockThread
	@ForumID	INT,
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @CanLock	BIT
SET @CanLock = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @CanLock = 0
  BEGIN
  IF (SELECT m.smbfid
      FROM SMB_Moderators m
      INNER JOIN SMB_Profiles p
        ON p.UserID = m.UserID
      WHERE p.UserGUID = @UserGUID
        AND ForumID = @ForumID) IS NOT NULL
    BEGIN
     SET @CanLock = 1
    END
  ELSE
    BEGIN
      SET @CanLock = 0
    END
  END

IF @CanLock = 1
  BEGIN
    UPDATE SMB_Messages
    SET TopicLocked = 0
    WHERE ForumID = @ForumID
      AND MessageID = @MessageID

  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_UpdateCategory
	@CategoryName	VARCHAR(50),
	@CategoryDesc	VARCHAR(150),
	@CategoryID	INT
AS
UPDATE SMB_ForumCategories
SET CategoryName = @CategoryName,
    CategoryDesc = @CategoryDesc
WHERE CategoryID = @CategoryID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_UpdateEmoticon
	@ImageID	INT,
	@ImageName	VARCHAR(50),
	@ImageKeys	VARCHAR(50),
	@ImageAltText	VARCHAR(50)
AS 
UPDATE SMB_Emoticons
SET imageName = @ImageName,
    imageKeys = @ImageKeys,
    imageAltText = @ImageAltText
WHERE imageID = @ImageID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ADMIN_UpdateFilterWord
	@wordID		INT,
	@applyFilter	INT,
	@badWord	VARCHAR(50),
	@goodWord	VARCHAR(50),
	@didAdd		BIT	OUTPUT
AS
DECLARE @WID	INT
SET @WID = (SELECT wordID
            FROM SMB_FilterWords
            WHERE badWord = @badWord
              AND wordID != @wordID)
IF @WID IS NULL
  BEGIN
    SET @didAdd = 1
    UPDATE SMB_FilterWords
    SET badWord = @badWord,
        goodWord = @goodWord,
        applyFilter = @applyFilter
    WHERE wordID = @wordID  
  END
ELSE
  BEGIN
    SET @didAdd = 0
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_UpdateForum
        @ForumID		INT,
	@ForumName		VARCHAR(50),
	@ForumDesc		VARCHAR(150),
 	@AccessPermission	INT,
	@CategoryID		INT,
	@WhoPost		INT,
	@UserGUID		UNIQUEIDENTIFIER
AS
DECLARE @IsAdmin	BIT
DECLARE @AllowedIDs	INT
DECLARE @hasAccess	INT
DECLARE @UserID		INT
DECLARE @UserStr	VARCHAR(6)

SET @IsAdmin = (SELECT IsGlobalAdmin 
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
SET @UserID = (SELECT UserID
               FROM SMB_Profiles
               WHERE UserGUID = @UserGUID)

IF @IsAdmin = 0
  BEGIN
    SET @hasAccess = (SELECT MACID
                      FROM SMB_AdminMenuAccess
                      WHERE UserID = @UserID
                        AND MenuID = 3)
    IF @hasAccess IS NOT NULL
      BEGIN
        SET @IsAdmin = 1
      END
  END

IF @IsAdmin = 1
  BEGIN 
    UPDATE SMB_Forums
    SET ForumName = @ForumName,
        ForumDesc = @ForumDesc,
        CategoryID = @CategoryID,
        AccessPermission = @AccessPermission,
	WhoPost = @WhoPost
    WHERE ForumID = @ForumID
    IF @AccessPermission = 3
      BEGIN
        UPDATE SMB_Forums
        SET IsPrivate = 1
        WHERE ForumID = @ForumID     

        SET @AllowedIDs = (SELECT spaID
                           FROM SMB_PrivateAccess
                           WHERE ForumID = @ForumID
                             AND UserID = @UserID)
        IF @AllowedIDs IS NULL 
          BEGIN
            INSERT INTO SMB_PrivateAccess(UserID, ForumID, DateModified, AdminID)
            VALUES(@UserID, @ForumID, GETDATE(), @UserID)
          END
      END
    ELSE
      BEGIN
        UPDATE SMB_Forums
        SET IsPrivate = 0
        WHERE ForumID = @ForumID
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_UpdateNonPrivateUsers
	@AllowedIDs	VARCHAR(402),
	@ForumID	INT
AS
UPDATE SMB_Forums
SET AllowedIDs = @AllowedIDs
WHERE ForumID = @ForumID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE       PROCEDURE TB_ADMIN_UpdateProfile
	@RealName	VARCHAR(100),
	@UserName	VARCHAR(50),
	@euPassword	VARCHAR(100),
	@EmailAddress	VARCHAR(64),
	@ShowAddress	INT,
	@Homepage	VARCHAR(200),
	@AIMName	VARCHAR(100),
	@ICQNumber	INT,
	@TimeOffset	INT,
	@EditSignature	TEXT,
	@Signature	TEXT,
	@UserID		INT,
	@Avatar		VARCHAR(200),
	@MSNM		VARCHAR(64),
	@YPager		VARCHAR(50),
	@HomeLocation	VARCHAR(100),
	@Occupation	VARCHAR(150),
	@Interests	TEXT,
	@UsePM		BIT,
	@PMPopUp	BIT,
	@PMEmail	BIT,
	@PMAdminLock	BIT,
	@MailVerify	BIT,
	@AdminBan	BIT

AS
UPDATE SMB_Profiles
SET RealName = @RealName,
    UserName = @UserName,
    euPassword = @euPassword,
    EmailAddress = @EmailAddress,
    ShowAddress = @ShowAddress,
    HomePage = @HomePage,
    AIMName = @AIMName,
    ICQNumber = @ICQNumber,
    TimeOffset = @TimeOffset,
    EditableSignature = @EditSignature,
    Signature = @Signature,
    Avatar = @Avatar,
    MSNM = @MSNM,
    YPager = @YPager,
    HomeLocation = @HomeLocation,
    Occupation = @Occupation,
    Interests = @Interests,
    UsePM = @UsePM,
    PMPopUp = @PMPopUp,
    PMEmail = @PMEmail,
    PMAdminLock = @PMAdminLock,
    MailVerify = @MailVerify,
    AdminBan = @AdminBan
WHERE UserID = @UserID




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_UpdateUserExperience
	@eu1	BIT,
	@eu2	BIT,
	@eu3	BIT,
	@eu4	BIT,
	@eu5	BIT,
	@eu6	BIT,
	@eu7	BIT,
	@eu8	BIT,
	@eu9	BIT,
	@eu10	BIT,
	@eu11	INT,
	@eu12	BIT,
	@eu13	BIT,
	@eu14	BIT,
	@eu15	BIT,
	@eu16	VARCHAR(10),
	@eu17	BIT,
	@eu18	BIT,
	@eu19	BIT,
	@eu20	BIT,
	@eu21	BIT,
	@eu22	BIT,
	@eu23	BIT,
	@eu24	BIT,
	@eu25	VARCHAR(150),
	@eu26	VARCHAR(200),
	@eu27	INT,
	@eu28	BIT,
	@eu29	INT,
	@eu30	BIT,
	@eu32	VARCHAR(50),
	@eu33	VARCHAR(50),
	@eu34	VARCHAR(400),
	@eu35	BIT,
	@eu36	BIT

AS
UPDATE SMB_UserExperience
SET eu1 = @eu1,
       eu2 = @eu2,
       eu3 = @eu3,
       eu4 = @eu4,
       eu5 = @eu5,
       eu6 = @eu6,
       eu7 = @eu7,
       eu8 = @eu8,
       eu9 = @eu9,
       eu10 = @eu10,
       eu11 = @eu11,
       eu12 = @eu12,
       eu13 = @eu13,
       eu14 = @eu14,
       eu15 = @eu15,
       eu16 = @eu16,
       eu17 = @eu17,
       eu18 = @eu18,
       eu19 = @eu19,
       eu20 = @eu20,
       eu21 = @eu21,
       eu22 = @eu22,
       eu23 = @eu23,
       eu24 = @eu24,
       eu25 = @eu25,
       eu26 = @eu26,
       eu27 = @eu27,
       eu28 = @eu28,
       eu29 = @eu29,
       eu30 = @eu30,
       eu32 = @eu32,
       eu33 = @eu33,
       eu34 = @eu34,
       eu35 = @eu35,
       eu36 = @eu36


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ActiveAvatars

AS
SELECT imageName
FROM SMB_Avatars
ORDER BY imageName



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ActiveEmoticon
AS
SELECT imageName,
       imageKeys,
       imageAltText
FROM SMB_Emoticons
ORDER BY imageName, imageKeys



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_AddNewPM
	@ToName		VARCHAR(50),
	@UserGUID	UNIQUEIDENTIFIER,
	@Subject	VARCHAR(100),
	@MessageEdit	TEXT,
	@MessageHTML	TEXT,
	@MessageID	INT	OUTPUT
	
AS

DECLARE @UID		INT
DECLARE @UID2		INT
DECLARE @DTN		DATETIME
SET @DTN = GETUTCDATE()
SET @UID = (SELECT UserID
            FROM SMB_Profiles
            WHERE UserName = @ToName)
SET @UID2 = (SELECT UserID
             FROM SMB_Profiles
             WHERE UserGUID = @UserGUID)

IF @UID IS NOT NULL AND @UID2 IS NOT NULL
  BEGIN
    -- to the inbox
    INSERT INTO SMB_PrivateMessage(ToID, FromID, Subject, MessageEdit, MessageHTML, 
                                    DateTimeSent, BeenViewed, IsSentItem)
    VALUES(@UID, @UID2, @Subject, @MessageEdit, @MessageHTML, GETUTCDATE(), 0, 0)
    SET @MessageID = (SELECT @@IDENTITY)
    -- to the sent items
    INSERT INTO SMB_PrivateMessage(ToID, FromID, Subject, MessageEdit, MessageHTML, 
                                    DateTimeSent, BeenViewed, IsSentItem)
    VALUES(@UID, @UID2, @Subject, @MessageEdit, @MessageHTML, GETUTCDATE(), 1, 1)

  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_AddNewPollTopic
	@MessageTitle		varchar(100),
	@NotifyUser		int,
	@ForumID		int,
	@PostIcon		varchar(50),
	@MessageText		text,
	@EditText		text,
	@PostIPAddr		varchar(50),
	@UserGUID		uniqueidentifier,
	@MessID			int			OUTPUT

AS

--DECLARE @MessID			int
DECLARE @PostDT 		datetime

SET @PostDT = GETUTCDATE()


--  First Add the post
INSERT INTO SMB_Messages(ForumID,
				MessageTitle,
				MessageText,
				IsParentMsg,
				PostDate,
				PostIcon,
				TotalReplies,
				TotalViews,
				LastReplyDate,				
				LastReplyUserID,
				PostIPAddr,
				UserGUID,
                                EditableText,
                                IsSticky,
                                IsPoll)
VALUES(@ForumID,
	@MessageTitle,
	@MessageText,
	1,
	@PostDT,
	@PostIcon,
	0,
	0,
	@PostDT,
	@UserGUID,
	@PostIPAddr,
	@UserGUID,
        @EditText,
        0,
        1)

SET @MessID = (SELECT @@IDENTITY)


-- Update Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = @PostDT,
	LastPostTopic = @MessID
WHERE ForumID = @ForumID


-- Update Posting user profile
UPDATE SMB_Profiles
SET LastPostDate = @PostDT,
	LastPostID = @MessID,
	TotalPosts = TotalPosts + 1	
WHERE UserGUID = @UserGUID


-- Add to mailer if set
IF @NotifyUser = 1 
INSERT INTO SMB_EmailNotify(ParentMsgID, UserGUID)
VALUES(@MessID, @UserGUID)

-- update site stats
EXEC TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_AddNewProfile
	@RealName		VARCHAR(100),
	@UserName		VARCHAR(100),
	@uPassword		VARCHAR(100),
	@EmailAddress		VARCHAR(100),
	@ShowAddress		INT,
	@HomePage		VARCHAR(200),
	@AIMName		VARCHAR(100),
	@ICQNumber		INT,
	@TimeOffset		INT,
	@Signature		TEXT,
	@EditSignature		TEXT,
	@MSNM			VARCHAR(64) = NULL,
	@YPager			VARCHAR(50) = NULL,
	@HomeLocation		VARCHAR(100) = NULL,
	@Occupation		VARCHAR(150) = NULL,
	@Interests		TEXT = NULL,
	@Avatar			VARCHAR(200) = NULL,
	@UserTheme		VARCHAR(50) = NULL,
	@UsePM			BIT = 1,
	@PMPopUp		BIT = 1,
	@PMEmail		BIT = 1,
	@MailVerify		BIT = 1,
	@CID			UNIQUEIDENTIFIER	OUTPUT
AS
DECLARE @NID	UNIQUEIDENTIFIER

SET @NID = NEWID()
SET @CID = NEWID()
IF @MailVerify = 0
  BEGIN
    INSERT INTO SMB_MailConfirm(UserGUID, ConfirmGUID, DateEntered)
    VALUES(@NID, @CID, GETUTCDATE())
  END

INSERT INTO SMB_Profiles(RealName, 
			UserName, 
			uPassword, 
			EmailAddress, 
			ShowAddress, 
			HomePage, 
			AIMName, 
			ICQNumber, 
			TimeOffset, 
			EditableSignature,
			Signature,
			TotalPosts,
			PostAllowed,
			IsGlobalAdmin,
			CreateDate,
			LastLoginDate,
			UserGUID,
			MSNM,
			YPager,
			HomeLocation,
			Occupation,
			Interests,
                        Avatar,
                        UsePM,
                        PMPopUP,
                        PMEmail,
                        PMAdminLock,                         
                        MailVerify,
                        UserTheme,
                        AdminBan)

VALUES(@RealName, 
	@UserName, 
	@uPassword, 
	@EmailAddress, 
	@ShowAddress, 
	@HomePage, 
	@AIMName, 
	@ICQNumber, 
	@TimeOffset, 
	@EditSignature,
	@Signature,
	0,
	1,
	0,
	GETUTCDATE(),
	GETUTCDATE(),
	@NID,
	@MSNM,
	@YPager,
	@HomeLocation,
	@Occupation,
	@Interests,
        @Avatar,
        @UsePM,
        @PMPopUP,
	@PMEmail,
        1,
        @MailVerify,
	@UserTheme,
        0)


-- update site stats
EXEC TB_UpdateStats




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_AddNewProfile2
	@RealName		VARCHAR(100),
	@UserName		VARCHAR(50),
	@euPassword		VARCHAR(100),
	@EmailAddress		VARCHAR(64),
	@ShowAddress		INT,
	@HomePage		VARCHAR(200),
	@AIMName		VARCHAR(100),
	@ICQNumber		INT,
	@TimeOffset		INT,
	@Signature		TEXT,
	@EditSignature		TEXT,
	@MSNM			VARCHAR(64) = NULL,
	@YPager			VARCHAR(50) = NULL,
	@HomeLocation		VARCHAR(100) = NULL,
	@Occupation		VARCHAR(150) = NULL,
	@Interests		TEXT = NULL,
	@Avatar			VARCHAR(200) = NULL,
	@UserTheme		VARCHAR(50) = NULL,
	@UsePM			BIT = 1,
	@PMPopUp		BIT = 1,
	@PMEmail		BIT = 1,
	@MailVerify		BIT = 1,
	@NTAuth			BIT = 0,
	@CID			UNIQUEIDENTIFIER	OUTPUT,
	@NID			UNIQUEIDENTIFIER	OUTPUT
AS
SET @NID = NEWID()
SET @CID = NEWID()
IF @MailVerify = 0
  BEGIN
    INSERT INTO SMB_MailConfirm(UserGUID, ConfirmGUID, DateEntered)
    VALUES(@NID, @CID, GETUTCDATE())
  END

INSERT INTO SMB_Profiles(RealName, 
			UserName, 
			euPassword, 
			EmailAddress, 
			ShowAddress, 
			HomePage, 
			AIMName, 
			ICQNumber, 
			TimeOffset, 
			EditableSignature,
			Signature,
			TotalPosts,
			PostAllowed,
			IsGlobalAdmin,
                        IsModerator,
			CreateDate,
			LastLoginDate,
			UserGUID,
			MSNM,
			YPager,
			HomeLocation,
			Occupation,
			Interests,
                        Avatar,
                        UsePM,
                        PMPopUP,
                        PMEmail,
                        PMAdminLock,                         
                        MailVerify,
                        UserTheme,
                        AdminBan,
                        NTAuth)

VALUES(@RealName, 
	@UserName, 
	@euPassword, 
	@EmailAddress, 
	@ShowAddress, 
	@HomePage, 
	@AIMName, 
	@ICQNumber, 
	@TimeOffset, 
	@EditSignature,
	@Signature,
	0,
	1,
	0,
        0,
	GETUTCDATE(),
	GETUTCDATE(),
	@NID,
	@MSNM,
	@YPager,
	@HomeLocation,
	@Occupation,
	@Interests,
        @Avatar,
        @UsePM,
        @PMPopUP,
	@PMEmail,
        1,
        @MailVerify,
	@UserTheme,
        0,
        @NTAuth)


-- update site stats
EXEC TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO



SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_AddPollValues
	@pv1		VARCHAR(150) = '',
	@pv2		VARCHAR(150) = '',
	@pv3		VARCHAR(150) = '',
	@pv4		VARCHAR(150) = '',
	@pv5		VARCHAR(150) = '',
	@pv6		VARCHAR(150) = '',
	@messageID	INT
AS
IF @pv1 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv1, 0)
  END
IF @pv2 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv2, 0)
  END
IF @pv3 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv3, 0)
  END
IF @pv4 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv4, 0)
  END
IF @pv5 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv5, 0)
  END
IF @pv6 <> ''
  BEGIN
    INSERT INTO SMB_PollQs(messageID, pollText, voteCount)
    VALUES(@messageID, @pv6, 0)
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_AddReplyPost
	@ParentMsgID	INT,
	@MessageText	TEXT,
	@EditText	TEXT,
	@NotifyUser	INT,
	@PostIcon	VARCHAR(50),
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT,
	@PostIPAddr	VARCHAR(50),
	@postID		INT	OUTPUT

AS
DECLARE @PostDT 	datetime

SET @PostDT = GETUTCDATE()


--  First Add the post
INSERT INTO SMB_Messages(ForumID,
				ParentMsgID,
				MessageText,
				IsParentMsg,
				PostDate,
				PostIcon,
				TotalReplies,
				TotalViews,
				PostIPAddr,
				UserGUID,
                                EditableText)
VALUES(@ForumID,
	@ParentMsgID,
	@MessageText,
	0,
	@PostDT,
	@PostIcon,
	0,
	0,
	@PostIPAddr,
	@UserGUID,
        @EditText)
SET @postID = (SELECT @@IDENTITY)

-- Update Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = @PostDT,
	LastPostTopic = @ParentMsgID
WHERE ForumID = @ForumID

-- Update ParentMsg Info
UPDATE SMB_Messages
SET TotalReplies = TotalReplies + 1,
	LastReplyDate = @PostDT,
	LastReplyUserID = @UserGUID
WHERE MessageID = @ParentMsgID

-- Update Posting user profile
UPDATE SMB_Profiles
SET LastPostDate = @PostDT,
	LastPostID = @ParentMsgID,
	TotalPosts = TotalPosts + 1	
WHERE UserGUID = @UserGUID


-- Add to mailer if set
IF @NotifyUser = 1 
INSERT INTO SMB_EmailNotify(ParentMsgID, UserGUID)
VALUES(@ParentMsgID, @UserGUID)

-- update site stats
EXEC TB_UpdateStats



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_AddUserToIgnore
	@UserGUID	UNIQUEIDENTIFIER,
	@UserID		INT,
	@IA		INT	OUTPUT
AS
DECLARE @UID		INT
DECLARE @IID		INT
DECLARE @IsAdmin	BIT
IF (SELECT IsGlobalAdmin FROM SMB_Profiles WHERE UserID = @UserID) = 1 
  OR (SELECT IsModerator FROM SMB_Profiles WHERE UserID = @UserID) = 1
  BEGIN
    SET @IsAdmin = 1
    SET @IA = 3		-- cannot ignore admin or moderator
  END
ELSE
  BEGIN
    SET @IsAdmin = 0
  END

IF @IsAdmin = 0
  BEGIN
    SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)

    IF @UID IS NOT NULL
      BEGIN
        SET @IID = (SELECT iid FROM SMB_Ignored WHERE UserID = @UID AND IgnoreID = @UserID)
        IF @IID IS NOT NULL	-- already exists
          BEGIN
            SET @IA = 2
          END
        ELSE
          BEGIN
             INSERT INTO SMB_Ignored(UserID, IgnoreID, dateAdded)
             VALUES(@UID, @UserID, GETUTCDATE())
             SET @IA = 4
          END   
      END
    ELSE
      BEGIN
        SET @IA = 1
      END
  END

IF @IA IS NULL
  BEGIN
    SET @IA = 0
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_BanIPFromThread
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@BanResult	INT	OUTPUT
AS
DECLARE @UID		INT
DECLARE @IsAdmin	BIT

SET @UID = (SELECT UserID 
            FROM SMB_Profiles 
            WHERE UserGUID = (SELECT UserGUID 
                              FROM SMB_Messages 
                              WHERE MessageID = @MessageID))

IF @UID IS NULL
  BEGIN
    SET @BanResult = 0
  END
ELSE
  BEGIN
    SET @IsAdmin = (SELECT IsGlobalAdmin FROM SMB_Profiles WHERE UserID = @UID)
    IF @IsAdmin = 0 OR @IsAdmin IS NULL
      BEGIN
        SET @IsAdmin = (SELECT IsModerator FROM SMB_Profiles WHERE UserID = @UID)    
      END
    
    IF @IsAdmin = 1
      BEGIN
        SET @BanResult = 1
      END
    ELSE
      BEGIN
        INSERT INTO SMB_IPBan(IPMask)
        SELECT PostIPAddr
        FROM SMB_Messages
        WHERE MessageID = @MessageID
        SET @BanResult = 2
      END
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_BanUserFromThread
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@BanResult	INT	OUTPUT
AS
DECLARE @UID		INT
DECLARE @IsAdmin	BIT

SET @UID = (SELECT UserID 
            FROM SMB_Profiles 
            WHERE UserGUID = (SELECT UserGUID 
                              FROM SMB_Messages 
                              WHERE MessageID = @MessageID))

IF @UID IS NULL
  BEGIN
    SET @BanResult = 0
  END
ELSE
  BEGIN
    SET @IsAdmin = (SELECT IsGlobalAdmin FROM SMB_Profiles WHERE UserID = @UID)
    IF @IsAdmin = 0 OR @IsAdmin IS NULL
      BEGIN
        SET @IsAdmin = (SELECT IsModerator FROM SMB_Profiles WHERE UserID = @UID)    
      END
    
    IF @IsAdmin = 1
      BEGIN
        SET @BanResult = 1
      END
    ELSE
      BEGIN
        UPDATE SMB_Profiles
        SET AdminBan = 1
        WHERE UserID = @UID

        INSERT INTO SMB_EmailBan(EmailAddress)
        SELECT EmailAddress
        FROM SMB_Profiles
        WHERE UserID = @UID

        SET @BanResult = 2
      END
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPForumSubscribeList
	@UserGUID	UNIQUEIDENTIFIER
AS

SELECT ForumID,
       ForumName 
FROM SMB_Forums       
WHERE ForumID IN (SELECT DISTINCT ForumID 
                  FROM SMB_ForumSubscribe 
                  WHERE UserGUID = @UserGUID)


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPListIgnored
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
IF @UID IS NOT NULL
  BEGIN
    SELECT i.iid,
           p.UserName
    FROM SMB_Ignored i
    INNER JOIN SMB_Profiles p
      ON p.UserID = i.IgnoreID
    WHERE i.UserID = @UID
    ORDER BY p.UserName
  END
ELSE
  BEGIN
    SELECT 0, ''
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPNewSubscribeList
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
SELECT m.MessageID,
       m.MessageTitle,
       m.PostDate,
       (SELECT COUNT(MessageID) 
          FROM SMB_Messages m2
          WHERE IsParentMsg = 0 
            AND ParentMsgID = m.MessageID  
            AND m2.UserGUID NOT IN (SELECT p.UserGUID
                                    FROM SMB_Profiles p
                                    INNER JOIN SMB_Ignored i
                                      ON i.IgnoreID = p.UserID
                                    WHERE i.UserID = @UID)),
       m.TotalViews,
       m.LastReplyDate,
       p.UserID,
       p.UserName,
       m.IsPoll,
       p2.UserID,
       p2.UserName,
       m.TopicLocked,
       m.PostIcon,
       f.ForumID,
       f.ForumName
 
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
INNER JOIN SMB_Forums f
  ON f.ForumID = m.ForumID
LEFT JOIN SMB_Profiles p2
  ON p2.UserGUID = m.LastReplyUserID
WHERE (m.MessageID IN (SELECT DISTINCT ParentMsgID FROM SMB_EmailNotify WHERE UserGUID = @UserGUID)
         OR f.ForumID IN (SELECT DISTINCT ForumID FROM SMB_ForumSubscribe WHERE UserGUID = @UserGUID))        
  AND isParentMsg = 1
  AND IsSticky = 0
  AND m.UserGUID NOT IN (SELECT p.UserGUID
                       FROM SMB_Profiles p
                       INNER JOIN SMB_Ignored i
                         ON i.IgnoreID = p.UserID
                       WHERE i.UserID = @UID)
ORDER BY LastReplyDate DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPRemoveForumSubscribe
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT
AS
DELETE SMB_ForumSubscribe
WHERE UserGUID = @UserGUID 
  AND ForumID = @ForumID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPRemoveIgnoreUser
	@UserGUID	UNIQUEIDENTIFIER,
	@IID		INT
AS
DELETE SMB_Ignored
WHERE UserID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
  AND iid = @IID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPRemoveThreadSubscribe
	@UserGUID	UNIQUEIDENTIFIER,
	@MessageID	INT
AS
DELETE SMB_EmailNotify
WHERE UserGUID = @UserGUID 
  AND ParentMsgID = @MessageID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPSubscribeList
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
SELECT m.MessageID,
       m.MessageTitle,
       m.PostDate,
       (SELECT COUNT(MessageID) 
          FROM SMB_Messages m2
          WHERE IsParentMsg = 0 
            AND ParentMsgID = m.MessageID  
            AND m2.UserGUID NOT IN (SELECT p.UserGUID
                                    FROM SMB_Profiles p
                                    INNER JOIN SMB_Ignored i
                                      ON i.IgnoreID = p.UserID
                                    WHERE i.UserID = @UID)),
       m.TotalViews,
       m.LastReplyDate,
       p.UserID,
       p.UserName,
       m.IsPoll,
       p2.UserID,
       p2.UserName,
       m.TopicLocked,
       m.PostIcon,
       f.ForumID,
       f.ForumName
 
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
INNER JOIN SMB_Forums f
  ON f.ForumID = m.ForumID
LEFT JOIN SMB_Profiles p2
  ON p2.UserGUID = m.LastReplyUserID
WHERE m.MessageID IN (SELECT DISTINCT ParentMsgID FROM SMB_EmailNotify WHERE UserGUID = @UserGUID)
  AND isParentMsg = 1
  AND IsSticky = 0
  AND m.UserGUID NOT IN (SELECT p.UserGUID
                       FROM SMB_Profiles p
                       INNER JOIN SMB_Ignored i
                         ON i.IgnoreID = p.UserID
                       WHERE i.UserID = @UID)
ORDER BY LastReplyDate DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPUnreadPMs
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID 
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID)

IF @UID IS NULL
  BEGIN
    SET @UID = 0  -- should always return 0 messages
  END
SELECT m.umpid,
       m.Subject,
       m.DateTimeSent,
       p.UserName,
       m.BeenViewed,
       m.IsSentItem
FROM SMB_PrivateMessage m
INNER JOIN SMB_Profiles p
  ON p.UserID = m.FromID
WHERE ToID = @UID 
  AND IsSentItem = 0
  AND BeenViewed != 1
ORDER BY DateTimeSent DESC



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_CPUpdateOptions
	@TimeOffset	INT,
	@Avatar		VARCHAR(200) = NULL,
	@UsePM		BIT = 1,
	@PMPopUp	BIT = 1,
	@PMEmail	BIT = 1,
	@UserTheme	VARCHAR(50),
	@UserGUID	UNIQUEIDENTIFIER,
	@UserTitle	VARCHAR(50) = ''

AS
UPDATE SMB_Profiles
SET TimeOffset = @TimeOffset,
    Avatar = @Avatar,
    UsePM = @UsePM,
    PMPopUp = @PMPopUp,
    PMEmail = @PMEmail,
    UserTheme = @UserTheme,
    UserTitle = @UserTitle

WHERE UserGUID = @UserGUID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CPUpdateProfile
	@RealName	VARCHAR(100),
	@euPassword	VARCHAR(100),
	@EmailAddress	VARCHAR(64),
	@ShowAddress	INT,
	@Homepage	VARCHAR(200),
	@AIMName	VARCHAR(100),
	@ICQNumber	INT,
	@EditSignature	TEXT,
	@Signature	TEXT,
	@UserGUID	UNIQUEIDENTIFIER,
	@MSNM		VARCHAR(64) = NULL,
	@YPager		VARCHAR(50) = NULL,
	@HomeLocation	VARCHAR(100) = NULL,
	@Occupation	VARCHAR(150) = NULL,
	@Interests	TEXT = NULL


AS
UPDATE SMB_Profiles
SET RealName = @RealName,
    euPassword = @euPassword,
    EmailAddress = @EmailAddress,
    ShowAddress = @ShowAddress,
    HomePage = @HomePage,
    AIMName = @AIMName,
    ICQNumber = @ICQNumber,
    EditableSignature = @EditSignature,
    Signature = @Signature,
    MSNM = @MSNM,
    YPager = @YPager,
    HomeLocation = @HomeLocation,
    Occupation = @Occupation,
    Interests = @Interests

WHERE UserGUID = @UserGUID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CastVote
	@MessageID	INT,
	@PollID		INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@VoteVal	INT	OUTPUT
AS
DECLARE @VID	INT
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
IF @UID IS NULL
  BEGIN
    SET @VoteVal = 1
  END
ELSE
  BEGIN
    SET @VID = (SELECT VoteID
                FROM SMB_PollVs
                WHERE MessageID = @MessageID
                  AND UserID = @UID)
    IF @VID IS NOT NULL
      BEGIN
        SET @VoteVal = 2
      END
    ELSE
      BEGIN
        INSERT INTO SMB_PollVs(UserID, MessageID, PollID, DateVoted)
        VALUES(@UID, @MessageID, @PollID, GETUTCDATE())
     
        UPDATE SMB_PollQs
        SET voteCount = voteCount + 1
        WHERE messageID = @MessageID 
          AND pollID = @PollID

        SET @VoteVal = 3
      END
  END
IF @VoteVal IS NULL
  BEGIN
    SET @VoteVal = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_CheckEmailBan
	@EmailAddress	VARCHAR(64),
	@IsBanned	BIT	OUTPUT
AS
DECLARE @emid	INT
SET @emid = (SELECT eaid
             FROM SMB_EmailBan
             WHERE EmailAddress = @EmailAddress)
IF @emid IS NULL
  BEGIN
    SET @IsBanned = 0
  END
ELSE
  BEGIN
    SET @IsBanned = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_CheckGUIDLock
	@UserGUID	UNIQUEIDENTIFIER,
	@GUIDLock	BIT	OUTPUT
AS
SET @GUIDLock = (SELECT AdminBan
                 FROM SMB_Profiles
                 WHERE UserGUID = @UserGUID)
IF @GUIDLock IS NULL
  BEGIN
    SET @GUIDLock = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_CheckIPLock
AS
SELECT IPMask
FROM SMB_IPBan


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CheckIfIgnored
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@IID		INT	OUTPUT
AS
SET @IID = (SELECT IID 
            FROM SMB_Ignored
            WHERE UserID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
             AND IgnoreID = (SELECT UserID 
                             FROM SMB_Profiles 
                             WHERE UserGUID = (SELECT UserGUID FROM SMB_Messages WHERE MessageID = @MessageID)))

IF @IID IS NULL
  BEGIN
    SET @IID = 0
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_CheckIfSubscribed
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT,
	@IsSub		INT	OUTPUT
AS
DECLARE @TBID	INT
SET @IsSub = 0
SET @TBID = (SELECT TOP 1 tbsid 
             FROM SMB_ForumSubscribe
             WHERE UserGUID = @UserGUID
               AND ForumID = @ForumID)
IF @TBID IS NULL
  BEGIN
    SET @IsSub = 0
  END
ELSE
  BEGIN
    SET @IsSub = @TBID
  END
SELECT @IsSub    



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CheckIfVoted
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@HasVoted	BIT	OUTPUT
AS
DECLARE @UID	INT
DECLARE @VID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
IF @UID IS NOT NULL
  BEGIN
    SET @VID = (SELECT VoteID FROM SMB_PollVs WHERE UserID = @UID AND MessageID = @MessageID)
    IF @VID IS NULL
      BEGIN
        SET @HasVoted = 0
      END
    ELSE
      BEGIN
        SET @HasVoted = 1
      END    
  END
ELSE
  BEGIN
    SET @HasVoted = 1
  END
IF @HasVoted IS NULL
  BEGIN
    SET @HasVoted = 1
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO





CREATE   PROCEDURE TB_CheckUserExist
	@UserName	varchar(50),
	@UserExist	bit	OUTPUT
AS
DECLARE @UNT	varchar(50)
SET @UNT = (SELECT UserName
            FROM SMB_Profiles
            WHERE UserName = @UserName)
IF @UNT IS NULL
  BEGIN
    SET @UserExist = 0
  END
ELSE
  BEGIN
    SET @UserExist = 1
  END

SELECT @UserExist




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_CheckUserForPM
	@UserName	VARCHAR(50),
	@ValidUser	BIT	OUTPUT
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID
            FROM SMB_Profiles
            WHERE UserName = @UserName
              AND UsePM = 1)
IF @UID IS NULL
  BEGIN
    SET @ValidUser = 0
  END
ELSE
  BEGIN
    SET @ValidUser = 1
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_CreateEditableMessage
	@MessageID	INT,
	@EditableText	text
AS
UPDATE SMB_Messages
SET EditableText = @EditableText
WHERE MessageID = @MessageID
--  AND EditableText IS NULL


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_DeleteForumPost
	@UserGUID	UNIQUEIDENTIFIER,
	@MessageID	INT

AS
DECLARE @VPost		INT	-- messageID if valid post
DECLARE @PID		INT	-- Parent ID
DECLARE @IsAdmin	BIT	-- Is @UserGUID a global admin?
DECLARE @DoDelete	BIT	-- boolean for processing delete
DECLARE @LID		INT	-- Last reply ID
DECLARE @FID		INT	-- Forum ID
DECLARE @TP		INT	-- Total Posts


-- Delete posting if UserGUID matches
SET @VPost = (SELECT MessageID 
              FROM SMB_Messages
              WHERE MessageID = @MessageID
                AND UserGUID = @UserGUID)

IF @VPost IS NULL -- user is not a match to poster
  BEGIN
    SET @IsAdmin = (SELECT IsGlobalAdmin
                    FROM SMB_Profiles
                    WHERE UserGUID = @UserGUID)
    IF @IsAdmin = 1
      BEGIN
        SET @DoDelete = 1
      END 
    ELSE
      BEGIN
        SET @DoDelete = 0
    END
  END
ELSE	-- user matches poster
  BEGIN
    SET @DoDelete = 1
  END

IF @DoDelete = 1
  BEGIN
    SET @FID = (SELECT ForumID
                FROM SMB_Messages
                WHERE MessageID = @MessageID)

--  Check if is a parent message.. delete followups if it is
    SET @PID = (SELECT ParentMsgID 
                FROM SMB_Messages
                WHERE MessageID = @MessageID)
    IF @PID IS NULL	--  its the parent message
      BEGIN
        DELETE SMB_Messages
        WHERE ParentMsgID = @MessageID
          OR MessageID = @MessageID
        SET @TP = (SELECT COUNT(MessageID)
                   FROM SMB_Messages
                   WHERE UserGUID = @UserGUID)
        IF @TP > 1 
          BEGIN
            UPDATE SMB_Profiles
            SET TotalPosts = @TP - 1
            WHERE UserGUID = @UserGUID
          END
        ELSE
          BEGIN
            UPDATE SMB_Profiles
            SET TotalPosts = 0
            WHERE UserGUID = @UserGUID
          END

      END    -- is parent msg
    ELSE	--  not the parent message... update thread info        
      BEGIN 
        DELETE SMB_Messages
        WHERE MessageID = @MessageID
        
        SET @TP = (SELECT COUNT(MessageID)
                   FROM SMB_Messages
                   WHERE UserGUID = @UserGUID)
        IF @TP > 1 
          BEGIN
            UPDATE SMB_Profiles
            SET TotalPosts = @TP - 1
            WHERE UserGUID = @UserGUID
          END
        ELSE
          BEGIN
            UPDATE SMB_Profiles
            SET TotalPosts = 0
            WHERE UserGUID = @UserGUID
          END

        SET @LID = (SELECT MAX(MessageID) 
                    FROM SMB_Messages
                    WHERE ParentMsgID = @PID)
        IF @LID IS NULL	-- no additional replies
          BEGIN
            UPDATE SMB_Messages
            SET LastReplyUserID = UserGUID,
                LastReplyDate = PostDate,
                TotalReplies = 0
            WHERE MessageID = @PID
          END	-- additional replies
        ELSE
          BEGIN
            UPDATE SMB_Messages
            SET LastReplyUserID = (SELECT UserGUID 
                                   FROM SMB_Messages
                                   WHERE MessageID = @LID),
                LastReplyDate = (SELECT PostDate
                                 FROM SMB_Messages
                                 WHERE MessageID = @LID),
                TotalReplies = (SELECT COUNT(*)
                                FROM SMB_Messages
                                WHERE ParentMsgID = @PID)
            WHERE MessageID = @PID
          END  -- no additional replies
      END  -- @PID is not null

-- Finished thread now do the forum updates
    UPDATE SMB_Forums
    SET TotalPosts = (SELECT COUNT(*) 
                      FROM SMB_Messages
                      WHERE ForumID = @FID),
        TotalTopics = (SELECT COUNT(*)
                       FROM SMB_Messages
                       WHERE ForumID = @FID
                         AND IsParentMsg = 1)
    WHERE ForumID = @FID

    SET @LID = NULL	-- set to null for process
    SET @LID = (SELECT MAX(MessageID) 
                FROM SMB_Messages
                WHERE ForumID = @FID)
    IF (SELECT IsParentMsg
        FROM SMB_Messages
        WHERE MessageID = @LID) = 0
      BEGIN
        SET @LID = (SELECT ParentMsgID
                    FROM SMB_Messages
                    WHERE MessageID = @LID)
      END
    UPDATE SMB_Forums
    SET LastPostTopic = @LID,
        LastPostDate = (SELECT MAX(PostDate)
                        FROM SMB_Messages
                        WHERE ForumID = @FID)
    WHERE ForumID = @FID

  END	-- DoDelete


-- update site stats
EXEC TB_UpdateStats



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_DeleteMyPM
	@UserGUID	UNIQUEIDENTIFIER,
	@MessageID	INT,
	@pType		VARCHAR(2)
AS
DECLARE @UID		INT
SET @UID = (SELECT UserID
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID)

IF @UID IS NOT NULL
  BEGIN
    IF @pType = 'di'
      BEGIN
        DELETE SMB_PrivateMessage
        WHERE ToID = @UID
          AND umpid = @MessageID
      END

    IF @pType = 'ds'
      BEGIN
        DELETE SMB_PrivateMessage
        WHERE FromID = @UID
          AND umpid = @MessageID
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS OFF 
GO


CREATE     PROCEDURE TB_EditPost
	@MessageID		int,	
	@PostIcon		varchar(50),
	@MessageText		text,
	@EditText		text,
	@PostIPAddr		varchar(50),
	@UserGUID		uniqueidentifier,
	@ParentMsgID		int	OUTPUT
AS
DECLARE @IsAdmin	bit
DECLARE @PostGUID	uniqueidentifier
DECLARE @IsParentMsg	bit
DECLARE @smbfID		INT
	
SET @IsParentMsg = (SELECT IsParentMsg FROM SMB_Messages WHERE MessageID = @MessageID)
IF @IsParentMsg = 1
  BEGIN
    SET @ParentMsgID = @MessageID
  END
ELSE
  BEGIN
    SET @ParentMsgID = (SELECT ParentMsgID FROM SMB_Messages WHERE MessageID = @MessageID)
  END

SET @PostGUID = (SELECT UserGUID FROM SMB_Messages WHERE MessageID = @MessageID)
SET @IsAdmin = (SELECT IsGlobalAdmin FROM SMB_Profiles WHERE UserGUID = @UserGUID)
SET @smbfID = (SELECT smbfID 
               FROM SMB_Moderators 
               WHERE ForumID = (SELECT ForumID 
                                FROM SMB_Messages 
                                WHERE MessageID = @MessageID)
                 AND UserID = (SELECT UserID
                               FROM SMB_Profiles
                               WHERE UserGUID = @UserGUID))
If @PostGUID = @UserGUID
  BEGIN
    UPDATE SMB_Messages
    SET PostIcon = @PostIcon,
	PostIPAddr = @PostIPAddr,
	MessageText = @MessageText,
	EditableText = @EditText
   WHERE MessageID = @MessageID
  END
IF @IsAdmin = 1 AND @PostGUID != @UserGUID
  BEGIN
    UPDATE SMB_Messages
    SET PostIcon = @PostIcon,
  	PostIPAddr = @PostIPAddr,
  	MessageText = @MessageText,
	EditableText = @EditText
    WHERE MessageID = @MessageID
  END
IF @smbfID IS NOT NULL AND @IsAdmin = 0 AND @PostGUID != @UserGUID
  BEGIN
    UPDATE SMB_Messages
    SET PostIcon = @PostIcon,
        PostIPAddr = @PostIPAddr,
  	MessageText = @MessageText,
  	EditableText = @EditText
    WHERE MessageID = @MessageID
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ForumAccessList
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@HasAccess	BIT	OUTPUT

AS

DECLARE @AccessPermission	INT
SET @HasAccess = 0

SET @AccessPermission = (SELECT AccessPermission
                         FROM SMB_Forums
                         WHERE ForumID = @ForumID)
IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    IF @AccessPermission = 1
      BEGIN
        SET @HasAccess = 1
      END
  END
ELSE
  BEGIN
    IF @AccessPermission = 2 OR @AccessPermission = 1
      BEGIN
        SET @HasAccess = 1
      END
    IF @AccessPermission = 3
      BEGIN
        DECLARE @spaID	INT
        SET @spaID = (SELECT spaID
                      FROM SMB_PrivateAccess
                      WHERE ForumID = @ForumID
                      AND UserID = (SELECT UserID
                                    FROM SMB_Profiles
                                   WHERE UserGUID = @UserGUID))
        IF @spaID > 0
          BEGIN
            SET @HasAccess = 1
          END
      END
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ForumAccessList2
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@HasAccess	BIT	OUTPUT

AS

DECLARE @AccessPermission	INT
SET @HasAccess = 0

SET @AccessPermission = (SELECT AccessPermission
                         FROM SMB_Forums
                         WHERE ForumID = @ForumID)
IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    IF @AccessPermission = 1
      BEGIN
        SET @HasAccess = 1
      END
  END
ELSE
  BEGIN
    IF @AccessPermission = 2 OR @AccessPermission = 1
      BEGIN
        SET @HasAccess = 1
      END
    IF @AccessPermission = 3
      BEGIN
        DECLARE @spaID	INT
        SET @spaID = (SELECT spaID
                      FROM SMB_PrivateAccess
                      WHERE ForumID = @ForumID
                      AND UserID = (SELECT UserID
                                    FROM SMB_Profiles
                                   WHERE UserGUID = @UserGUID))
        IF @spaID > 0
          BEGIN
            SET @HasAccess = 1
          END
      END
  END




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ForumDropListing
	@UserGUID	UNIQUEIDENTIFIER = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
AS

IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    SELECT f.ForumID, 
           f.ForumName, 
           f.IsPrivate,
           c.CategoryName,
           c.CategoryID
    FROM SMB_Forums f
    INNER JOIN SMB_ForumCategories c
      ON c.CategoryID = f.CategoryID
    WHERE f.AccessPermission = 1
    ORDER BY c.CategoryOrder, f.forumOrder, f.ForumName
  END
ELSE
  BEGIN
    SELECT f.ForumID, 
           f.ForumName, 
           f.IsPrivate,
           c.CategoryName,
           c.CategoryID
    FROM SMB_Forums f
    INNER JOIN SMB_ForumCategories c
      ON c.CategoryID = f.CategoryID    
    WHERE f.AccessPermission = 1
      OR f.AccessPermission = 2
      OR f.ForumID IN (SELECT ForumID
                       FROM SMB_PrivateAccess a
                       INNER JOIN SMB_Profiles p
                         ON p.UserID = a.UserID
                       WHERE p.UserGUID = @UserGUID)
    ORDER BY c.CategoryOrder, f.forumOrder, f.ForumName
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_ForumDropListing2
	@UserGUID	UNIQUEIDENTIFIER = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
AS

IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    SELECT f.ForumID, 
           f.ForumName, 
           f.IsPrivate,
           c.CategoryName
    FROM SMB_Forums f
    INNER JOIN SMB_ForumCategories c
      ON c.CategoryID = f.CategoryID
    WHERE f.AccessPermission = 1
    ORDER BY c.CategoryOrder, f.ForumName
  END
ELSE
  BEGIN
    SELECT f.ForumID, 
           f.ForumName, 
           f.IsPrivate,
           c.CategoryName
    FROM SMB_Forums f
    INNER JOIN SMB_ForumCategories c
      ON c.CategoryID = f.CategoryID    
    WHERE f.AccessPermission = 1
      OR f.AccessPermission = 2
      OR f.ForumID IN (SELECT ForumID
                       FROM SMB_PrivateAccess a
                       INNER JOIN SMB_Profiles p
                         ON p.UserID = a.UserID
                       WHERE p.UserGUID = @UserGUID)
    ORDER BY c.CategoryOrder, f.ForumName
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO


CREATE PROCEDURE TB_ForumTitle
	@ForumID	int,
	@ForumName	varchar(50)  OUTPUT
AS
SET @ForumName = (SELECT ForumName
                                    FROM SMB_Forums
                                    WHERE ForumID = @ForumID)
IF @ForumName IS NULL OR @ForumName = ''
  BEGIN
    SET @ForumName = 'Unknown Forum'
  END

SELECT @ForumName

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ForumTopicCount
	@ForumID	int,
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumCount	int	OUTPUT
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)

SET @ForumCount = (SELECT COUNT(*)
                   FROM SMB_Messages
                   WHERE ForumID = @ForumID
                     AND IsParentMsg = 1
                     AND UserGUID NOT IN (SELECT p.UserGUID
                                          FROM SMB_Profiles p
                                          INNER JOIN SMB_Ignored i
                                            ON i.IgnoreID = p.UserID
                                          WHERE i.UserID = @UID))




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetCanModerate
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@CanModerate	BIT	OUTPUT
AS
DECLARE @IsAdmin 	BIT
DECLARE @smbfID		INT
SET @IsAdmin = (SELECT IsGlobalAdmin
                FROM SMB_Profiles
                WHERE UserGUID = @UserGUID)
IF @IsAdmin = 1
  BEGIN
    SET @CanModerate = 1
  END
ELSE
  BEGIN
    SET @smbfID = (SELECT smbfID
                    FROM SMB_Moderators
                    WHERE ForumID = @ForumID
                      AND UserID = (SELECT UserID
                                    FROM SMB_Profiles
                                    WHERE UserGUID = @UserGUID))
    IF @smbfID IS NULL
      BEGIN
        SET @CanModerate = 0
      END
    ELSE
      BEGIN
        SET @CanModerate = 1
      END
  END




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetEmoticonMini
AS
SELECT DISTINCT TOP 16 imageName,
       imageAltText,
       imageKeys
FROM SMB_Emoticons
ORDER BY imageKeys

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetFilterWords

AS
SELECT badWord,
       goodWord,
       applyFilter
FROM SMB_FilterWords


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetForEdit
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@IsModerator	BIT
AS

DECLARE @DoUpdate	BIT
DECLARE @smbfID		INT
IF @IsModerator = 0
  BEGIN
    SELECT m.MessageTitle,
           m.EditableText,
           m.IsParentMsg,
           m.PostIcon,
           m.ParentMsgID,
           (SELECT TOP 1 TopicLocked FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID),
           (SELECT TOP 1 IsSticky FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID)
    FROM SMB_Messages m
    WHERE m.MessageID = @MessageID
      AND m.UserGUID = @UserGUID
  END
ELSE
  BEGIN
    SET @DoUpdate = (SELECT IsGlobalAdmin
                     FROM SMB_Profiles
                     WHERE UserGUID = @UserGUID)
    IF @DoUpdate = 1
      BEGIN
        SELECT MessageTitle,
               EditableText,
               IsParentMsg,
               PostIcon,
               ParentMsgID,
               (SELECT TOP 1 TopicLocked FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID),
               (SELECT TOP 1 IsSticky FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID)
        FROM SMB_Messages m
        WHERE m.MessageID = @MessageID
      END
    ELSE
      BEGIN
        SET @smbfID = (SELECT smbfID
                       FROM SMB_Moderators
                       WHERE ForumID = (SELECT ForumID
                                        FROM SMB_Messages
                                        WHERE MessageID = @MessageID)
                         AND UserID = (SELECT UserID
                                       FROM SMB_Profiles
                                       WHERE UserGUID = @UserGUID))
        IF @smbfID IS NOT NULL
          BEGIN
            SELECT MessageTitle,
                   EditableText,
                   IsParentMsg,
                   PostIcon,
                   ParentMsgID,
                   (SELECT TOP 1 TopicLocked FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID),
                   (SELECT TOP 1 IsSticky FROM SMB_Messages WHERE MessageID = m.ParentMsgID OR MessageID = m.MessageID)
           FROM SMB_Messages m
           WHERE m.MessageID = @MessageID
          END
      END
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetForPMReply
	@UserGUID	UNIQUEIDENTIFIER,
	@MessageID	INT,
	@UserName	VARCHAR(50)	OUTPUT,
	@Subject	VARCHAR(100)	OUTPUT
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID)
IF @UID IS NULL
  BEGIN
    SET @UID = 0
  END
SET @UserName = (SELECT UserName
                 FROM SMB_Profiles
                 WHERE UserID = (SELECT FromID
                                 FROM SMB_PrivateMessage
                                 WHERE umpid = @MessageID
                                   AND ToID = @UID))
SET @Subject = (SELECT Subject
                FROM SMB_PrivateMessage
                WHERE umpid = @MessageID
                 AND ToID = @UID)

IF @UserName IS NULL
  BEGIN
   SET @UserName = ''
  END
IF @Subject IS NULL
  BEGIN
   SET @Subject = ''
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_GetForQuote
	@MessageID	int
AS
SELECT p.UserName,
       m.EditableText,
       m.ParentMsgID
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
WHERE m.MessageID = @MessageID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetForumList
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
SELECT m.MessageID,
       m.MessageTitle,
       m.PostDate,
       (SELECT COUNT(MessageID) 
          FROM SMB_Messages m2
          WHERE IsParentMsg = 0 
            AND ParentMsgID = m.MessageID  
            AND m2.UserGUID NOT IN (SELECT p.UserGUID
                                    FROM SMB_Profiles p
                                    INNER JOIN SMB_Ignored i
                                      ON i.IgnoreID = p.UserID
                                    WHERE i.UserID = @UID)),
       m.TotalViews,
       m.LastReplyDate,
       p.UserID,
       p.UserName,
       m.IsPoll,
       p2.UserID,
       p2.UserName,
       m.TopicLocked,
       m.PostIcon
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
LEFT JOIN SMB_Profiles p2
  ON p2.UserGUID = m.LastReplyUserID
WHERE ForumID = @ForumID
  AND isParentMsg = 1
  AND IsSticky = 0
  AND m.UserGUID NOT IN (SELECT p.UserGUID
                       FROM SMB_Profiles p
                       INNER JOIN SMB_Ignored i
                         ON i.IgnoreID = p.UserID
                       WHERE i.UserID = @UID)
ORDER BY LastReplyDate DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetForumListPaged
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@FirstRec	INT = 1,
	@LastRec	INT = 50
AS
-- get the userid first
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)

-- create temp table for paging
CREATE TABLE #tIndex
(
	orderID		INT IDENTITY(1,1) NOT NULL,
	messageID	INT
)

-- insert forum records into the temp table
INSERT INTO #tIndex(messageID)
SELECT MessageID
FROM SMB_Messages
WHERE ForumID = @ForumID
  AND isParentMsg = 1
  AND IsSticky = 0
  AND UserGUID NOT IN (SELECT p.UserGUID
                       FROM SMB_Profiles p
                       INNER JOIN SMB_Ignored i
                         ON i.IgnoreID = p.UserID
                       WHERE i.UserID = @UID)
ORDER BY LastReplyDate DESC



SELECT m.MessageID,
       m.MessageTitle,
       m.PostDate,
       (SELECT COUNT(MessageID) 
          FROM SMB_Messages m2
          WHERE IsParentMsg = 0 
            AND ParentMsgID = m.MessageID  
            AND m2.UserGUID NOT IN (SELECT p.UserGUID
                                    FROM SMB_Profiles p
                                    INNER JOIN SMB_Ignored i
                                      ON i.IgnoreID = p.UserID
                                    WHERE i.UserID = @UID)),
       m.TotalViews,
       m.LastReplyDate,
       p.UserID,
       p.UserName,
       m.IsPoll,
       p2.UserID,
       p2.UserName,
       m.TopicLocked,
       m.PostIcon
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
LEFT JOIN SMB_Profiles p2
  ON p2.UserGUID = m.LastReplyUserID
WHERE m.MessageID IN (SELECT messageID 
                      FROM #tIndex 
                      WHERE orderID >= @FirstRec 
                        AND orderID <= @LastRec)

ORDER BY LastReplyDate DESC

DROP TABLE #tIndex



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetForumSubscribe
	@ParentMsgID		INT,
	@ForumID		INT,
	@UserGUID		UNIQUEIDENTIFIER
AS
DECLARE @pUserName	varchar(100)

SET @pUserName = (SELECT UserName FROM SMB_Profiles WHERE UserGUID = @UserGUID)

SELECT DISTINCT e.UserGUID, 
	 	p.EMailAddress,
		p.UserName AS mUserName,			
		e.ForumID,
		@ParentMsgID,
		(SELECT MessageTitle FROM SMB_Messages WHERE MessageID = @ParentMsgID) ,
		@pUserName AS pUserName,
		f.ForumName,
                (SELECT TotalReplies FROM SMB_Messages WHERE MessageID = @ParentMsgID)

FROM SMB_ForumSubscribe e
INNER JOIN SMB_Profiles p
  ON e.UserGUID = p.UserGUID
INNER JOIN SMB_Forums f
  ON f.ForumID = e.ForumID
WHERE e.ForumID = @FOrumID
  AND e.UserGUID != @UserGUID
  AND e.NotifySent = 0


UPDATE SMB_ForumSubscribe
SET NotifySent = 1
WHERE ForumID = @ForumID
  AND NotifySent = 0
  AND UserGUID != @UserGUID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetLastPostTime
	@UserGUID	UNIQUEIDENTIFIER,
	@LastPostDate	DATETIME	OUTPUT
AS
SET @LastPostDate = (SELECT LastPostDate
                     FROM SMB_Profiles
                     WHERE UserGUID = @UserGUID)
IF @LastPostDate IS NULL
  BEGIN
    SET @LastPostDate = '1/1/2002'
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMailNotify
	@ParentMsgID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @pUserName	VARCHAR(100)

SET @pUserName = (SELECT UserName FROM SMB_Profiles WHERE UserGUID = @UserGUID)

SELECT DISTINCT e.UserGUID, 
		p.EMailAddress,
		p.UserName AS mUserName,			
		m.ForumID,
		m.MessageID,
		m.MessageTitle,
		@pUserName AS pUserName,
                (SELECT TotalReplies FROM SMB_Messages WHERE MessageID = @ParentMsgID)

FROM SMB_EmailNotify e
INNER JOIN SMB_Profiles p
ON e.UserGUID = p.UserGUID
INNER JOIN SMB_Messages m
ON m.MessageID = e.ParentMsgID
WHERE e.ParentMsgID = @ParentMsgID
  AND e.UserGUID != @UserGUID
  AND e.UserGUID NOT IN (SELECT UserGUID
                         FROM SMB_ForumSubscribe
                         WHERE ForumID = m.ForumID)
  AND e.NotifySent = 0


UPDATE SMB_EmailNotify
SET NotifySent = 1
WHERE ParentMsgID = @ParentMsgID
  AND NotifySent = 0
  AND UserGUID != @UserGUID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMemberCount
	@SearchChar	VARCHAR(1) = '',
	@MCount		INT	OUTPUT
AS
IF @SearchChar = ''
  BEGIN
    SET @MCount = (SELECT Count(UserName)
                  FROM SMB_Profiles
                  WHERE UserName != 'guest')
  END
ELSE
  BEGIN
    IF @SearchChar BETWEEN 'A' AND 'Z'  
      BEGIN
        SET @MCount = (SELECT Count(UserName)
                       FROM SMB_Profiles
                       WHERE LEFT(UserName, 1) LIKE @SearchChar
                       AND UserName != 'guest')
      END
    ELSE
      BEGIN
        SET @MCount = (SELECT Count(UserName)
                       FROM SMB_Profiles
                       WHERE LEFT(UserName, 1) NOT BETWEEN 'A' AND 'Z'
                       AND UserName != 'guest')
      END
  END

IF @MCount IS NULL
  BEGIN
    SET @MCount = 0
  END 

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMemberList
	@SearchChar	VARCHAR(1) = '',
	@FirstRec	INT = 1,
	@LastRec	INT = 25
AS

CREATE TABLE #uIndex
(
 	orderID		INT IDENTITY(1,1) NOT NULL,
	userID		INT
)

IF @SearchChar = ''
  BEGIN
    INSERT INTO #uIndex(userID)
    SELECT UserID
    FROM SMB_Profiles
    WHERE UserName != 'guest'
    ORDER BY UserName
  END
ELSE
  BEGIN
    IF @SearchChar BETWEEN 'A' AND 'Z'  
      BEGIN
        INSERT INTO #uIndex(userID)
        SELECT UserID
        FROM SMB_Profiles
        WHERE LEFT(UserName, 1) LIKE @SearchChar
          AND UserName != 'guest'
        ORDER BY UserName
      END
    ELSE
      BEGIN
        INSERT INTO #uIndex(userID)
        SELECT UserID
        FROM SMB_Profiles
        WHERE LEFT(UserName, 1) NOT BETWEEN 'A' AND 'Z'
          AND UserName != 'guest'
        ORDER BY UserName
      END
  END

SELECT UserID,
       UserName,
       EmailAddress,
       ShowAddress,
       Homepage,
       TotalPosts,
       CreateDate,
       UsePM,
       PMAdminLock
FROM SMB_Profiles
WHERE UserID IN (SELECT UserID 
                 FROM #uIndex
                 WHERE orderID >= @FirstRec 
                   AND orderID <= @LastRec)

DROP TABLE #uIndex

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMemberOrdered
	@OrderType	INT,
	@FirstRec	INT = 1,
	@LastRec	INT = 25
AS
CREATE TABLE #uIndex
(
 	orderID		INT IDENTITY(1,1) NOT NULL,
	userID		INT
)


IF @OrderType = 1 
  BEGIN
    INSERT INTO #uIndex(userID)
    SELECT UserID
    FROM SMB_Profiles
    WHERE UserName != 'guest'
    ORDER BY CreateDate DESC

    SELECT p.UserID,
       p.UserName,
       p.EmailAddress,
       p.ShowAddress,
       p.Homepage,
       p.TotalPosts,
       p.CreateDate,
       p.UsePM,
       p.PMAdminLock
    FROM SMB_Profiles p
    INNER JOIN #uIndex u 
      ON u.UserId = p.UserID
    WHERE u.orderID >= @FirstRec 
      AND u.orderID <= @LastRec
    ORDER by u.orderID
 

  END
ELSE
  BEGIN
    INSERT INTO #uIndex(userID)
    SELECT UserID
    FROM SMB_Profiles
    WHERE UserName != 'guest'
    ORDER BY TotalPosts DESC

    SELECT p.UserID,
       p.UserName,
       p.EmailAddress,
       p.ShowAddress,
       p.Homepage,
       p.TotalPosts,
       p.CreateDate,
       p.UsePM,
       p.PMAdminLock
    FROM SMB_Profiles p
        INNER JOIN #uIndex u 
      ON u.UserId = p.UserID
    WHERE u.orderID >= @FirstRec 
      AND u.orderID <= @LastRec
    ORDER by u.orderID

  END




DROP TABLE #uIndex

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMessageThread
	@MessageID	INT,
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)
SELECT m.MessageText,
       m.PostDate,
       m.UserGUID,
       p.UserName,
       p.UserID,
       p.EmailAddress,
       p.ShowAddress,
       p.Homepage,
       p.AIMName,
       p.ICQNumber,
       p.TotalPosts,
       p.CreateDate,
       m.PostIcon,
       m.MessageID,
       p.MSNM,
       p.YPager,
       (SELECT smbfid FROM SMB_Moderators WHERE forumID = m.ForumID AND userID = p.UserID),
       p.Avatar,
       m.PostIPAddr,
       p.UsePM,
       p.PMAdminLock
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
WHERE (MessageID = @MessageID OR ParentMsgID = @MessageID)
  AND ForumID = @ForumID
  AND m.UserGUID NOT IN (SELECT p.UserGUID
                         FROM SMB_Profiles p
                         INNER JOIN SMB_Ignored i
                           ON i.IgnoreID = p.UserID
                         WHERE i.UserID = @UID)
ORDER BY m.PostDate

UPDATE SMB_Messages
SET TotalViews = TotalViews + 1
WHERE MessageID = @MessageID

-- update nofification mailers to send again
UPDATE SMB_EmailNotify
SET NotifySent = 0
WHERE UserGUID = @UserGUID
  AND ParentMsgID = @MessageID

UPDATE SMB_ForumSubscribe
SET NotifySent = 0
WHERE UserGUID = @UserGUID
  AND ForumID = @ForumID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetMessageThreadPaged
	@MessageID	INT,
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@FirstRec	INT = 1,
	@LastRec	INT = 25
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)

-- create temp table
CREATE TABLE #mIndex
(
 	orderID		INT IDENTITY(1,1) NOT NULL,
	messageID	INT
)

-- insert temp records
INSERT INTO #mIndex(messageID)
SELECT messageID
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
WHERE (MessageID = @MessageID OR ParentMsgID = @MessageID)
  AND ForumID = @ForumID
  AND m.UserGUID NOT IN (SELECT p.UserGUID
                         FROM SMB_Profiles p
                         INNER JOIN SMB_Ignored i
                           ON i.IgnoreID = p.UserID
                         WHERE i.UserID = @UID)
ORDER BY m.PostDate

-- query out
SELECT m.MessageText,
       m.PostDate,
       m.UserGUID,
       p.UserName,
       p.UserID,
       p.EmailAddress,
       p.ShowAddress,
       p.Homepage,
       p.AIMName,
       p.ICQNumber,
       p.TotalPosts,
       p.CreateDate,
       m.PostIcon,
       m.MessageID,
       p.MSNM,
       p.YPager,
       (SELECT smbfid FROM SMB_Moderators WHERE forumID = m.ForumID AND userID = p.UserID),
       p.Avatar,
       m.PostIPAddr,
       p.UsePM,
       p.PMAdminLock,
       m.IsPoll,
       m.IsParentMsg,
       m.IsSticky,
       p.UserTitle
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
WHERE MessageID IN (SELECT messageID 
                    FROM #mIndex 
                    WHERE orderID >= @FirstRec 
                      AND orderID <= @LastRec)
ORDER BY m.PostDate

DROP TABLE #mIndex

UPDATE SMB_Messages
SET TotalViews = TotalViews + 1
WHERE MessageID = @MessageID

-- update nofification mailers to send again
UPDATE SMB_EmailNotify
SET NotifySent = 0
WHERE UserGUID = @UserGUID
  AND ParentMsgID = @MessageID

UPDATE SMB_ForumSubscribe
SET NotifySent = 0
WHERE UserGUID = @UserGUID
  AND ForumID = @ForumID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO




CREATE   PROCEDURE TB_GetMissingEditMessages
AS
SELECT MessageText, MessageID
FROM SMB_Messages
WHERE EditableText IS NULL
  AND MessageText IS NOT NULL


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_GetMyPMs
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID 
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID)

IF @UID IS NULL
  BEGIN
    SET @UID = 0  -- should always return 0 messages
  END
SELECT m.umpid,
       m.Subject,
       m.DateTimeSent,
       p.UserName,
       m.BeenViewed,
       m.IsSentItem
FROM SMB_PrivateMessage m
INNER JOIN SMB_Profiles p
  ON p.UserID = m.FromID
WHERE ToID = @UID 
  And IsSentItem = 0
ORDER BY DateTimeSent DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_GetMySentPMs
	@UserGUID	UNIQUEIDENTIFIER
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID 
            FROM SMB_Profiles
            WHERE UserGUID = @UserGUID)

IF @UID IS NULL
  BEGIN
    SET @UID = 0  -- should always return 0 messages
  END
SELECT m.umpid,
       m.Subject,
       m.DateTimeSent,
       p.UserName,
       m.BeenViewed,
       m.IsSentItem
FROM SMB_PrivateMessage m
INNER JOIN SMB_Profiles p
  ON p.UserID = m.ToID
WHERE FromID = @UID 
  And IsSentItem = 1
ORDER BY DateTimeSent DESC


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_GetPMMessage
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@vType		VARCHAR(2)
AS
IF @vType = 'v'
  BEGIN
    SELECT m.MessageHTML,
           m.DateTimeSent,
           NULL,
           p.UserName,
           p.UserID,
           p.EmailAddress,
           p.ShowAddress,
           p.Homepage,
           p.AIMName,
           p.ICQNumber,
           p.TotalPosts,
           p.CreateDate,
           NULL,
           m.umpid,
           p.MSNM,
           p.YPager,
           NULL,
           p.Avatar,
           m.Subject
    FROM SMB_PrivateMessage m
    INNER JOIN SMB_Profiles p
      ON p.UserID = m.FromID
    INNER JOIN SMB_Profiles p2
      ON p2.UserID = m.ToID
    WHERE umpid = @MessageID
      AND p2.UserGUID = @UserGUID
  END
  BEGIN
    SELECT m.MessageHTML,
           m.DateTimeSent,
           NULL,
           p.UserName,
           p.UserID,
           p.EmailAddress,
           p.ShowAddress,
           p.Homepage,
           p.AIMName,
           p.ICQNumber,
           p.TotalPosts,
           p.CreateDate,
           NULL,
           m.umpid,
           p.MSNM,
           p.YPager,
           NULL,
           p.Avatar,
           m.Subject
    FROM SMB_PrivateMessage m
    INNER JOIN SMB_Profiles p
      ON p.UserID = m.FromID
    WHERE umpid = @MessageID
      AND p.UserGUID = @UserGUID
  END

UPDATE SMB_PrivateMessage
SET BeenViewed = 1
WHERE umpid = @MessageID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetPMNotifyInfo
	@umpid		INT,
	@mailTo		VARCHAR(50)	OUTPUT,
	@mailToAddr	VARCHAR(64)	OUTPUT,
	@postUser	VARCHAR(50)	OUTPUT
AS
SET @mailTo = (SELECT p.UserName
               FROM SMB_Profiles p
               INNER JOIN SMB_PrivateMessage m
                 ON m.ToID = p.UserID
               WHERE m.umpid = @umpid
                 AND UsePM = 1
                 AND PMEmail = 1)

SET @mailToAddr = (SELECT p.EmailAddress
                   FROM SMB_Profiles p
                   INNER JOIN SMB_PrivateMessage m
                     ON m.ToID = p.UserID
                   WHERE m.umpid = @umpid
                     AND UsePM = 1
                     AND PMEmail = 1)
SET @postUser = (SELECT p.UserName
                 FROM SMB_Profiles p
                 INNER JOIN SMB_PrivateMessage m
                   ON m.FromID = p.UserID
                 WHERE m.umpid = @umpid)

IF @mailTo IS NULL
  BEGIN
    SET @mailTo = ''
  END
IF @mailToAddr IS NULL
  BEGIN
    SET @mailToAddr = ''
  END
IF @postUser IS NULL
  BEGIN
    SET @postUser = ''
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetParentID
	@MessageID	INT,
	@ParentID	INT	OUTPUT
AS
SET @ParentID = (SELECT ParentMsgID 
                 FROM SMB_Messages
                 WHERE MessageID = @MessageID)
IF @ParentID IS NULL
  BEGIN
    SET @ParentID = @MessageID
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetPollValues
	@MessageID	INT
AS
SELECT pollID,
       pollText,
       voteCount,
       (SELECT SUM(voteCount) FROM SMB_PollQs WHERE messageID = @MessageID)
FROM SMB_PollQs
WHERE messageID = @MessageID
ORDER BY pollID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetReConfirmInfo
	@ConfID		INT,
	@UserName	VARCHAR(50)		OUTPUT,
	@UserMail	VARCHAR(64)		OUTPUT,
	@MailGUID	UNIQUEIDENTIFIER	OUTPUT

AS
DECLARE @UGUID	UNIQUEIDENTIFIER
SET @UGUID = (SELECT UserGUID FROM SMB_MailConfirm WHERE CID = @ConfID)
IF @UGUID IS NOT NULL
  BEGIN
    SET @UserMail = (SELECT EmailAddress FROM SMB_Profiles WHERE UserGUID = @UGUID)
    SET @UserName = (SELECT UserName FROM SMB_Profiles WHERE UserGUID = @UGUID)
    SET @MailGUID = (SELECT ConfirmGUID FROM SMB_MailConfirm WHERE CID = @ConfID)
  END
ELSE
  BEGIN
    SET @UserMail = ''
    SET @UserName = ''
    SET @MailGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetSignature
	@UserGUID	uniqueidentifier
AS
SELECT Signature
FROM SMB_Profiles
WHERE UserGUID = @UserGUID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_GetSiteStats
AS
SELECT s.totalPosts,
       s.totalThreads,
       s.totalUsers,
       s.newestUser,
       p.UserName,
       p.CreateDate     
FROM SMB_Stats s
LEFT JOIN SMB_Profiles p
  ON p.UserID = s.newestUser



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO






CREATE PROCEDURE TB_GetStickyThreads
	@ForumID	int
AS
SELECT m.MessageID,
       m.MessageTitle,
       m.PostDate,
       m.TotalReplies,
       m.TotalViews,
       m.LastReplyDate,
       p.UserID,
       p.UserName,
       m.IsPoll,
       p2.UserID,
       p2.UserName,
       m.TopicLocked,
       m.PostIcon
FROM SMB_Messages m
INNER JOIN SMB_Profiles p
  ON p.UserGUID = m.UserGUID
LEFT JOIN SMB_Profiles p2
  ON p2.UserGUID = m.LastReplyUserID
WHERE ForumID = @ForumID
  AND isParentMsg = 1
  AND IsSticky = 1
ORDER BY PostDate DESC








GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_GetTitles
AS
SELECT minPosts,
       maxPosts,
       titleText
FROM SMB_Titles
ORDER BY minPosts


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetUserExperience
AS
SELECT eu1,
       eu2,
       eu3,
       eu4,
       eu5,
       eu6,
       eu7,
       eu8,
       eu9,
       eu10,
       eu11,
       eu12,
       eu13,
       eu14,
       eu15,
       eu16,
       eu17,
       eu18,
       eu19,
       eu20,
       eu21,
       eu22,
       eu23,
       eu24,
       eu25,
       eu26,
       eu27,
       eu28,
       eu29,
       eu30,
       eu31,
       eu32,
       eu33,
       eu34,
       eu35,
       eu36
FROM SMB_UserExperience


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_GetUserForPM
	@UserName	VARCHAR(50)
AS
SELECT UserName
FROM SMB_Profiles
WHERE UserName LIKE @UserName
  AND UsePM = 1
  AND PMAdminLock = 1



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetUserGUIDFROMNTAuth
	@AUTH_USER	VARCHAR(100),
	@UserGUID	UNIQUEIDENTIFIER	OUTPUT
AS
SET @UserGUID = (SELECT UserGUID 
                 FROM SMB_Profiles
                 WHERE UserName = @AUTH_USER
                   AND MailVerify = 1)
IF @UserGUID IS NULL
  BEGIN
    SET @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE     PROCEDURE TB_GetUserProfile
	@UserGUID	uniqueidentifier
AS
SELECT RealName,
       UserName,
       uPassword,
       EmailAddress,
       ShowAddress,
       HomePage,
       AIMName,
       ICQNumber,
       TimeOffset,
       EditableSignature,
       Signature,
       MSNM,
       YPager,
       HomeLocation,
       Occupation,
       Interests,
       Avatar,
       UsePM,
       PMPopUp,
       PMEmail,
       PMAdminLock
 

FROM SMB_Profiles
WHERE UserGUID = @UserGUID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetUserProfile2
	@UserGUID	uniqueidentifier
AS
SELECT RealName,
       UserName,
       euPassword,
       EmailAddress,
       ShowAddress,
       HomePage,
       AIMName,
       ICQNumber,
       TimeOffset,
       EditableSignature,
       Signature,
       MSNM,
       YPager,
       HomeLocation,
       Occupation,
       Interests,
       Avatar,
       UsePM,
       PMPopUp,
       PMEmail,
       PMAdminLock,
       UserTitle
 

FROM SMB_Profiles
WHERE UserGUID = @UserGUID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetWhoCanPost
	@ForumID	INT,
	@WhoPost	INT	OUTPUT
AS
SET @WhoPost = (SELECT WhoPost FROM SMB_Forums WHERE ForumID = @ForumID)
IF @WhoPost IS NULL
  BEGIN
    SET @WhoPost = 1
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_LookupLogin
	@EmailAddr	VARCHAR(64),
	@UserName	VARCHAR(50)	OUTPUT,
	@UserPassword	VARCHAR(50)	OUTPUT
AS
DECLARE @UID	INT
SET @UID = (SELECT TOP 1 UserID
            FROM SMB_Profiles
            WHERE EmailAddress = @EmailAddr
              AND UserName != ''
              AND euPassword != '')
IF @UID IS NULL
  BEGIN
    SET @UserName = ''
    SET @UserPassword = ''
  END
ELSE
  BEGIN
    SET @UserName = (SELECT UserName 
                     FROM SMB_Profiles 
                     WHERE UserID = @UID)
    SET @UserPassword = (SELECT euPassword 
                         FROM SMB_Profiles 
                         WHERE UserID = @UID)
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_MailerVerify
	@ConfirmGUID	UNIQUEIDENTIFIER,
	@mailConfirm	BIT	OUTPUT
AS
DECLARE @CID 	INT
SET @CID = (SELECT CID
            FROM SMB_MailConfirm
            WHERE ConfirmGUID = @ConfirmGUID)
IF @CID IS NULL
  BEGIN
   SET @mailConfirm = 0
  END
ELSE
  BEGIN
    UPDATE SMB_Profiles
    SET MailVerify = 1
    WHERE UserGUID = (SELECT UserGUID
                      FROM SMB_MailConfirm
                      WHERE CID = @CID)
    DELETE SMB_MailConfirm
    WHERE CID = @CID
    SET @mailConfirm = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO


CREATE PROCEDURE TB_MessageTitle
	@MessageID	int,
	@MessageTitle	varchar(100) 	OUTPUT

AS
SET @MessageTitle = (SELECT MessageTitle FROM SMB_Messages WHERE MessageID = @MessageID)

IF @MessageTitle IS NULL OR @MessageTitle = ''
  BEGIN
    SET @MessageTitle = ''
  END

SELECT @MessageTitle

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_MissingEditMessageCount
AS
SELECT COUNT(*)
FROM SMB_Messages
WHERE EditableText IS NULL
  AND MessageText IS NOT NULL


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_MyNewPMCount
	@UserGUID	UNIQUEIDENTIFIER,
	@pmCount	INT	OUTPUT,
	@UsePM		BIT	OUTPUT
AS
SET @UsePM = (SELECT PMAdminLock
              FROM SMB_Profiles
              WHERE UserGUID = @UserGUID)
IF @UsePM IS NULL
  BEGIN
    SET @UsePM = 0
  END
IF @UsePM = 1
  BEGIN
    SET @UsePM = (SELECT UsePM
                  FROM SMB_Profiles
                  WHERE UserGUID = @UserGUID)
  END

SET @pmCount = (SELECT COUNT(umpid)
                FROM SMB_PrivateMessage m
                INNER JOIN SMB_Profiles p
                  ON p.UserID = m.ToID
                WHERE m.BeenViewed = 0
                  AND p.UserGUID = @UserGUID
                  AND IsSentItem = 0)
IF @pmCount IS NULL
  BEGIN
    SET @pmCount = 0
  END

IF @UsePM IS NULL
  BEGIN
    SET @UsePM = 0
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE   PROCEDURE TB_MyPMCount
	@UserGUID	UNIQUEIDENTIFIER,
	@pmInbox	INT	OUTPUT,
	@pmSent		INT	OUTPUT,
	@pmCount	INT	OUTPUT,
	@pmMax		INT	OUTPUT,
	@UsePM		BIT	OUTPUT
AS

SET @pmMax = (SELECT TOP 1 eu29
              FROM SMB_UserExperience)

SET @pmCount = (SELECT COUNT(umpid)
                FROM SMB_PrivateMessage m
                INNER JOIN SMB_Profiles p
                  ON p.UserID = m.ToID
                WHERE m.BeenViewed = 0
                  AND p.UserGUID = @UserGUID
                  AND IsSentItem = 0)

SET @pmInbox = (SELECT COUNT(umpid)
                FROM SMB_PrivateMessage m
                INNER JOIN SMB_Profiles p
                  ON p.UserID = m.ToID
                WHERE m.IsSentItem = 0
                  AND p.UserGUID = @UserGUID) 

SET @pmSent = (SELECT COUNT(umpid)
               FROM SMB_PrivateMessage m
               INNER JOIN SMB_Profiles p
                 ON p.UserID = m.FromID
               WHERE m.IsSentItem = 1
                 AND p.UserGUID = @UserGUID) 
SET @UsePM = (SELECT PMAdminLock 
              FROM SMB_Profiles
              WHERE UserGUID = @UserGUID)
IF @UsePM IS NULL
  BEGIN
    SET @UsePM = 0
  END
IF @UsePM = 1
  BEGIN
    SET @UsePM = (SELECT UsePM
                  FROM SMB_Profiles
                  WHERE UserGUID = @UserGUID)
  END
IF @pmMax IS NULL
  BEGIN
    SET @pmMax = 50
  END
IF @pmCount IS NULL
  BEGIN
    SET @pmCount = 0
  END
IF @pmInbox IS NULL
  BEGIN
    SET @pmInbox = 0
  END
IF @pmSent IS NULL
  BEGIN
    SET @pmSent = 0
  END
IF @UsePM IS NULL
  BEGIN
    SET @UsePM = 0
  END



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_SetEncPass
	@UserGUID	UNIQUEIDENTIFIER,
	@euPassword	VARCHAR(100)
AS
UPDATE SMB_Profiles
SET euPassword = @euPassword
WHERE UserGUID = @UserGUID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_SubscribeToForum
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT,
	@ForumName	VARCHAR(50)	OUTPUT
AS
SET @ForumName = (SELECT ForumName
                  FROM SMB_Forums
                  WHERE ForumID = @ForumID)
IF @ForumName IS NULL
  BEGIN
    SET @ForumName = ''
  END
ELSE
  BEGIN
    INSERT INTO SMB_ForumSubscribe(UserGUID, ForumID)
    VALUES(@UserGUID, @ForumID)
  END





GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ThreadCount
	@MessageID	INT,
	@ForumID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@ThreadCount	INT	OUTPUT,
	@IsLocked	BIT	OUTPUT
AS
DECLARE @UID	INT
SET @UID = (SELECT UserID FROM SMB_Profiles WHERE UserGUID = @UserGUID)

SET @ThreadCount = (SELECT COUNT(*)
                    FROM SMB_Messages
                    WHERE (MessageID = @MessageID OR ParentMsgID = @MessageID)
                      AND ForumID = @ForumID
                      AND UserGUID NOT IN (SELECT p.UserGUID
                                             FROM SMB_Profiles p
                                             INNER JOIN SMB_Ignored i
                                               ON i.IgnoreID = p.UserID
                                             WHERE i.UserID = @UID))
SET @IsLocked = (SELECT TopicLocked 
                 FROM SMB_Messages
                 WHERE MessageID = @MessageID)

IF @ThreadCount IS NULL OR @ThreadCount = ''
  BEGIN
    SET @ThreadCount = 0
  END 

IF @IsLocked IS NULL
  BEGIN
    SET @IsLocked = 1
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO








CREATE       PROCEDURE TB_TopListing

AS
SELECT  f.ForumID, 
	f.ForumName, 
	f.TotalPosts, 
	f.TotalTopics, 
	f.LastPostDate, 
	f.LastPostTopic, 
	m.MessageTitle,
	m.LastPostType,
	p.UserID,
        p.UserName,
	f.IsPrivate,
        f.ForumDesc
	
FROM SMB_Forums f
LEFT JOIN SMB_Messages m
  ON f.LastPostTopic = m.MessageID
LEFT JOIN SMB_Profiles p
  ON m.LastReplyUserID = p.UserGUID


ORDER BY IsPrivate, ForumName







GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_TopListing2
	@UserGUID	UNIQUEIDENTIFIER
AS
SELECT  f.ForumID, 
	f.ForumName, 
	f.TotalPosts, 
	f.TotalTopics, 
	f.LastPostDate, 
	f.LastPostTopic, 
	m.MessageTitle,
	m.LastPostType,
	p.UserID,
        p.UserName,
	f.IsPrivate,
        f.ForumDesc,
        f.AccessPermission,
        c.CategoryName,
        c.CategoryDesc,
        (SELECT MAX(MessageID) FROM SMB_Messages WHERE MessageID = f.LastPostTopic OR ParentMsgID = f.LastPostTopic),
        c.CategoryID,
        (SELECT COUNT(MessageID) FROM SMB_Messages WHERE MessageID = f.LastPostTopic OR ParentMsgID = f.LastPostTopic),
        f.WhoPost
	
FROM SMB_Forums f
INNER JOIN SMB_ForumCategories c
  ON c.CategoryID = f.CategoryID
LEFT JOIN SMB_Messages m
  ON f.LastPostTopic = m.MessageID
LEFT JOIN SMB_Profiles p
  ON m.LastReplyUserID = p.UserGUID
WHERE f.IsPrivate = 0
  OR f.ForumID IN (SELECT ForumID
                   FROM SMB_PrivateAccess a
                   INNER JOIN SMB_Profiles p
                     ON p.UserID = a.UserID
                   WHERE p.UserGUID = @UserGUID)
ORDER BY c.CategoryOrder, f.ForumOrder, f.ForumName


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_Unsubscribe
	@UserGUID	UNIQUEIDENTIFIER,
	@MessageID	INT
AS
DELETE SMB_EmailNotify
WHERE UserGUID = @UserGUID
  AND ParentMsgID = @MessageID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_UnsubscribeToForum
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT,
	@ForumName	VARCHAR(50)	OUTPUT
AS
SET @ForumName = (SELECT ForumName
                  FROM SMB_Forums
                  WHERE ForumID = @ForumID)
IF @ForumName IS NULL
  BEGIN
    SET @ForumName = ''
  END
ELSE
  BEGIN
    DELETE SMB_ForumSubscribe
    WHERE UserGUID = @UserGUID
      AND ForumID = @ForumID
  END




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_UpdateOnlineUsers
	@UserGUID	UNIQUEIDENTIFIER,
	@UserIP		VARCHAR(20),
	@LastForum	INT,
	@LastVisit	DATETIME	OUTPUT
AS
DECLARE @TID	INT
DECLARE @TimeOffset	INT
-- If guest account
SET @LastVisit = GETUTCDATE()
IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    SET @TimeOffset = 0
    SET @TID = (SELECT tempID
                FROM SMB_ActiveVisiting
                WHERE UserGUID = @UserGUID
                  AND UserIP = @UserIP)
    IF @TID IS NULL	
      BEGIN
        INSERT INTO SMB_ActiveVisiting(UserGUID, UserIP, LastView, LastForum)
        VALUES(@UserGUID, @UserIP, GETUTCDATE(), @LastForum)
      END
    ELSE
      BEGIN
        UPDATE SMB_ActiveVisiting
        SET LastView = GETUTCDATE(),
            LastForum = @LastForum
        WHERE tempID = @TID
      END
  END
ELSE	-- not guest
  BEGIN
    SET @TimeOffset = (SELECT TimeOffset
                       FROM SMB_Profiles
                       WHERE UserGUID = @UserGUID)
    SET @LastVisit = (SELECT LastLoginDate
                      FROM SMB_Profiles
                      WHERE UserGUID = @UserGUID)
    SET @TID = (SELECT tempID
                FROM SMB_ActiveVisiting
                WHERE UserGUID = @UserGUID)
    IF @TID IS NULL
      BEGIN
        INSERT INTO SMB_ActiveVisiting(UserGUID, UserIP, LastView, LastForum)
        VALUES(@UserGUID, @UserIP, GETUTCDATE(), @LastForum)
      END

    ELSE
      BEGIN
        UPDATE SMB_ActiveVisiting
        SET LastView = GETUTCDATE(),
            UserIP = @UserIP,
            LastForum = @LastForum
        WHERE tempID = @TID     
      END

    UPDATE SMB_Profiles
    SET LastIPAddress = @UserIP,
      LastLoginDate = GETUTCDATE()
    WHERE UserGUID = @UserGUID
  END
-- Remove all entries older than 15 min
DELETE SMB_ActiveVisiting
WHERE LastView < DateAdd(minute, -5, GETUTCDATE())



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_UpdateOnlineUsers2
	@UserGUID	UNIQUEIDENTIFIER,
	@UserIP		VARCHAR(20),
	@LastForum	INT,
	@LastVisit	DATETIME	OUTPUT,
	@TimeOffset	DECIMAL		OUTPUT,
	@UserTheme	VARCHAR(50)	OUTPUT
AS
DECLARE @TID	INT
-- If guest account
SET @LastVisit = GETUTCDATE()
IF @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  BEGIN
    SET @TimeOffset = 0
    SET @UserTheme = (SELECT eu32 FROM SMB_UserExperience)
    SET @TID = (SELECT tempID
                FROM SMB_ActiveVisiting
                WHERE UserGUID = @UserGUID
                  AND UserIP = @UserIP)
    IF @TID IS NULL	
      BEGIN
        INSERT INTO SMB_ActiveVisiting(UserGUID, UserIP, LastView, LastForum)
        VALUES(@UserGUID, @UserIP, GETUTCDATE(), @LastForum)
      END
    ELSE
      BEGIN
        UPDATE SMB_ActiveVisiting
        SET LastView = GETUTCDATE(),
            LastForum = @LastForum
        WHERE tempID = @TID
      END
  END
ELSE	-- not guest
  BEGIN
    SET @TimeOffset = (SELECT TimeOffset
                       FROM SMB_Profiles
                       WHERE UserGUID = @UserGUID)
    SET @UserTheme = (SELECT UserTheme
                       FROM SMB_Profiles
                       WHERE UserGUID = @UserGUID)
    IF @UserTheme IS NULL
      BEGIN
        SET @UserTheme = (SELECT eu32 FROM SMB_UserExperience)
      END
    SET @LastVisit = (SELECT LastLoginDate
                      FROM SMB_Profiles
                      WHERE UserGUID = @UserGUID)
    SET @TID = (SELECT tempID
                FROM SMB_ActiveVisiting
                WHERE UserGUID = @UserGUID)
    IF @TID IS NULL
      BEGIN
        INSERT INTO SMB_ActiveVisiting(UserGUID, UserIP, LastView, LastForum)
        VALUES(@UserGUID, @UserIP, GETUTCDATE(), @LastForum)
      END

    ELSE
      BEGIN
        UPDATE SMB_ActiveVisiting
        SET LastView = GETUTCDATE(),
            UserIP = @UserIP,
            LastForum = @LastForum
        WHERE tempID = @TID     
      END

    UPDATE SMB_Profiles
    SET LastIPAddress = @UserIP,
      LastLoginDate = GETUTCDATE()
    WHERE UserGUID = @UserGUID
  END
-- Remove all entries older than 15 min
DELETE SMB_ActiveVisiting
WHERE LastView < DateAdd(minute, -5, GETUTCDATE())

IF @TimeOffset IS NULL
  BEGIN
    SET @TimeOffset = 0.0
  END
IF @UserTheme IS NULL
  BEGIN
    SET @UserTheme = 'default'
  END
IF @LastVisit IS NULL
  BEGIN
    SET @LastVisit = GETUTCDATE()
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_UpdateProfile
	@RealName	VARCHAR(100),
	@uPassword	VARCHAR(50),
	@EmailAddress	VARCHAR(64),
	@ShowAddress	INT,
	@Homepage	VARCHAR(200),
	@AIMName	VARCHAR(100),
	@ICQNumber	INT,
	@TimeOffset	INT,
	@EditSignature	TEXT,
	@Signature	TEXT,
	@UserGUID	UNIQUEIDENTIFIER,
	@MSNM		VARCHAR(64) = NULL,
	@YPager		VARCHAR(50) = NULL,
	@HomeLocation	VARCHAR(100) = NULL,
	@Occupation	VARCHAR(150) = NULL,
	@Interests	TEXT = NULL,
	@UserTheme	VARCHAR(50) = 'default',
	@Avatar		VARCHAR(200) = NULL,
	@UsePM		BIT = 1,
	@PMPopUp	BIT = 1,
	@PMEmail	BIT = 1

AS
UPDATE SMB_Profiles
SET RealName = @RealName,
    uPassword = @uPassword,
    EmailAddress = @EmailAddress,
    ShowAddress = @ShowAddress,
    HomePage = @HomePage,
    AIMName = @AIMName,
    ICQNumber = @ICQNumber,
    TimeOffset = @TimeOffset,
    EditableSignature = @EditSignature,
    Signature = @Signature,
    MSNM = @MSNM,
    YPager = @YPager,
    HomeLocation = @HomeLocation,
    Occupation = @Occupation,
    Interests = @Interests,
    Avatar = @Avatar,
    UsePM = @UsePM,
    PMPopUp = @PMPopUp,
    PMEmail = @PMEmail,
    UserTheme = @UserTheme

WHERE UserGUID = @UserGUID



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_UpdateProfile2
	@RealName	VARCHAR(100),
	@euPassword	VARCHAR(100),
	@EmailAddress	VARCHAR(64),
	@ShowAddress	INT,
	@Homepage	VARCHAR(200),
	@AIMName	VARCHAR(100),
	@ICQNumber	INT,
	@TimeOffset	INT,
	@EditSignature	TEXT,
	@Signature	TEXT,
	@UserGUID	UNIQUEIDENTIFIER,
	@MSNM		VARCHAR(64) = NULL,
	@YPager		VARCHAR(50) = NULL,
	@HomeLocation	VARCHAR(100) = NULL,
	@Occupation	VARCHAR(150) = NULL,
	@Interests	TEXT = NULL,
	@UserTheme	VARCHAR(50) = 'default',
	@Avatar		VARCHAR(200) = NULL,
	@UsePM		BIT = 1,
	@PMPopUp	BIT = 1,
	@PMEmail	BIT = 1

AS
UPDATE SMB_Profiles
SET RealName = @RealName,
    euPassword = @euPassword,
    EmailAddress = @EmailAddress,
    ShowAddress = @ShowAddress,
    HomePage = @HomePage,
    AIMName = @AIMName,
    ICQNumber = @ICQNumber,
    TimeOffset = @TimeOffset,
    EditableSignature = @EditSignature,
    Signature = @Signature,
    MSNM = @MSNM,
    YPager = @YPager,
    HomeLocation = @HomeLocation,
    Occupation = @Occupation,
    Interests = @Interests,
    Avatar = @Avatar,
    UsePM = @UsePM,
    PMPopUp = @PMPopUp,
    PMEmail = @PMEmail,
    UserTheme = @UserTheme

WHERE UserGUID = @UserGUID




GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_UserEncLogon
	@UserName	VARCHAR(50),
	@UserPass	VARCHAR(100),
	@UserGUID	UNIQUEIDENTIFIER	OUTPUT,
	@MailVerify	BIT			OUTPUT,
	@AdminBan	BIT			OUTPUT,
	@ConfID		INT			OUTPUT

AS
SET @UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = @UserName AND euPassword = @UserPass AND NTAuth != 1)
SET @MailVerify = (SELECT MailVerify FROM SMB_Profiles WHERE UserName = @UserName AND euPassword = @UserPass AND NTAuth != 1)
SET @AdminBan = (SELECT AdminBan FROM SMB_Profiles WHERE UserName = @UserName AND euPassword = @UserPass AND NTAuth != 1)
IF @UserGUID IS NULL
  BEGIN
    SET @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END 
IF @MailVerify IS NULL
  BEGIN
    SET @MailVerify = 0
    SET @ConfID = (SELECT CID FROM SMB_MailConfirm WHERE UserGUID = @UserGUID)
  END
ELSE
  BEGIN
    IF @MailVerify = 0
      BEGIN
        SET @ConfID = (SELECT CID FROM SMB_MailConfirm WHERE UserGUID = @UserGUID)
      END
  END
IF @AdminBan IS NULL
  BEGIN
    SET @AdminBan = 0
  END
IF @ConfID IS NULL
  BEGIN
    SET @ConfID = 0
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS OFF 
GO


CREATE PROCEDURE TB_UserLogon
	@UserName	varchar(50),
	@UserPass	varchar(50),
	@UserGUID	uniqueidentifier	OUTPUT

AS
SET @UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = @UserName AND uPassword = @UserPass)
IF @UserGUID IS NULL
  BEGIN
    SET @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END 

SELECT @UserGUID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_UserLogon2
	@UserName	VARCHAR(50),
	@UserPass	VARCHAR(50),
	@UserGUID	UNIQUEIDENTIFIER	OUTPUT,
	@MailVerify	BIT			OUTPUT,
	@AdminBan	BIT			OUTPUT

AS
SET @UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = @UserName AND uPassword = @UserPass AND NTAuth != 1)
SET @MailVerify = (SELECT MailVerify FROM SMB_Profiles WHERE UserName = @UserName AND uPassword = @UserPass AND NTAuth != 1)
SET @AdminBan = (SELECT AdminBan FROM SMB_Profiles WHERE UserName = @UserName AND uPassword = @UserPass)
IF @UserGUID IS NULL
  BEGIN
    SET @UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END 
IF @MailVerify IS NULL
  BEGIN
    SET @MailVerify = 0
  END
IF @AdminBan IS NULL
  BEGIN
    SET @AdminBan = 0
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE PROCEDURE TB_UserNameFromGUID
	@UserGUID	uniqueidentifier,
	@UserName	varchar(100)	OUTPUT
AS

SET @UserName = (SELECT UserName
                 FROM SMB_Profiles
                 WHERE UserGUID = @UserGUID)

SELECT @UserName



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ViewProfile
	@UserID		INT
AS

SELECT UserName,
       EmailAddress,
       ShowAddress,
       Homepage,
       AIMName,
       ICQNumber,
       TotalPosts,
       CreateDate,
       MSNM,
       YPager,
       HomeLocation,
       Occupation,
       Interests,
       LastLoginDate,
       UsePM,
       PMAdminLock
FROM SMB_Profiles
WHERE UserID = @UserID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO



CREATE  PROCEDURE TB_WhosOnlineNow
AS
DECLARE @AGuest		INT
DECLARE @RVisit		INT

SET @AGuest = (SELECT COUNT(*) 
               FROM SMB_ActiveVisiting
               WHERE UserGUID = '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}')
SET @RVisit = (SELECT COUNT(*) 
               FROM SMB_ActiveVisiting
               WHERE UserGUID != '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}')

IF @RVisit > 0
  BEGIN
    SELECT @AGuest,
           @RVisit,
           p.UserName,
           p.UserID
    FROM SMB_Profiles p
    INNER JOIN SMB_ActiveVisiting a
      ON a.UserGUID = p.UserGUID
    WHERE a.UserGUID != '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}'
  END
ELSE
  BEGIN
    SELECT @AGuest,
           @RVisit,
           NULL,
           NULL
  END   



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO





------------------------------------------------
-- Now the data loading....
-- SMB_AdminCategory
INSERT INTO SMB_AdminCategory(CategoryName, CategoryID)
VALUES('Forum Configuration', 1)
INSERT INTO SMB_AdminCategory(CategoryName, CategoryID)
VALUES('Forum Tools', 2)
INSERT INTO SMB_AdminCategory(CategoryName, CategoryID)
VALUES('User Tools',3)

-- SMB_AdminMenuTitles
SET IDENTITY_INSERT SMB_AdminMenuTitles ON
INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Private Forum Access',4,2,4)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Edit / Delete User Profiles',7,3,6)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Add / Remove Custom Titles',8,3,5)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Sticky Thread',9,2,5)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Move A Thread',10,2,6)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Add / Edit Moderators',11,3,7)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Add / Edit Admin Menu Access',12,3,8)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Thread Pruning',13,2,4)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Web.Config Viewer',15,1,1)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Emoticons',16,2,2)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Avatars',17,2,3)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('End User Experience',18,3,1)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Word Censoring',19,2,7)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('IP Ban',20,2,8)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('E-Mail Ban',22,2,9)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Forum Builder',23,2,1)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Who Voted',24,3,10)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Administrative Mailer',25,3,9)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Lock / Unlock Threads',26,2,10)

INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Pending Accounts',27,3,11)
SET IDENTITY_INSERT SMB_AdminMenuTitles OFF

-- SMB_ForumCategories
SET IDENTITY_INSERT SMB_ForumCategories ON
INSERT INTO SMB_ForumCategories(CategoryName, CategoryID, CategoryOrder)
VALUES('Public Forums', 1, 2)
INSERT INTO SMB_ForumCategories(CategoryName, CategoryID, CategoryOrder)
VALUES('General Information', 2, 1)
INSERT INTO SMB_ForumCategories(CategoryName, CategoryID, CategoryOrder)
VALUES('Private Forums', 3, 3)
SET IDENTITY_INSERT SMB_ForumCategories OFF

-- SMB_Forums
SET IDENTITY_INSERT SMB_Forums ON
INSERT INTO SMB_Forums(ForumID, ForumName, ForumDesc, CategoryID, TotalPosts, TotalTopics, IsPrivate, AccessPermission, ForumOrder, WhoPost)
VALUES(1, 'Test Forum', 'Use this forum to test signatures, posts, etc.', 1, 0, 0, 0, 1, 1, 2)

INSERT INTO SMB_Forums(ForumID, ForumName, ForumDesc, CategoryID, TotalPosts, TotalTopics, IsPrivate, AccessPermission, ForumOrder, WhoPost)
VALUES(2, 'General Chat', 'Use this forum to chat about anything.', 1, 0, 0, 0, 1, 1, 1)

INSERT INTO SMB_Forums(ForumID, ForumName, ForumDesc, CategoryID, TotalPosts, TotalTopics, IsPrivate, AccessPermission, ForumOrder, WhoPost)
VALUES(3, 'Announcements', 'Use this forum contains administrative announcements and information.', 2, 0, 0, 0, 1, 1, 3)

INSERT INTO SMB_Forums(ForumID, ForumName, ForumDesc, CategoryID, TotalPosts, TotalTopics, IsPrivate, AccessPermission, ForumOrder, WhoPost)
VALUES(4, 'Private Access', 'This forum is locked to selected members only.', 3, 0, 0, 1, 3, 1, 1)

SET IDENTITY_INSERT SMB_Forums OFF

-- SMB_Profiles
SET IDENTITY_INSERT SMB_Profiles ON

INSERT INTO SMB_Profiles(RealName, UserName, euPassword, HomePage, ICQNumber, TimeOffset,
                         TotalPosts, UserID, PostAllowed, IsGlobalAdmin, CreateDate, ShowAddress,
                         EmailAddress, IsModerator, UserGUID, UsePM, PMPopUp, PMEmail, PMAdminLock, 
                         MailVerify, AdminBan, UserTheme, NTAuth)
VALUES('Guest Account', 'GUEST', 'p:FXnN>LMh<<HNGM', 'http://www.dotNetBB.com', 0, 0, 0, 2, 0, 0, GETUTCDATE(), 0, '', 0, '{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}', 0, 0, 0, 1, 1, 0, 'dotNetBB', 0)


INSERT INTO SMB_Profiles(RealName, UserName, euPassword, HomePage, ICQNumber, TimeOffset,
                         TotalPosts, UserID, PostAllowed, IsGlobalAdmin, CreateDate, ShowAddress, 
                         EmailAddress, IsModerator, UserGUID, UsePM, PMPopUp, PMEmail, PMAdminLock, 
                         MailVerify, AdminBan, UserTheme, NTAuth)
VALUES('Site Admin', 'Admin', ':]\[ZYX\', 'http://www.dotNetBB.com', 0, 0, 0, 1, 1, 1, GETUTCDATE(), 0, '', 1, NEWID(), 1, 1, 0, 1, 1, 0, 'dotNetBB', 0)

SET IDENTITY_INSERT SMB_Profiles OFF

-- SMB_Stats
INSERT INTO SMB_Stats(totalPosts, totalThreads, totalUsers, newestUser)
VALUES(0,0,0,0)

-- SMB_Titles
SET IDENTITY_INSERT SMB_Titles ON
INSERT INTO SMB_Titles(titleID, minPosts, maxPosts, titleText)
VALUES(1, 1, 999999, 'Registered Member')
SET IDENTITY_INSERT SMB_Titles OFF

--SMB_UserExperience
INSERT INTO SMB_UserExperience(eu1, eu2, eu3, eu4, eu5, eu6, eu7, eu8, eu9, eu10, eu11, eu12,
                               eu13, eu14, eu15, eu16, eu17, eu18, eu19, eu20, eu21, eu22, eu23,
                               eu24, eu25, eu26, eu27, eu28, eu29, eu30, eu31, eu32, eu33, eu34, eu35, eu36)
VALUES(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 30, 1, 1, 1, 1, '75,75', 1, 1, 1, 1, 1, 1, 1, 1, '', '', 15, 0, 50, 1, 0, 'dotNetBB', '', '', 1, 0)


-- SMB_Moderators
SET IDENTITY_INSERT SMB_Moderators ON
INSERT INTO SMB_Moderators(userID, forumID, smbfid, adminID, dateModified)
VALUES(1, 1, 1, 1, GETUTCDATE())
SET IDENTITY_INSERT SMB_Moderators OFF

-- SMB_PrivateAccess
SET IDENTITY_INSERT SMB_PrivateAccess ON
INSERT INTO SMB_PrivateAccess(UserID, ForumID, DateModified, AdminID, spaID)
VALUES(1, 4, GETUTCDATE(), 1, 1)
SET IDENTITY_INSERT SMB_PrivateAccess OFF

-- SMB_Messages
DECLARE @NewPostID	INT	-- just a placeholder for the new topic posting
DECLARE @uGUID		UNIQUEIDENTIFIER
SET @uGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserID = 1)

EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     1, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @uGUID, 
                     @NewPostID

EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     2, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @uGUID, 
                     @NewPostID
                     
EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     3, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @uGUID, 
                     @NewPostID                    

EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     4, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @uGUID, 
                     @NewPostID
                     
                     
-- SMB_AdminMenuAccess
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 4)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 7)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 8)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 9)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 10)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 11)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 12)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 13)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 15)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 16)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 17)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 18)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 19)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 20)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 22)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 23)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 24)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 25)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 26)
INSERT INTO SMB_AdminMenuAccess(UserID, MenuID)
VALUES (1, 27)

-- SMB_Emoticons

INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('blush.gif',':blush:','blush')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('burger.gif',':burger:','burger')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('confused.gif',':confused:','confused')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('cool.gif',':cool:','cool')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('cry.gif',':cry:','cry')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('devil.gif',':devil:','devil')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('eyes.gif',':eyes:','eyes')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('freaked.gif',':freaked:','freaked')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('hop.gif',':hop:','hop')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('idea.gif',':idea:','idea')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('rofl.gif',':rofl:','rofl')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('roll.gif',':roll:','roll')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('jumpin.gif',':jumpin:','jumpin')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('lol.gif',':lol:','lol')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('mad.gif',':mad:','mad')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('nono.gif',':nono:','nono')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('redface.gif',':redface:','redface')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('rolleyes.gif',':rolleyes:','rolleyes')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('sad.gif',':sad:','sad')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('scool.gif',':scool:','scool')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('shakehead.gif',':shakehead:','shakehead')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('shocked.gif',':shocked:','shocked')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('skull.gif',':skull:','skull')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('smhair.gif',':smhair:','smhair')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('smile.gif',':smile:','smile')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('smilewinkgrin.gif',':smilewinkgrin:','smilewinkgrin')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('smurf.gif',':smurf:','smurf')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('tongue.gif',':tongue:','tongue')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('turn.gif',':turn:','turn')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('wink.gif',':wink:','wink')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('yeah.gif',':yeah:','yeah')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('smile.gif',':-)',':-)')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('wink.gif',';-)',';-)')
	
INSERT INTO SMB_Emoticons(imageName, imageKeys, imageAltText)
VALUES('tongue.gif',':p',':p')

----------------
-- v2.1 items
SET IDENTITY_INSERT SMB_AdminMenuTitles ON
INSERT INTO SMB_AdminMenuTitles(menuTitle, MenuID, CategoryID, MenuOrder)
VALUES('Administrator Action Log',28,2,12)
SET IDENTITY_INSERT SMB_AdminMenuTitles OFF
GO

UPDATE SMB_UserExperience
SET eu37 = 1
GO

UPDATE SMB_Forums
SET ActiveState = 1
GO

UPDATE SMB_Profiles
SET Signature = ''
WHERE Signature IS NULL
GO

UPDATE SMB_Profiles
SET EditableSignature = ''
WHERE EditableSignature IS NULL
GO

UPDATE SMB_Profiles
SET UserTheme = 'dotNetBB'
WHERE UserTheme = 'default'
GO

--------------------------------
--------------------------------
-- Updated stored procedures
--------------------------------

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_AddReplyPost]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_AddReplyPost]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_AddNewForum]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_AddNewForum]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetPendingMailers]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetPendingMailers]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_GetUserProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_GetUserProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_MoveThread]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_MoveThread]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateProfile]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateProfile]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_UpdateUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_UpdateUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetUserExperience]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetUserExperience]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_GetMemberList]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_GetMemberList]
GO

if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[TB_ADMIN_ForumListForEdit]') and OBJECTPROPERTY(id, N'IsProcedure') = 1)
drop procedure [dbo].[TB_ADMIN_ForumListForEdit]
GO


SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_ForumListForEdit

AS
SELECT  f.ForumID, 
	f.ForumName, 
	f.TotalPosts, 
	f.TotalTopics, 
	f.LastPostDate, 
	f.LastPostTopic, 
	m.MessageTitle,
	m.LastPostType,
	p.UserID,
        p.UserName,
	f.IsPrivate,
        f.ForumDesc,
        f.AccessPermission,
        c.CategoryName,
        c.CategoryDesc,
        (SELECT MAX(MessageID) FROM SMB_Messages WHERE MessageID = f.LastPostTopic OR ParentMsgID = f.LastPostTopic),
        f.ForumOrder,
	(SELECT COUNT(ForumID) FROM SMB_Forums WHERE CategoryID = f.CategoryID), 
        f.CategoryID,
        (SELECT COUNT(CategoryID) FROM SMB_ForumCategories WHERE CategoryID IN (SELECT DISTINCT CategoryID FROM SMB_Forums)),
        f.WhoPost,
        f.ActiveState
FROM SMB_Forums f
LEFT JOIN SMB_ForumCategories c
  ON c.CategoryID = f.CategoryID
LEFT JOIN SMB_Messages m
  ON f.LastPostTopic = m.MessageID
LEFT JOIN SMB_Profiles p
  ON m.LastReplyUserID = p.UserGUID
ORDER BY c.CategoryOrder, f.ForumOrder, f.ForumName


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO




SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_AddReplyPost
	@ParentMsgID	INT,
	@MessageText	TEXT,
	@EditText	TEXT,
	@NotifyUser	INT,
	@PostIcon	VARCHAR(50),
	@UserGUID	UNIQUEIDENTIFIER,
	@ForumID	INT,
	@PostIPAddr	VARCHAR(50),
	@postID		INT	OUTPUT,
	@replyCount	INT	OUTPUT

AS
DECLARE @PostDT 	datetime

SET @PostDT = GETUTCDATE()


--  First Add the post
INSERT INTO SMB_Messages(ForumID,
				ParentMsgID,
				MessageText,
				IsParentMsg,
				PostDate,
				PostIcon,
				TotalReplies,
				TotalViews,
				PostIPAddr,
				UserGUID,
                                EditableText)
VALUES(@ForumID,
	@ParentMsgID,
	@MessageText,
	0,
	@PostDT,
	@PostIcon,
	0,
	0,
	@PostIPAddr,
	@UserGUID,
        @EditText)
SET @postID = (SELECT @@IDENTITY)

-- Update Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = @PostDT,
	LastPostTopic = @ParentMsgID
WHERE ForumID = @ForumID

-- Update ParentMsg Info
UPDATE SMB_Messages
SET TotalReplies = TotalReplies + 1,
	LastReplyDate = @PostDT,
	LastReplyUserID = @UserGUID
WHERE MessageID = @ParentMsgID

-- Update Posting user profile
UPDATE SMB_Profiles
SET LastPostDate = @PostDT,
	LastPostID = @ParentMsgID,
	TotalPosts = TotalPosts + 1	
WHERE UserGUID = @UserGUID

SET @replyCount = (SELECT COUNT(MessageID) FROM SMB_Messages WHERE ParentMsgID = @ParentMsgID)
IF @replyCount IS NULL
  BEGIN
    SET @replyCount = 0
  END
SET @replyCount = @replyCount + 1

-- Add to mailer if set
IF @NotifyUser = 1 
INSERT INTO SMB_EmailNotify(ParentMsgID, UserGUID)
VALUES(@ParentMsgID, @UserGUID)

-- update site stats
EXEC TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_AddNewForum
	@ForumName		VARCHAR(50),
	@ForumDesc		VARCHAR(150),
	@AccessPermission	INT,
	@CategoryID		INT,
	@WhoPost		INT,
        @UserGUID		UNIQUEIDENTIFIER
AS
DECLARE @UserID		INT
DECLARE @UserStr	VARCHAR(6)
DECLARE @ForumID	INT
DECLARE @IsPrivate	BIT
DECLARE @NextOrder	INT

SET @NextOrder = (SELECT COUNT(ForumID) FROM SMB_Forums WHERE CategoryID = @CategoryID)
IF @NextOrder IS NULL
  BEGIN
    SET @NextOrder = 0
  END

SET @NextOrder = @NextOrder + 1


IF @AccessPermission = 3 
  BEGIN
    SET @IsPrivate = 1
  END
ELSE
  BEGIN
    SET @IsPrivate = 0
  END

INSERT INTO SMB_Forums(ForumName,
                       ForumDesc,
                       TotalPosts,
                       TotalTopics,
                       LastPostDate,
                       LastPostTopic,
                       IsPrivate,
                       AccessPermission,
                       CategoryID,
                       ForumOrder,
                       WhoPost,
                       ActiveState)
VALUES (@ForumName,
        @ForumDesc,
        0,
        0,
        GETUTCDATE(),
        0,
        @IsPrivate,
        @AccessPermission,
        @CategoryID,
        @NextOrder,
        @WhoPost,
        1)
SET @ForumID = (SELECT @@IDENTITY)

-- Create welcome posting
DECLARE @NewPostID	int	-- just a placeholder for the new topic posting
EXEC TB_AddNewTopic 'Welcome',
                     0 , 
                     @ForumID, 
                     '', 
                     'The first post in a new forum.', 
                     'The first post in a new forum.', 
                     '', 
                     @UserGUID, 
                     @NewPostID

IF @AccessPermission = 3
  BEGIN
    SET @UserID = (SELECT UserID
                   FROM SMB_Profiles
                   WHERE UserGUID = @UserGUID)

    EXEC TB_ADMIN_UpdatePrivateUsers @UserID, @ForumID, 1, @UserGUID
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetPendingMailers
AS
SELECT p.UserName,
       p.EmailAddress,
       p.UserID,
       p.CreateDate
FROM SMB_Profiles p
WHERE MailVerify = 0
 AND (SELECT COUNT(MessageID) FROM SMB_Messages WHERE UserGUID = p.UserGUID) = 0
ORDER BY UserName


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO




SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetUserExperience
AS
SELECT eu1,
       eu2,
       eu3,
       eu4,
       eu5,
       eu6,
       eu7,
       eu8,
       eu9,
       eu10,
       eu11,
       eu12,
       eu13,
       eu14,
       eu15,
       eu16,
       eu17,
       eu18,
       eu19,
       eu20,
       eu21,
       eu22,
       eu23,
       eu24,
       eu25,
       eu26,
       eu27,
       eu28,
       eu29,
       eu30,
       eu31,
       eu32,
       eu33,
       eu34,
       eu35,
       eu36,
       eu37
FROM SMB_UserExperience



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO



SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetUserProfile
	@UserID		INT
AS
SELECT RealName,
       UserName,
       euPassword,
       EmailAddress,
       ShowAddress,
       HomePage,
       AIMName,
       ICQNumber,
       TimeOffset,
       EditableSignature,
       Signature,
       Avatar,
       MSNM,
       YPager,
       HomeLocation,
       Occupation,
       Interests,
       UsePM,
       PMPopUp,
       PMEmail,
       PMAdminLock,
       MailVerify,
       AdminBan,
       UserTheme, 
       UserTitle
FROM SMB_Profiles
WHERE UserID = @UserID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_MoveThread
	@ForumID	INT,
	@MessageID	INT
AS 
DECLARE @FID	INT

SET @FID = (SELECT ForumID FROM SMB_Messages WHERE MessageID = @MessageID)

UPDATE SMB_Messages
SET ForumID = @ForumID
WHERE MessageID = @MessageID
  OR ParentMsgId = @MessageID


-- Update New Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostDate = (SELECT Max(PostDate) FROM SMB_Messages WHERE ForumID = @ForumID),
	LastPostTopic = (SELECT Max(MessageID) FROM SMB_Messages WHERE ForumID = @ForumID AND IsParentMsg = 1)
WHERE ForumID = @ForumID

-- Update old Forum info
UPDATE SMB_Forums
SET TotalTopics = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @FID AND IsParentMsg = 1),
	TotalPosts = (SELECT COUNT(*) FROM SMB_Messages WHERE ForumID = @FID),
	LastPostDate = (SELECT Max(PostDate) FROM SMB_Messages WHERE ForumID = @FID),
	LastPostTopic = (SELECT Max(MessageID) FROM SMB_Messages WHERE ForumID = @FID AND IsParentMsg = 1)
WHERE ForumID = @FID

-- update site stats
EXEC TB_UpdateStats


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_UpdateProfile
	@RealName	VARCHAR(100),
	@UserName	VARCHAR(50),
	@euPassword	VARCHAR(100),
	@EmailAddress	VARCHAR(64),
	@ShowAddress	INT,
	@Homepage	VARCHAR(200),
	@AIMName	VARCHAR(100),
	@ICQNumber	INT,
	@TimeOffset	INT,
	@EditSignature	TEXT,
	@Signature	TEXT,
	@UserID		INT,
	@Avatar		VARCHAR(200),
	@MSNM		VARCHAR(64),
	@YPager		VARCHAR(50),
	@HomeLocation	VARCHAR(100),
	@Occupation	VARCHAR(150),
	@Interests	TEXT,
	@UsePM		BIT,
	@PMPopUp	BIT,
	@PMEmail	BIT,
	@PMAdminLock	BIT,
	@MailVerify	BIT,
	@AdminBan	BIT,
	@UserTheme	VARCHAR(50),
	@UserTitle	VARCHAR(50)

AS
UPDATE SMB_Profiles
SET RealName = @RealName,
    UserName = @UserName,
    euPassword = @euPassword,
    EmailAddress = @EmailAddress,
    ShowAddress = @ShowAddress,
    HomePage = @HomePage,
    AIMName = @AIMName,
    ICQNumber = @ICQNumber,
    TimeOffset = @TimeOffset,
    EditableSignature = @EditSignature,
    Signature = @Signature,
    Avatar = @Avatar,
    MSNM = @MSNM,
    YPager = @YPager,
    HomeLocation = @HomeLocation,
    Occupation = @Occupation,
    Interests = @Interests,
    UsePM = @UsePM,
    PMPopUp = @PMPopUp,
    PMEmail = @PMEmail,
    PMAdminLock = @PMAdminLock,
    MailVerify = @MailVerify,
    AdminBan = @AdminBan,
    UserTheme = @UserTheme,
    UserTitle = @UserTitle
WHERE UserID = @UserID


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_UpdateUserExperience
	@eu1	BIT,
	@eu2	BIT,
	@eu3	BIT,
	@eu4	BIT,
	@eu5	BIT,
	@eu6	BIT,
	@eu7	BIT,
	@eu8	BIT,
	@eu9	BIT,
	@eu10	BIT,
	@eu11	INT,
	@eu12	BIT,
	@eu13	BIT,
	@eu14	BIT,
	@eu15	BIT,
	@eu16	VARCHAR(10),
	@eu17	BIT,
	@eu18	BIT,
	@eu19	BIT,
	@eu20	BIT,
	@eu21	BIT,
	@eu22	BIT,
	@eu23	BIT,
	@eu24	BIT,
	@eu25	VARCHAR(150),
	@eu26	VARCHAR(200),
	@eu27	INT,
	@eu28	BIT,
	@eu29	INT,
	@eu30	BIT,
	@eu32	VARCHAR(50),
	@eu33	VARCHAR(50),
	@eu34	VARCHAR(400),
	@eu35	BIT,
	@eu36	BIT,
	@eu37	BIT

AS
UPDATE SMB_UserExperience
SET eu1 = @eu1,
       eu2 = @eu2,
       eu3 = @eu3,
       eu4 = @eu4,
       eu5 = @eu5,
       eu6 = @eu6,
       eu7 = @eu7,
       eu8 = @eu8,
       eu9 = @eu9,
       eu10 = @eu10,
       eu11 = @eu11,
       eu12 = @eu12,
       eu13 = @eu13,
       eu14 = @eu14,
       eu15 = @eu15,
       eu16 = @eu16,
       eu17 = @eu17,
       eu18 = @eu18,
       eu19 = @eu19,
       eu20 = @eu20,
       eu21 = @eu21,
       eu22 = @eu22,
       eu23 = @eu23,
       eu24 = @eu24,
       eu25 = @eu25,
       eu26 = @eu26,
       eu27 = @eu27,
       eu28 = @eu28,
       eu29 = @eu29,
       eu30 = @eu30,
       eu32 = @eu32,
       eu33 = @eu33,
       eu34 = @eu34,
       eu35 = @eu35,
       eu36 = @eu36,
       eu37 = @eu37



GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetUserExperience
AS
SELECT eu1,
       eu2,
       eu3,
       eu4,
       eu5,
       eu6,
       eu7,
       eu8,
       eu9,
       eu10,
       eu11,
       eu12,
       eu13,
       eu14,
       eu15,
       eu16,
       eu17,
       eu18,
       eu19,
       eu20,
       eu21,
       eu22,
       eu23,
       eu24,
       eu25,
       eu26,
       eu27,
       eu28,
       eu29,
       eu30,
       eu31,
       eu32,
       eu33,
       eu34,
       eu35,
       eu36,
       eu37
FROM SMB_UserExperience


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_GetMemberList
	@SearchChar	VARCHAR(1) = '',
	@FirstRec	INT = 1,
	@LastRec	INT = 25
AS

CREATE TABLE #uIndex
(
 	orderID		INT IDENTITY(1,1) NOT NULL,
	userID		INT
)

IF @SearchChar = ''
  BEGIN
    INSERT INTO #uIndex(userID)
    SELECT UserID
    FROM SMB_Profiles
    WHERE UserName != 'guest'
    ORDER BY UserName
  END
ELSE
  BEGIN
    IF @SearchChar BETWEEN 'A' AND 'Z'  
      BEGIN
        INSERT INTO #uIndex(userID)
        SELECT UserID
        FROM SMB_Profiles
        WHERE LEFT(UserName, 1) LIKE @SearchChar
          AND UserName != 'guest'
        ORDER BY UserName
      END
    ELSE
      BEGIN
        INSERT INTO #uIndex(userID)
        SELECT UserID
        FROM SMB_Profiles
        WHERE LEFT(UserName, 1) NOT BETWEEN 'A' AND 'Z'
          AND UserName != 'guest'
        ORDER BY UserName
      END
  END

SELECT UserID,
       UserName,
       EmailAddress,
       ShowAddress,
       Homepage,
       TotalPosts,
       CreateDate,
       UsePM,
       PMAdminLock
FROM SMB_Profiles
WHERE UserID IN (SELECT UserID 
                 FROM #uIndex
                 WHERE orderID >= @FirstRec 
                   AND orderID <= @LastRec)
Order by UserName

DROP TABLE #uIndex


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

---------------------------------
---------------------------------
--- New stored procedures
---------------------------------

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_GetAdminLogCount
	@UserID		INT = 0,
	@RecCount	INT	OUTPUT
AS
IF @UserID = 0
  BEGIN
    SET @RecCount = (SELECT COUNT(LogID) FROM SMB_AdminActions)
  END
ELSE 
  BEGIN
    SET @RecCount = (SELECT COUNT(LogID) 
                     FROM SMB_AdminActions
                     WHERE UserID = @UserID)
  END

IF @RecCount IS NULL 
  BEGIN
    SET @RecCount = 0
  END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE  PROCEDURE TB_ADMIN_GetAdminLogPage
	@UserID		INT = 0,
	@FirstRec	INT = 1,
	@LastRec	INT = 50
AS
-- create temp table for paging
CREATE TABLE #tIndex
(
	orderID		INT IDENTITY(1,1) NOT NULL,
	logID	INT
)

IF @UserID = 0
  BEGIN
    INSERT INTO #tIndex(logID)
    SELECT LogID
    FROM SMB_AdminActions
    ORDER BY LogDate DESC
  END
ELSE 
  BEGIN
    INSERT INTO #tIndex(logID)
    SELECT LogID
    FROM SMB_AdminActions
    WHERE UserID = @UserID
    ORDER BY LogDate DESC
  END

SELECT a.LogDate, 
       a.UserID,
       a.AdminAction,
       p.Username
FROM SMB_AdminActions a
INNER JOIN SMB_Profiles p
  ON p.UserID = a.UserID
WHERE a.LogID IN (SELECT LogID 
                  FROM #tIndex 
                  WHERE orderID >= @FirstRec 
                    AND orderID <= @LastRec)
ORDER BY a.LogDate DESC


DROP TABLE #tIndex


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_GetAdminLogUsers
AS
SELECT UserName,
       UserID
FROM SMB_Profiles
WHERE UserID IN (SELECT DISTINCT UserID
                 FROM SMB_AdminActions)


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_ADMIN_SetForumState
	@ForumID	INT,
	@ActiveState	BIT
AS
UPDATE SMB_Forums
SET ActiveState = @ActiveState
WHERE ForumID = @ForumID

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

-- modified version of master stored proc 'sp_spaceused'
CREATE procedure TB_ADMIN_SpaceUsed --- 
@objname nvarchar(776) = null,		-- The object we want size on.
@updateusage varchar(5) = false		-- Param. for specifying that
					-- usage info. should be updated.
as

declare @id	int			-- The object id of @objname.
declare @type	character(2) -- The object type.
declare	@pages	int			-- Working variable for size calc.
declare @dbname sysname
declare @dbsize dec(15,0)
declare @logsize dec(15)
declare @bytesperpage	dec(15,0)
declare @pagesperMB		dec(15,0)

/*Create temp tables before any DML to ensure dynamic
**  We need to create a temp table to do the calculation.
**  reserved: sum(reserved) where indid in (0, 1, 255)
**  data: sum(dpages) where indid < 2 + sum(used) where indid = 255 (text)
**  indexp: sum(used) where indid in (0, 1, 255) - data
**  unused: sum(reserved) - sum(used) where indid in (0, 1, 255)
*/
create table #spt_space
(
	rows		int null,
	reserved	dec(15) null,
	data		dec(15) null,
	indexp		dec(15) null,
	unused		dec(15) null
)

/*
**  Check to see if user wants usages updated.
*/

if @updateusage is not null
	begin
		select @updateusage=lower(@updateusage)

		if @updateusage not in ('true','false')
			begin
				raiserror(15143,-1,-1,@updateusage)
				return(1)
			end
	end
/*
**  Check to see that the objname is local.
*/
if @objname IS NOT NULL
begin

	select @dbname = parsename(@objname, 3)

	if @dbname is not null and @dbname <> db_name()
		begin
			raiserror(15250,-1,-1)
			return (1)
		end

	if @dbname is null
		select @dbname = db_name()

	/*
	**  Try to find the object.
	*/
	select @id = null
	select @id = id, @type = xtype
		from sysobjects
			where id = object_id(@objname)

	/*
	**  Does the object exist?
	*/
	if @id is null
		begin
			raiserror(15009,-1,-1,@objname,@dbname)
			return (1)
		end


	if not exists (select * from sysindexes
				where @id = id and indid < 2)

		if      @type in ('P ','D ','R ','TR','C ','RF') --data stored in sysprocedures
				begin
					raiserror(15234,-1,-1)
					return (1)
				end
		else if @type = 'V ' -- View => no physical data storage.
				begin
					raiserror(15235,-1,-1)
					return (1)
				end
		else if @type in ('PK','UQ') -- no physical data storage. --?!?! too many similar messages
				begin
					raiserror(15064,-1,-1)
					return (1)
				end
		else if @type = 'F ' -- FK => no physical data storage.
				begin
					raiserror(15275,-1,-1)
					return (1)
				end
end

/*
**  Update usages if user specified to do so.
*/

if @updateusage = 'true'
	begin
		if @objname is null
			dbcc updateusage(0) with no_infomsgs
		else
			dbcc updateusage(0,@objname) with no_infomsgs
		print ' '
	end


set nocount on

/*
**  If @id is null, then we want summary data.
*/
/*	Space used calculated in the following way
**	@dbsize = Pages used
**	@bytesperpage = d.low (where d = master.dbo.spt_values) is
**	the # of bytes per page when d.type = 'E' and
**	d.number = 1.
**	Size = @dbsize * d.low / (1048576 (OR 1 MB))
*/
if @id is null
begin
	select @dbsize = sum(convert(dec(15),size))
		from dbo.sysfiles
		where (status & 64 = 0)

	select @logsize = sum(convert(dec(15),size))
		from dbo.sysfiles
		where (status & 64 <> 0)

	select @bytesperpage = low
		from master.dbo.spt_values
		where number = 1
			and type = 'E'
	select @pagesperMB = 1048576 / @bytesperpage

--	select  database_name = db_name(),
--		database_size =
--			ltrim(str((@dbsize + @logsize) / @pagesperMB,15,2) + ' MB'),
--		'unallocated space' =
--			ltrim(str((@dbsize -
--				(select sum(convert(dec(15),reserved))
--					from sysindexes
--						where indid in (0, 1, 255)
--				)) / @pagesperMB,15,2)+ ' MB')

--	print ' '
	/*
	**  Now calculate the summary data.
	**  reserved: sum(reserved) where indid in (0, 1, 255)
	*/
	insert into #spt_space (reserved)
		select sum(convert(dec(15),reserved))
			from sysindexes
				where indid in (0, 1, 255)

	/*
	** data: sum(dpages) where indid < 2
	**	+ sum(used) where indid = 255 (text)
	*/
	select @pages = sum(convert(dec(15),dpages))
			from sysindexes
				where indid < 2
	select @pages = @pages + isnull(sum(convert(dec(15),used)), 0)
		from sysindexes
			where indid = 255
	update #spt_space
		set data = @pages


	/* index: sum(used) where indid in (0, 1, 255) - data */
	update #spt_space
		set indexp = (select sum(convert(dec(15),used))
				from sysindexes
					where indid in (0, 1, 255))
			    - data

	/* unused: sum(reserved) - sum(used) where indid in (0, 1, 255) */
	update #spt_space
		set unused = reserved
				- (select sum(convert(dec(15),used))
					from sysindexes
						where indid in (0, 1, 255))

	select  database_name = db_name(),
		database_size =
			ltrim(str((@dbsize + @logsize) / @pagesperMB,15,2) + ' MB'),
		'unallocated space' =
			ltrim(str((@dbsize -
				(select sum(convert(dec(15),reserved))
					from sysindexes
						where indid in (0, 1, 255)
				)) / @pagesperMB,15,2)+ ' MB'),
		reserved = ltrim(str(reserved * d.low / 1024.,15,0) +
--	select reserved = ltrim(str(reserved * d.low / 1024.,15,0) +
				' ' + 'KB'),
		data = ltrim(str(data * d.low / 1024.,15,0) +
				' ' + 'KB'),
		index_size = ltrim(str(indexp * d.low / 1024.,15,0) +
				' ' + 'KB'),
		unused = ltrim(str(unused * d.low / 1024.,15,0) +
				' ' + 'KB')
		from #spt_space, master.dbo.spt_values d
		where d.number = 1
			and d.type = 'E'
end

/*
**  We want a particular object.
*/
else
begin
	/*
	**  Now calculate the summary data.
	**  reserved: sum(reserved) where indid in (0, 1, 255)
	*/
	insert into #spt_space (reserved)
		select sum(reserved)
			from sysindexes
				where indid in (0, 1, 255)
					and id = @id

	/*
	** data: sum(dpages) where indid < 2
	**	+ sum(used) where indid = 255 (text)
	*/
	select @pages = sum(dpages)
			from sysindexes
				where indid < 2
					and id = @id
	select @pages = @pages + isnull(sum(used), 0)
		from sysindexes
			where indid = 255
				and id = @id
	update #spt_space
		set data = @pages


	/* index: sum(used) where indid in (0, 1, 255) - data */
	update #spt_space
		set indexp = (select sum(used)
				from sysindexes
					where indid in (0, 1, 255)
						and id = @id)
			    - data

	/* unused: sum(reserved) - sum(used) where indid in (0, 1, 255) */
	update #spt_space
		set unused = reserved
				- (select sum(used)
					from sysindexes
						where indid in (0, 1, 255)
							and id = @id)
	update #spt_space
		set rows = i.rows
			from sysindexes i
				where i.indid < 2
					and i.id = @id

	select name = object_name(@id),
		rows = convert(char(11), rows),
		reserved = ltrim(str(reserved * d.low / 1024.,15,0) +
				' ' + 'KB'),
		data = ltrim(str(data * d.low / 1024.,15,0) +
				' ' + 'KB'),
		index_size = ltrim(str(indexp * d.low / 1024.,15,0) +
				' ' + 'KB'),
		unused = ltrim(str(unused * d.low / 1024.,15,0) +
				' ' + 'KB')
	from #spt_space, master.dbo.spt_values d
		where d.number = 1
			and d.type = 'E'
end

return (0) -- sp_spaceused


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_CheckPostGUID
	@MessageID	INT,
	@UserGUID	UNIQUEIDENTIFIER,
	@IsUser		BIT	OUTPUT
AS
DECLARE @UGUID 	UNIQUEIDENTIFIER
SET @UGUID = (SELECT UserGUID FROM SMB_Messages WHERE MessageID = @MessageID)
IF @UGUID IS NULL
  BEGIN
    SET @IsUser = 0
  END
ELSE
  BEGIN
    IF @UGUID = @UserGUID 
      BEGIN
        SET @IsUser = 1
      END
    ELSE
      BEGIN
        SET @IsUser = 0
      END
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE PROCEDURE TB_GetForumState
	@ForumID	INT,
	@ActiveState	BIT	OUTPUT
AS
SET @ActiveState = (SELECT ActiveState FROM SMB_Forums WHERE ForumID = @ForumID)
IF @ActiveState IS NULL
  BEGIN
    SET @ActiveState = 1	-- set to true for later validation
  END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO


