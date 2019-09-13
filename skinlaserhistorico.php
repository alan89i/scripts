<?php
ini_set('mysql.connect_timeout', 300);
$clincia = "5968";
$dbh = ibase_connect("C:\\temp\\institutoultra\\UB_CENTRO.fdb", "sysdba", "masterkey", "utf8");
$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "ultrassonografiabotafogoeireli");

//$result = ibase_query("select first 10 documento ha, EXTENSAOARQUIVO ex from cl_pacientedocs where documento is not null and EXTENSAOARQUIVO is not null");
//$result = ibase_query("select handle, paciente, data dt, historia ha from cl_pacientehistoria order by handle"); skinlaser
$result = ibase_query("select * from l_laudo");

$count = 0;
while ($res = ibase_fetch_object($result)) {
    $table = array_keys(json_decode(json_encode($res), true));
    var_dump($table);
    exit();
    $count += 10;
    $pacienteid = $res->PACIENTE;
    $blob_data = ibase_blob_info($res->HA);
    $blob_hndl = ibase_blob_open($res->HA);
//echo         ibase_blob_get($blob_hndl, $blob_data[0]);

    $txt = ibase_blob_get($blob_hndl, $blob_data[0]);
    $txt = utf8_encode(utf8_decode($txt));

//    $txt = str_replace("'", '@', $txt);
    var_dump($txt);
    $sql = "insert into skinlaseratualizado3_0._8_copy (id, PacienteID, datahora, sysuser, `50`) values({$res->HANDLE}, {$pacienteid}, '{$res->DT}',0 ,'{$txt}')";
    mysqli_query($conn, $sql);
    if(mysqli_error($conn)!=''){
        var_dump(mysqli_error($conn));
        exit();
    }
    ibase_blob_close($blob_hndl);
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