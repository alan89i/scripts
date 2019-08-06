<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 02/05/2019
 * Time: 11:07
 */

require "../Conexao.php";


class FeegowEstrutura extends Conexao
{
    function __construct($bd, $profissionalid = false)
    {
        $this->conn = $this->connect($bd);
        $this->profissionalid = $profissionalid;
    }

    function get_pacientes()
    {
        $sql = "select * from pacientes";
        if ($this->profissionalid) {
            $sql = "select distinct * from (select p.* from pacientes p inner join agendamentos a on p.id = a.PacienteID where a.profissionalid in ({$this->profissionalid})  union
select p.* from pacientes p inner join buiformspreenchidos b on p.id = b.PacienteID inner join sys_users u on u.id = b.sysUser where u.idInTable in ({$this->profissionalid})) as z";
        }
        return $this->get_all($sql);
    }

    function get_all($sql)
    {

        $res = $this->conn->query($sql);

        $data = [];
        foreach ($res as $r) {
//            var_dump($r);
            $data [] = $r;
        }
        return $data;
    }

    function get_agendamentos()
    {
        $sql = "select * from agendamentos";
        if ($this->profissionalid) {
            $sql = "select * from agendamentos where profissionalid in ({$this->profissionalid})";
        }
        return $this->get_all($sql);
    }

    function get_pacientesPrescricoes()
    {
        $sql = "select * from pacientesprescricoes";
        if ($this->profissionalid) {
            $sql = "select p.* from pacientesprescricoes p inner join sys_users u on p.sysuser = u.id where u.idintable in ({$this->profissionalid})";
        }
        return $this->get_all($sql);
    }

    function get_pacientesAtestados()
    {
        $sql = "select * from pacientesatestados";
        if ($this->profissionalid) {
            $sql = "select p.* from pacientesatestados p inner join sys_users u on p.sysuser = u.id where u.idintable in ({$this->profissionalid})";
        }
        return $this->get_all($sql);
    }

    function get_pacientesPedidos()
    {
        $sql = "select * from pacientespedidos";
        if ($this->profissionalid) {
            $sql = "select p.* from pacientespedidos p inner join sys_users u on p.sysuser = u.id where u.idintable in ({$this->profissionalid})";
        }
        return $this->get_all($sql);
    }

    function get_forms()
    {
        $sql = "select * from buiforms";
        if ($this->profissionalid) {
            $sql = "select b.modeloid id from buiformspreenhidos b inner join sys_users u on u.id = b.sysuser where u.idintable in ({$this->profissionalid})";
        }
        $res = $this->conn->query($sql);
        $coluans = [];
        foreach ($res as $r) {
            $coluna [] = $this->get_structureForm($r['id']);
            $data = $this->get_dataForm($r);
//            var_dump($coluna);

        }

    }

    function get_dataForm($formID)
    {
        $sql = "select * from _{$formID}";
        $data = [];
        $res = $this->conn->query($sql);
        foreach ($res as $r) {
            $data [] = $res;
        }
        return $data;
    }

    function get_structureForm($formID)
    {
        $sql = "select * from buicamposforms where formid = {$formID}";
        $res = $this->conn->query($sql);
        $colunas = [];
        foreach ($res as $r) {
            $colunas [] = $r['RotuloCampo'];
        }

        return $colunas;

    }

    function setPacientes(){

}


}
