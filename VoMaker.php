<?php
namespace VoMaker;
use VoMaker\Driver\PgSql;
use VoMaker\Driver\Mysql;

class VoMaker{
	private $cmd = Array();
	private $driver ;
	public function __construct(\PDO $objectData, array $cmd){
			$this->cmd		= $cmd;
			$this->driver = New $cmd['driver']($objectData);
	}
	public function exec()
	{
		$cmd = $this->cmd['cmd'];
		return $this->driver->$cmd($this->cmd);
	}
}
