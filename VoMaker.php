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
        return $this->driver->listTable($this->cmd['tables']);
    }
    private function create(){
        $tmpl = New \VoMaker\Template($this->cmd['template']);
        if ($this->cmd['tables'] =='ALLTABLES')
            $theTables = $this->listTable();
        else
            $theTables  = explode(',', $this->cmd['tables']);
        foreach ($theTables as $tablename) {
            $fields     = $this->driver->create($tablename);
            $index = array_shift($fields);
            foreach ($fields as $field) {
                $tmpl->addField($field);
            }
            $tmpl->setIndex(implode(',',$index ));
            $tmpl->create($tablename, $this->cmd['output']);
        }
    }
}
