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
    public function create($tablenames, $path){
        if ($tablenames =='ALLTABLES')
            $theTables = $this->listTable();
        else
            $theTables = explode(',', $tablenames);
        foreach ($theTables as $table) {
        $stmt = $this->objectData->query("show fields from {$table}");
        $dados = $stmt->fetchAll();
        $file = fopen($path."{$table}.php", "w");
        fwrite($file, "<?php \nClass {$table}{\n");
        foreach ($dados as $data){
            fwrite($file, "    /**\n    @fieldname ;\n    */\n");
            fwrite($file, "    public \${$data['Field']};\n");
        }
        fwrite($file, "\n}\n?>");
        }
    }
    public function MakeAllVO($path){
        $tbls = $this->listTable();
        foreach ($tbls as $tbl){
            $this->MakeVO($tbl, $path);
        }
    }
}
