<?php

namespace Infonesy\Driver\Vanilla\Adapter;

class ObjectDb extends \bors_object_db
{
	function storage_engine() { return \bors_storage_sqlite::class; }
	function db_name() { return \B2\Cfg::get('vanilla_adapter_db', COMPOSER_ROOT.'/data/infonesy-driver-vanilla.sqlite'); }
}
