<?php

namespace Infonesy\Driver\Vanilla\B2Model;

class Post extends ObjectDb
{
	function table_name() { return 'GDN_Comment'; }

	function table_fields()
	{
		return [
			'id' => 'CommentID',
			'topic_id' => 'DiscussionID',
			'author_id' => 'InsertUserID',
			'last_editor_id' => 'UpdateUserID',
			'DeleteUserID',
			'text' => 'Body',
			'format_type' => 'Format',
			'create_time' => 'UNIX_TIMESTAMP(`DateInserted`)',
			'DateDeleted',
			'modify_time' => 'UNIX_TIMESTAMP(`DateUpdated`)',
			'InsertIPAddress',
			'UpdateIPAddress',
			'Flag',
			'Score',
			'Attributes',
		];
	}
}
