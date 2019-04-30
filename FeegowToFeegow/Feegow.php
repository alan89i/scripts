<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 29/04/2019
 * Time: 14:43
 */
require "../Conexao.php";

class Feegow extends Conexao
{
    function __construct($origem, $destino, $profissionais = false)
    {
        $this->origem = $this->connect($origem);
        $this->destino = $this->connect($destino);
        $this->profissionais = $profissionais;
    }

    function arraytoInsert($array)
    {
        $columns = [];
        $data = "(";
        $columnsArray = array_keys($array);

        foreach ($columnsArray as $c){
            array_push($columns, "`".$c."`");
        }
        $columns = implode(", ", $columns);
        var_dump($array);
        foreach ($array as $a){

            if($a==null){
                $data = $data.'null, ';
            }else{
                $data = $data."'".$a."', ";
            }
        }
        $data = $data."@";
        $data = str_replace(", @", ")", $data);
        var_dump($columns);

    }

    function Pacientes()
    {
        $sql = "select * from pacientes p where p.id = 2";
        if ($this->profissionais) {
            $sql = "select p.* from pacientes p inner join agendamentos a on a.pacienteid = p.id where a.profissionalid in ({$this->profissionais})  group by p.id";
        }
        $res = $this->origem->query($sql);
        foreach ($res as $r) {
            $this->arraytoInsert($r);
        }

    }
}