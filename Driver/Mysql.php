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
	public function create(){
		return true;
		$stmt = $this->C->query("show fields from {$tbl}");
		$dados = $stmt->fetchAll();
		$file = fopen($path."{$tbl}.php", "w");
		fwrite($file, "<?php \nClass {$tbl}{\n");
		foreach ($dados as $data){
			fwrite($file, "    /**\n    @property {$data['Type']} {$data['Extra']} {$data['Key']};\n    */\n");
			fwrite($file, "    public \${$data['Field']};\n");
		}
		fwrite($file, "\n}\n?>");
	}
	public function MakeAllVO($path){
		$tbls = $this->listTable();
		foreach ($tbls as $tbl){
			$this->MakeVO($tbl, $path);
		}
	}
