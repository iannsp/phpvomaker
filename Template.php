<?php
namespace Vomaker;

class Template{
    private $template;
    private $txtfield= array();
    private $indexName;
    public function __construct($templatename)
    {
        if (is_null($templatename)?"vo":$templatename);
        $this->template = file_get_contents(__DIR__."/template/{$templatename}");
    }
    public function create($voname, $output)
    {
        $output = (is_null($output)?"./":$output);
        $template = $this->template;
        $fname	  = str_replace('[tablename]',ucfirst($voname), $this->getFileNameTemplate());
        $template = str_replace('[fields]',implode("\n",$this->txtfield), $template);
        $template = str_replace('[voname]',ucfirst($voname), $template);
        $template = str_replace('[tablename]',$voname, $template);
        $template = str_replace('[index]',$this->indexName, $template);
        $file = fopen($output."/"."{$fname}.php", "w");
        fwrite($file, $template);
        fclose($file);
        $this->txtfield = Array();
    }
    public function setIndex($indexname) {
        $this->indexName = $indexname;
    }
    private function getFileNameTemplate(){
        $template = $this->template;
    	$filename = preg_match("/\/\*\*filename:{1,}.*\*\*\//", $template, $matches);
        if(count($matches)){
        	$matches = str_replace('*','',$matches[0]);
			$matches = str_replace("/","",$matches);
			$matches = explode(":", $matches);
			if (count($matches)==2){
				return $matches[1];
			}
			return "[tablename]";
        }
    }
    public function addField(\StdClass $field)
    {
        array_push($this->txtfield,
        "\t/**
\t* @name {$field->name}
\t* @type {$field->type}
\t* @acceptnull {$field->acceptnull}
\t* @primarykey ".(($field->pk)?"1":"0")."\n\t**/
\tpublic \${$field->name};\n");

    }
}