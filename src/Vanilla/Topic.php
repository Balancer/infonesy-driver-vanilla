<?php

namespace Infonesy\Driver\Vanilla;

class Topic extends \B2\Obj
{
	static function find_or_create($data)
	{
		$adapter_topic = Adapter\Topic::find(['infonesy_uuid' => $data['UUID']])->first();

		// If topic found in adapter database
		if($adapter_topic->is_not_null())
			return self::loader($adapter_topic, NULL, $data);

		if(!empty($data['Author']))
		{
			$author = User::find_or_create($data['Author']);
			$author_id = $author->id();
		}
		else
			$author_id = 0;

		// Make vanilla topic
		$vanilla_topic = B2Model\Topic::create([
			'title' => empty($data['Title']) ? 'Карантин' : $data['Title'],
			'create_time' => empty($data['Date']) ? NULL : strtotime($data['Date']),
			'author_id' => $author_id,

			'text' => ' ',

			'forum_id' => 4,

/*
			'Type',
			'ForeignID',
			'InsertUserID',
			'UpdateUserID',
			'FirstCommentID',
			'LastCommentID',
			'Name',
			'Format',
			'Tags',
			'CountComments',
			'CountBookmarks',
			'CountViews',
			'Closed',
			'Announce',
			'Sink',
			'DateInserted',
			'DateUpdated',
			'InsertIPAddress',
			'UpdateIPAddress',
			'DateLastComment',
			'LastCommentUserID',
			'Score',
			'Attributes' => ['type' => 'bbcode'],
			'RegardingID',
*/
		]);

		// Make adapter link
		$adapter_topic = Adapter\Topic::create([
			'vanilla_topic_id' => $vanilla_topic->id(),
			'infonesy_uuid' => $data['UUID'],
		]);

		return self::loader($adapter_topic, $vanilla_topic, $data);
	}

	static function loader($adapter_topic, $b2_topic, $data)
	{
		if(!$b2_topic)
			$b2_topic = B2Model\Topic::load($adapter_topic->vanilla_topic_id());

		if($b2_topic->title() == 'Карантин' && !empty($data['Title']))
		{
			echo "{$b2_topic->id()}: Карантин -> {$data['Title']}\n";
			$b2_topic->set_title($data['Title']);
		}

		$b2_topic->save();

		return $b2_topic;
	}
}
