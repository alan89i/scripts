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
                    $c= json_decode(json_encode($c), true);
                    $columns  = array_keys($c);
//                    var_dump($columns);
                    break;
                }

//                var_dump($columns);
//                var_dump($table);

                $this->createTable($table, $columns);

                foreach ($data as $d){
                    var_dump($d);
                    $this->insertTable($table, $d);

                }

            }
        }
    }

    function insertTable($table, $data){
        $data= json_decode(json_encode($data), true);
        $columns = implode(', ',array_keys($data));
//        $data = implode('", "', $data);
//        $data = '"'.$data.'"';
        $columns = str_replace('-', '_', $columns);
        $d = '(';
//        var_dump($data);
        foreach ($data as $a) {
//            var_dump($a['HTML']);
            if ($a == null) {
                $d = $d . 'null, ';
            } else {
                $a = str_replace("'", "\'", $a);
                $d = $d . "'" . $a . "', ";

            }
        }
        $d = $d . "@";
        $d = str_replace(", @", ")", $d);
//        var_dump($d);
//        exit();
        $sql = "insert into `{$table}` ({$columns}) values {$d}";
        $this->conn->query($sql);
        if($this->conn->error!=''){
            var_dump($sql);
            var_dump($this->conn->error);
            exit();
        }

    }

    function createTable($table, $columns)
    {
//        $file = end(explode('\\',$table));
//        $file = current(explode('.',$file));
//        $t = simplexml_load_file($table);
//        $colunas = array_keys($t);
        $columns = implode(' text, ',$columns);
        $columns = $columns.' text';
        $columns = str_replace('-', '_', $columns);


        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` ({$columns})";
        $this->conn->query($sql);
        if($this->conn->error!=''){
            var_dump($this->conn->error);
            var_dump($sql);
        }

    }
}

$a = new ConvertXML('C:\Users\Desenvolvimento\Desktop\banco de dados\Andre Castro\upload\1252\export\new', 'teste');
$a->readXML();