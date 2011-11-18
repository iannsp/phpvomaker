<?php
namespace VoMaker;
use VoMaker\Driver\PgSql;
use VoMaker\Driver\Mysql;

class VoMaker{
    private $cmd = Array();
    private $driver ;
    public function __construct(\PDO $objectData, array $cmd){
            $this->cmd        = $cmd;
            $this->driver = '\\VoMaker\\Driver\\'.$cmd['driver'];
            $this->driver = New $this->driver($objectData);
    }
    public function exec()
    {
        $cmd = $this->cmd['cmd'];
        return $this->$cmd();
    }
    private function listtable(){
        return $this->driver->listtables($this->cmd['tables']);
    }
    private function create(){
        return $this->driver->create($this->cmd['tables'], $this->cmd['output']);
    }
}
