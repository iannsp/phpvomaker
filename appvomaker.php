#!/usr/bin/php
<?php
include 'VoMaker.php';
include 'bootstrap.php';
function processrequest($dt){
    $dt = array_slice($dt, 1);
    $data = Array();
    $data['cmd'] = array_shift($dt);
    if (count($dt) % 2 !=0) {
        _exit("Wrong parameters format. please verify.\n");
    }
    for ($i = 0; $i < count($dt); $i+=2){
        $data[ str_replace('-','',$dt[$i])] = $dt[$i+1];
    }
    $data['driver'] = explode(':',$data['dsn']);
    if (count($data['driver'])!=2){
        _exit("Wrong DSN. please verify\n");
    } else {
        $data['driver'] = ucfirst($data['driver'][0]);
    }
    return $data;
}
function _exit($msg)
{
    echo "{$msg}\n";
    exit();
}
if ( $argc==1 || $argv[1]=='help'){
    $help = New \VoMaker\Help();
    if($argc ==3 ){
        if (!in_array($argv[2], Array('listtable','create'))) {
            _exit("Wrong parameter to Help.\n\tlistable\n\tcreate\n");
        }
        $_hmethod = $argv[2];
        echo $help->$_hmethod();
    } else{
        echo $help->help();
    }
    exit(1);
}
if (!in_array($argv[1], array('listtable','create', 'help') )){
    $help = New \VoMaker\Help();
    echo $help->help();
    _exit("\n");
}
$cmd = processrequest($argv);
try{
    $pdo = New \PDO($cmd['dsn'], $cmd['user'],$cmd['password']);
    $voMaker = new \VoMaker\VoMaker($pdo, $cmd);
}catch(Exception $E){
    echo "Error in DSN:".$E->getMessage();
}
switch($cmd['cmd']){
    case 'listtable':
        $tbls =  $voMaker->exec();
        $tables = array_chunk($tbls,3);
        foreach ($tables as $table){
			foreach ($table as $t)
                echo sprintf("%-40s",$t );
            echo "\n";
        }
        break;
    case 'create':
            if (!isset($cmd['tables'])){
                exit("Wrong parameters. Need the --tables [tables]\n");
            }else if (!isset($cmd['output'])){
                exit("Wrong parameters. Need the --output [directoryoutput]\n");
            }
           echo "Creating the Table(s): {$cmd['tables']}\n";
          $voMaker->exec($cmd['tables'], $cmd['output']);
        break;
}
