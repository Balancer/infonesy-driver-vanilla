<?php

namespace Infonesy\Driver\Vanilla\Adapter;

class Post extends ObjectDb
{
	function table_name() { return 'posts'; }

	function table_fields()
	{
		return [
			'id',
			'infonesy_uuid',
			'vanilla_post_id',
		];
	}
}
