<?php

// app to crate vos and make it sincronuyzed with tables
include 'VoMaker.php';

function processrequest($dt){
$data = array();
	foreach($dt as $idx=>$datum){
		if ($idx ==0)continue;
		list($i, $d) = explode('=', $datum);
		$data[ $i ] = $d;
	}
	return $data;
}
$finaldata = $argv;
function helpfunction(){
	return
"To use the vomaker you need inform some parameters in command line, like above
dsn: at this time you just can use mysql dsn's
login: you database login
password:you databaase password
action:you can request for
	'listtbl' 	:  list all tables in you database for support your choice to generate vo.
	'*'			: it inform for vomaker you want create VO's for all tables
	'tblname' 	: you just request a vo for one table or more (comma separated)
outputfolder: where your vo class files will be save.
 - to help just call with 'help' parameter.\n";

}
if ($finaldata[1]=='help'){
	echo helpfunction();
	exit(1);
}
$outputdir = (isset($finaldata[5]))?$finaldata[5]:'./';
try{
	$voMaker = new VoMaker($finaldata[1], $finaldata[2], $finaldata[3]);
}catch(Exception $E){
	echo $E->getMessage(). helpfunction();
}
switch($finaldata[4]){
	case 'listtbl':
		$tbls =  $voMaker->listTable();
		foreach($tbls as $tbl)
			echo $tbl."";
		break;
	case '*':
		echo "Creating all VO's\n";
		$voMaker->MakeAllVO($outputdir);
		break;
	default:
		$tables = explode(",",$finaldata[4]);
		foreach ($tables as $tbl){
			echo "Creating a VO to table {$tbl}\n";
			$voMaker->MakeVO($tbl, $outputdir);
		}
		break;
}
