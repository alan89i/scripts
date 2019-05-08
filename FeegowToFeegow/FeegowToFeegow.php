<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 29/04/2019
 * Time: 14:43
 */
ini_set('memory_limit', '-1');

require "../Feegow/FeegowEstrutura.php";
class FeegowToFeegow
{
    function __construct($bdOrigem,$bdDestino, $profissionais = false)
    {
        $this->bdOrigem = $bdOrigem;
        $this->bdDestino = $bdDestino;
        $this->base = new FeegowEstrutura($bdOrigem, $profissionais);

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
        $this->base->connect($this->);

    }

    function Pacientes()
    {
        $pacientes = $this->base->get_pacientes();

        foreach ($pacientes as $p) {
            $this->arraytoInsert($p);
        }

    }
}
$a = new FeegowToFeegow("clinicagape");

$a->Pacientes();

