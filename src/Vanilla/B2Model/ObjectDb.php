<?php

namespace Infonesy\Driver\Vanilla\B2Model;

class ObjectDb extends \bors_object_db
{
	function storage_engine() { return \bors_storage_mysql::class; }
	function db_name() { return config('vanilla_db'); }
}
