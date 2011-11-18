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
    public function create($voname, $outuput)
    {
        $output = (is_null($output)?"./":$outuput);
        $template = $this->template;
        $template = str_replace('[fields]',implode("\n",$this->txtfield), $template);
        $template = str_replace('[voname]',ucfirst($voname), $template);
        $template = str_replace('[tablename]',$voname, $template);
        $template = str_replace('[index]',$this->indexName, $template);
        $file = fopen($outuput."/".ucfirst($voname).".php", "w");
        fwrite($file, $template);
        fclose($file);
    }
    public function setIndex($indexname) {
        $this->indexName = $indexname;
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