<?php

namespace Infonesy\Driver\Vanilla;

class Post extends \B2\Obj
{
	static function find_or_create($data)
	{
		$infonesy_post = Adapter\Post::find(['infonesy_uuid' => $data['UUID']])->first();

		// If post found in adapter database
		if($infonesy_post->is_not_null())
			return self::loader($infonesy_post, NULL, $data);

		$author = User::find_or_create($data['Author']);
		$topic = Topic::find_or_create(['UUID' => $data['TopicUUID']]);

		$data['vanilla_b2_topic'] = $topic;

		echo "tid={$topic->id()}, uid={$author->id()}, date={$data['Date']}\n";

		// Make vanilla post
		$vanilla_post = B2Model\Post::create([
			'topic_id'		=> $topic->id(),
			'author_id'		=> $author->id(),
			'text'			=> $data['Text'],
			'create_time'	=> strtotime($data['Date']),
		]);

		// Make adapter link
		$infonesy_post = Adapter\Post::create([
			'vanilla_post_id' => $vanilla_post->id(),
			'infonesy_uuid' => $data['UUID'],
		]);

		return self::loader($infonesy_post, $vanilla_post, $data);
	}

	static function loader($infonesy_post, $b2_post, $data)
	{
		if(!$b2_post)
			$b2_post = B2Model\Post::load($infonesy_post->vanilla_post_id());

		if(empty($data['vanilla_b2_topic']))
			$topic = Topic::find_or_create(['UUID' => $data['TopicUUID']]);
		else
			$topic = $data['vanilla_b2_topic'];

		if((!$b2_post->topic_id() || $b2_post->topic_id() == config('vanilla.quarantine.topic_id')) && !empty($data['TopicUUID']))
			$b2_post->set_topic_id($topic->id());

		if(!empty($data['Date']))
		{
			$ts = strtotime($data['Date']);
//			$time = \Carbon\Carbon::createFromTimestampUTC($ts)->toDateTimeString();
//			echo "; ts=".date("r", $ts)."; dt=".(new \DateTime($time))."; ";
//			$b2_post->set_create_datetime(new \DateTime($time));
//			$b2_post->set_create_time($ts);
			// Forced UTC time for Vanilla ugliness o_O
			$b2_post->set_create_datetime(gmdate('Y-m-d H:i:s', $ts));
		}

		$b2_post->save();

//		$topic->recalculate();

		return $b2_post;
	}
}
