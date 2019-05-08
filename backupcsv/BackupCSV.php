<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 02/05/2019
 * Time: 11:30
 */
require "../Feegow/FeegowEstrutura.php";

class BackupCSV
{
    function __construct($bd, $profissionalid = false)
    {
        $this->feegow = new FeegowEstrutura($bd, $profissionalid);
    }

    function save($filename, $res)
    {
        $fccd = fopen($filename, 'w+');
        foreach ($res as $fields) {
            $key = array_keys($fields);
            fputcsv($fccd, $key, ',');
            break;
        }
        foreach ($res as $key => $fields) {
            fputcsv($fccd, $fields, ',');
        }
        fclose($fccd);
    }

    function savePacienteCSV()
    {
        $res = $this->feegow->get_pacientes();
        $filename = "Pacientes.csv";
        $this->save($filename, $res);
    }

    function saveAgendamentosCSV()
    {
        $res = $this->feegow->get_agendamentos();
        $filename = "Agendamentos.csv";
        $this->save($filename, $res);
    }

    function savePacientesPrescricoes()
    {
        $res = $this->feegow->get_pacientesPrescricoes();
        $filename = "Prescrições.csv";
        $this->save($filename, $res);
    }

    function savePacientesAtestados()
    {
        $res = $this->feegow->get_pacientesAtestados();
        $filename = "Atestados.csv";
        $this->save($filename, $res);
    }

    function savePacientesPedidos()
    {
        $res = $this->feegow->get_pacientesPedidos();
        $filename = "Pedidos.csv";
        $this->save($filename, $res);
    }

    function saveForm()
    {
        $res = $this->feegow->get_forms();
    }


}

$a = new BackupCSV("clinic5837");
//$t = $a->savePacientesPrescricoes();
$a->saveForm();