<?php
ini_set('mysql.connect_timeout', 300);
$clincia = "5968";
$dbh = ibase_connect("C:\\temp\\institutoultra\\2019-06-10\\bruno ultrassonografia - UB_CENTRO.fdb", "sysdba", "masterkey", "utf8");
$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "ultrassonografiabotafogoeireli");

//$result = ibase_query("select first 10 documento ha, EXTENSAOARQUIVO ex from cl_pacientedocs where documento is not null and EXTENSAOARQUIVO is not null");
//$result = ibase_query("select handle, paciente, data dt, historia ha from cl_pacientehistoria order by handle"); skinlaser
//$result = ibase_query($dbh,"select  a.laudo, a.matricula, a.titulo, a.digitado_em, a.codigo_laudo, a.codigo_exame, b.nome_cliente, a.digitado_por, b.codigo_paciente  from L_ADMISSAO_LAUDO a inner join l_admissao b on a.matricula = b.matricula  ");
$result = ibase_query($dbh,"select  a.codigo_laudo, a.nome_laudo, texto_laudo from l_laudo a");

$count = 0;
while ($res = ibase_fetch_object($result)) {

    $table = array_keys(json_decode(json_encode($res), true));
//    var_dump($table);

    $count += 10;

    $txt='';
//    var_dump(gettype($res->LAUDO));
    if($res->LAUDO !='') {
        $blob_data = ibase_blob_info($res->TEXTO_LAUDO);
        $blob_hndl = ibase_blob_open($res->TEXTO_LAUDO);

//echo         ibase_blob_get($blob_hndl, $blob_data[0]);

        $txt = ibase_blob_get($blob_hndl, $blob_data[0]);
    }

    $txt = utf8_encode(utf8_decode($txt));
    $txt = str_replace("\\", "\\\\", $txt);
    $txt = str_replace("'", "\'", $txt);
//    $res->NOME_CLIENTE = str_replace("'", "\'", $res->NOME_CLIENTE);


//    $txt = str_replace("'", '@', $txt);


    $sql = "insert into ultrassonografiabotafogoeireli.l_laudocorreto (codigo_laudo, nome_laudo, texto_laudo) values('{$res->CODIGO_LAUDO}', '{$res->NOME_LAUDO}', '{$laudo}')";
    mysqli_query($conn, $sql);
    if(mysqli_error($conn)!=''){
        var_dump($sql);
        var_dump(mysqli_error($conn));
        exit();
    }
    if($res->LAUDO !='') {
        ibase_blob_close($blob_hndl);
    }
}




//-------------------------------------------------------Formulario-----------------------------------------------------

//ini_set('mysql.connect_timeout', 300);
//$clincia = "5968";
//$dbh = ibase_connect("C:\\temp\\skinlaser atualizado\\SKINLASER2000.fdb", "sysdba", "masterkey", "WIN1250");
//$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "clinicskinlaseratualizado2_0");
//
////$result = ibase_query("select first 10 documento ha, EXTENSAOARQUIVO ex from cl_pacientedocs where documento is not null and EXTENSAOARQUIVO is not null");
//$result = ibase_query("select handle, data, paciente, medico, recurso from cl_atendimentos ");
//
//$count = 0;
//while ($res = ibase_fetch_object($result)) {
//    $count += 10;
//    $pacienteid = $res->PACIENTE;
////echo         ibase_blob_get($blob_hndl, $blob_data[0]);
//
//
//    $sql = "insert into clinicskinlaseratualizado2_0.agendamentos_c (id, hora, data, pacienteid, recurso, medico) values ({$res->HANDLE}, '{$res->DATA}', '{$res->DATA}', '{$res->PACIENTE}', '{$res->RECURSO}', '{$res->MEDICO}')";
//    mysqli_query($conn, $sql);
//    if(mysqli_error($conn)!=''){
//        var_dump(mysqli_error($conn));
//
//    }
//
//}