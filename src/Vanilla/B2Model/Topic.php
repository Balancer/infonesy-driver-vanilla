<?php

namespace Infonesy\Driver\Vanilla\B2Model;

class Topic extends ObjectDb
{
	function table_name() { return 'GDN_Discussion'; }

	function table_fields()
	{
		return [
			'id' => 'DiscussionID',
			'Type',
			'ForeignID',
			'forum_id' => 'CategoryID',
			'author_id' => 'InsertUserID',
			'UpdateUserID',
			'FirstCommentID',
			'LastCommentID',
			'title' => 'Name',
			'text' => 'Body',
			'Format',
			'Tags',
			'CountComments',
			'CountBookmarks',
			'CountViews',
			'Closed',
			'Announce',
			'Sink',
			'create_time' => 'UNIX_TIMESTAMP(`DateInserted`)',
			'DateUpdated',
			'InsertIPAddress',
			'UpdateIPAddress',
			'DateLastComment',
			'LastCommentUserID',
			'Score',
			'Attributes',
			'RegardingID',
		];
	}
}
