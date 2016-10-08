<?php

namespace Infonesy\Driver\Vanilla\B2Model;

class User extends ObjectDb
{
	function table_name() { return 'GDN_User'; }

	function table_fields()
	{
		return [
			'id' => 'UserID',
			'title' => 'Name',
			'password' => 'Password',
			'HashMethod',
			'Photo',
			'Title',
			'Location',
			'About',
			'email' => 'Email',
			'ShowEmail',
			'Gender',
			'CountVisits',
			'CountInvitations',
			'CountNotifications',
			'InviteUserID',
			'DiscoveryText',
			'Preferences',
			'Permissions',
			'Attributes',
			'DateSetInvitations',
			'DateOfBirth',
			'DateFirstVisit',
			'DateLastActive',
			'LastIPAddress',
			'AllIPAddresses',
			'create_time' => 'UNIX_TIMESTAMP(`DateInserted`)',
			'InsertIPAddress',
			'DateUpdated',
			'UpdateIPAddress',
			'HourOffset',
			'Score',
			'Admin',
			'is_confirmed' => 'Confirmed',
			'Verified',
			'Banned',
			'Deleted',
			'Points',
			'CountUnreadConversations',
			'CountDiscussions',
			'CountUnreadDiscussions',
			'CountComments',
			'CountDrafts',
			'CountBookmarks',
		];
	}
}
