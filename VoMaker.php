<?php

class VoMaker{
	private  $C;
	public function __construct($dsn, $user, $password){
		try{
			$this->C = new PDO($dsn,$user, $password);
		}catch(Exception $E){
			throw new Exception("Cannot connet to {$dsn}");
		}
	}
	public function listTable(){
		
		$stmt = $this->C->query("show tables");
		$dados = $stmt->fetchAll();
		$retorno = Array();
		foreach ($dados as $idx =>$d){
			array_push( $retorno, $d[0]);
		}
		return $retorno;
	}
	public function MakeVO($tbl, $path){
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
}

?>