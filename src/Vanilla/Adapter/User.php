<?php

namespace Infonesy\Driver\Vanilla\Adapter;

class User extends ObjectDb
{
	function table_name() { return 'users'; }

	function table_fields()
	{
		return [
			'id',
			'infonesy_uuid',
			'vanilla_user_id',
			'email_md5',
		];
	}
}
