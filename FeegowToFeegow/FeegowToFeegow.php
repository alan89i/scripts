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
                $data = $data . "'" . $a . "', ";
            }
        }
        $data = $data . "@";
        $data = str_replace(", @", ")", $data);
        $this->base->conn->query("insert into {$this->bdDestino}.`{$table}` ({$columns}) values {$data}");
        if ($this->base->conn->error) {
            var_dump($this->base->conn->error);
        }


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

}

$a = new FeegowToFeegow("clinic5879", "clinic6552", '3');

//$a->Pacientes();
$a->PacientesPedidos();


