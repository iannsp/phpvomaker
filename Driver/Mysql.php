<?php
namespace VoMaker\Driver;

class Mysql{
    private  $objectData;
    public function __construct(\PDO $objectData){
        $this->objectData = $objectData;
    }
    public function listTable(){
        $stmt = $this->objectData->query("show tables");
        $dados = $stmt->fetchAll();
        $retorno = Array();
        foreach ($dados as $idx =>$d){
            array_push( $retorno, $d[0]);
        }
        return $retorno;
    }
    public function create($tablename){
        $stmt = $this->objectData->query("show fields from {$tablename}");
        $fields = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $infoFields = Array();
        $infoFields[0] = Array();
        foreach ($fields as $f){
            $infoFields[ $f['Field'] ] =new \StdClass();
            $field = $infoFields[ $f['Field'] ];
            $field->name        = $f['Field'];
            $field->type        = $f['Type'];
            $field->acceptnull  = ($f['Null']=="YES")?"1":"0";
            $field->pk  = ($f['Key']=='PRI')?true:false;
            if($field->pk)
                array_push($infoFields[0], $field->name);
        }
        return $infoFields;
    }
}
