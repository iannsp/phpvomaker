<?php
namespace VoMaker\Driver;

class Pgsql{
    private  $objectData;
    public function __construct(\PDO $objectData){
        $this->objectData = $objectData;
    }
    public function listTable(){
        $stmt = $this->objectData->query("select * from information_schema.tables where table_schema='public'
        and table_type='BASE TABLE' and table_catalog=current_database();");
        $dados = $stmt->fetchAll();
        $retorno = Array();
        foreach ($dados as $idx =>$d){
            array_push( $retorno, $d[1].".".$d[2]);
        }
        return $retorno;
    }
    public function create($tablename){
        $stmt = $this->objectData->query(" SELECT column_name,udt_name,character_maximum_length,is_nullable
        FROM information_schema.columns WHERE concat(table_schema,'.',table_name)='{$tablename}'order by ordinal_position;");
        $fields = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $infoFields = Array();
        $infoFields[0] = Array();
        foreach ($fields as $f){
            $infoFields[ $f['column_name'] ] =new \StdClass();
            $field = $infoFields[ $f['column_name'] ];
            $field->name        = $f['column_name'];
            $field->type        = $f['udt_name'];
            $field->acceptnull  = ($f['is_nullable']=="YES")?"1":"0";
            $field->pk  = false;//todo Implement a way to test if its a primary key;
            if($field->pk)
                array_push($infoFields[0], $field->name);
        }
        return $infoFields;
    }
}
