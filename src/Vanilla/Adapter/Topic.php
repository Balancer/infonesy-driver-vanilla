<?php

namespace Infonesy\Driver\Vanilla\Adapter;

class Topic extends ObjectDb
{
	function table_name() { return 'topics'; }

	function table_fields()
	{
		return [
			'id',
			'infonesy_uuid',
			'vanilla_topic_id',
		];
	}
}
