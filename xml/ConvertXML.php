<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 08/05/2019
 * Time: 11:55
 */
require "../Conexao.php";
require "../Diversos/getFile.php";

class ConvertXML extends Conexao
{
    function __construct($path, $bd)
    {
        $this->path = $path;
        $this->getFile = new getFile();
        $this->conn = $this->connect($bd);
    }

    function readXML()
    {
        $file = $this->getFile->getDirContents($this->path);
        foreach ($file as $f) {
            if (is_file($f)) {
                $table = end(explode('\\',$f));
                $table = current(explode('.',$table));

                $data = simplexml_load_file($f);
                $columns = [];
                foreach ($data as $c){
                    $columns [] = array_keys((array)$c);
                    break;
                }

//                var_dump($columns);
//                var_dump($table);


            }
        }
    }

    function createTable($table, $columns)
    {
//        $file = end(explode('\\',$table));
//        $file = current(explode('.',$file));
//        $t = simplexml_load_file($table);
//        $colunas = array_keys($t);
        var_dump($table);
        var_dump($columns);
        exit();


//        $sql = "CREATE TABLE IF NOT EXISTS `{$file}` ";
//        $this->conn->query();
    }
}

$a = new ConvertXML('C:\Users\Desenvolvimento\Desktop\banco de dados\Andre Castro\upload\1252\export', 'andrecastro');
$a->readXML();