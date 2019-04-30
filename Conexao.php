<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento
 * Date: 29/04/2019
 * Time: 15:01
 */

class Conexao
{
    function connect($bd)
    {
        $m = mysqli_connect('192.168.0.27', 'root', 'pipoca453', $bd);
        $m->query ("SET NAMES 'utf8'");
        $m->query ('SET character_set_connection=utf8');
        $m->query ('SET character_set_client=utf8');
        $m->query ('SET character_set_results=utf8');
        return $m;
    }
}