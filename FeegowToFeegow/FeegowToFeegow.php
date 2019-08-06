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
    function __construct($bdOrigem, $bdDestino, $profissionais = false)
    {
        $this->bdOrigem = $bdOrigem;
        $this->bdDestino = $bdDestino;
        $this->base = new FeegowEstrutura($bdOrigem, $profissionais);

    }

    function arraytoInsert($array, $table)
    {
        $columns = [];
        $data = "(";
        $columnsArray = array_keys($array);

        foreach ($columnsArray as $c) {
            array_push($columns, "`" . $c . "`");
        }
        $columns = implode(", ", $columns);
//        var_dump($array);
        foreach ($array as $a) {

            if ($a == null) {
                $data = $data . 'null, ';
            } else {
                $a = str_replace("'", "\'", $a);
                $data = $data . "'" . $a . "', ";
            }
        }
        $data = $data . "@";
        $data = str_replace(", @", ")", $data);
        $this->base->conn->query("insert into {$this->bdDestino}.`{$table}` ({$columns}) values {$data}");
        if ($this->base->conn->error) {
            var_dump($this->base->conn->error);
            var_dump("insert into {$this->bdDestino}.`{$table}` ({$columns}) values {$data}");
        }


    }


    function insertCSV($array, $filename)
    {
        foreach ($array as $a) {
            $header = implode('; ',array_keys($a));

            break;
        }


        $fileHandle = fopen($filename, 'w');
        fwrite($fileHandle, "{$header}\n");

        foreach($array as $a){
            $data = implode("; ", $a);
            $data = utf8_decode($data);

//            $data = str_replace("<p>&nbsp;</p>", "", $data);
//            $data = str_replace("<p>", "", $data);
//            $data = str_replace("\n", "<br>", $data);
            fwrite($fileHandle, "{$data}\n");
        }

        fclose($fileHandle);
    }


    function Pacientes()
    {
        $pacientes = $this->base->get_pacientes();

        foreach ($pacientes as $p) {
            $this->arraytoInsert($p, "Pacientes");

        }

    }

    function Agendamentos()
    {
        $agendamentos = $this->base->get_agendamentos();

        foreach ($agendamentos as $a) {
            $this->arraytoInsert($a, "Agendamentos");
        }
    }

    function PacientesPrescricoes()
    {
        $pacientesPrescricoes = $this->base->get_pacientesPrescricoes();

        foreach ($pacientesPrescricoes as $pp) {
//            var_dump($pp);
            $this->arraytoInsert($pp, "pacientesprescricoes");
        }
    }

    function PacientesAtestados()
    {
        $pacientesAtestados = $this->base->get_pacientesAtestados();

        foreach ($pacientesAtestados as $pa) {
            $this->arraytoInsert($pa, "PacientesAtestados");
        }
    }

    function PacientesPedidos()
    {
        $pacientesAtestados = $this->base->get_pacientesPedidos();

        foreach ($pacientesAtestados as $pa) {
            $this->arraytoInsert($pa, "PacientesPedidos");
        }
    }

    function gerarCsv()
    {
//        $pacientes = $this->base->get_pacientes();
//        $this->insertCSV($pacientes, "pacientes.csv");
//
//        $pacientesPrescricoes = $this->base->get_pacientesPrescricoes();
//        $this->insertCSV($pacientesPrescricoes, "prescricoes.csv");
//
//        $agendamentos = $this->base->get_agendamentos();
//        $this->insertCSV($agendamentos, "agendamentos.csv");
//
//        $pacientesAtestados = $this->base->get_pacientesAtestados();
//        $this->insertCSV($pacientesAtestados, "atestados.csv");

        $pacientesPedidos = $this->base->get_pacientesPedidos();
        $this->insertCSV($pacientesPedidos, "Pedidos.csv");

    }


}

$a = new FeegowToFeegow("2961_20190723", "clinic6568_20190723", '1,5,8,11');

$a->Pacientes();
//$a->PacientesPedidos();
//$a->PacientesPrescricoes();
//$a->PacientesAtestados();
//$a->Agendamentos();
//$a->gerarCSV();