<?php

namespace Infonesy\Driver\Vanilla;

class User extends \B2\Obj
{
	static function find_or_create($data)
	{
		$infonesy_user = Adapter\User::find(['email_md5' => $data['EmailMD5']])->first();

		// If user found in adapter database
		if($infonesy_user->is_not_null())
			return self::loader($infonesy_user, NULL, $data);

		foreach(B2Model\User::find()->all() as $vanilla_user)
		{
			$email_md5 = md5($vanilla_user->email());
			$infonesy_user = Adapter\User::find(['email_md5' => $email_md5])->first();
			if($infonesy_user->is_null())
			{
				// Make adapter record
				$infonesy_user = Adapter\User::create([
					'vanilla_user_id' => $vanilla_user->id(),
					'email_md5' => $email_md5,
				]);
			}

			// If user found in adapter database by hash
			if($infonesy_user->email_md5() == $data['EmailMD5'])
				return self::loader($infonesy_user, $vanilla_user, $data);
		}

		$idx = 0;

		while(true)
		{
			if($idx++)
				$test_name = $data['Title'].'_'.$idx;
			else
				$test_name = $data['Title'];

			$duplicate_user_check = B2Model\User::find(['title' => $test_name])->first();
			if($duplicate_user_check->is_null())
			{
				$data['Title'] = $test_name;
				break;
			}
		}

		// Make vanilla user
		$vanilla_user = B2Model\User::create([
			'title'			=> $data['Title'],
			'email'			=> $data['EmailMD5'],
			'password'		=> md5(rand()),
			'is_confirmed'	=> true,

//			'HashMethod',
//			'Photo',
//			'Title',
//			'Location',
//			'About' => ['type' => 'bbcode'],
//			'ShowEmail',
//			'Gender',
//			'CountVisits',
//			'CountInvitations',
//			'CountNotifications',
//			'InviteUserID',
//			'DiscoveryText',
//			'Preferences',
//			'Permissions',
//			'Attributes',
//			'DateSetInvitations',
//			'DateOfBirth',
//			'DateFirstVisit',
//			'DateLastActive',
//			'LastIPAddress',
//			'AllIPAddresses',
//			'DateInserted',
//			'InsertIPAddress',
//			'DateUpdated',
//			'UpdateIPAddress',
//			'HourOffset',
//			'Score',
//			'Admin',
//			'Confirmed',
//			'Verified',
//			'Banned',
//			'Deleted',
//			'Points',
//			'CountUnreadConversations',
//			'CountDiscussions',
//			'CountUnreadDiscussions',
//			'CountComments',
//			'CountDrafts',
//			'CountBookmarks',
		]);

		// Make adapter link
		$infonesy_user = Adapter\User::create([
			'vanilla_user_id' => $vanilla_user->id(),
			'email_md5' => $data['EmailMD5'],
		]);

		return self::loader($infonesy_user, $vanilla_user, $data);
	}

	static function loader($infonesy_user, $vanilla_user, $data)
	{
		if(!$vanilla_user)
			$vanilla_user = B2Model\User::load($infonesy_user->vanilla_user_id());

		if(!empty($data['RegisterDate']))
			$vanilla_user->set_create_time(strtotime($data['RegisterDate']));

		if(!$vanilla_user->get('last_visit_time') && !empty($data['LastVisit']))
			$vanilla_user->set_last_visit_time(strtotime($data['LastVisit']));

		if(!$vanilla_user->email())
			$vanilla_user->set_email(strtotime($data['EmailMD5']));

		if(!$infonesy_user->get('infonesy_uuid'))
			$infonesy_user->set_infonesy_uuid($data['UUID']);

		return $vanilla_user;
	}
}
