<?php
ini_set('mysql.connect_timeout', 300);
$clincia = "5968";
//$dbh = ibase_connect("C:\\temp\\institutoultra\\UB_CENTRO.fdb", "sysdba", "masterkey", "utf8");
//$dbh = ibase_connect("C:\\temp\\mirela\\DB1-QUI.fdb", "sysdba", "masterkey", "utf8");
$dbh = ibase_connect("C:\\temp\\institutoultra\\2019-06-10\\bruno ultrassonografia - UB_CENTRO.fdb", "sysdba", "masterkey", "utf8");
//$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "mariafigueiredo");
$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "ultrassonografiabotafogoeireli");
$t = "l_laudocorreto";
//$result = ibase_query("select first 10 documento ha, EXTENSAOARQUIVO ex from cl_pacientedocs where documento is not null and EXTENSAOARQUIVO is not null");
//$result = ibase_query("select handle, paciente, data dt, historia ha from cl_pacientehistoria order by handle"); skinlaser
$result = ibase_query("select * from l_laudo");

$count = 0;
while ($res = ibase_fetch_object($result)) {
    $table = array_keys(json_decode(json_encode($res), true));


    $table = implode(' text, ', $table);
    $table = $table.' text';
    $create = "CREATE TABLE IF NOT EXISTS `{$t}` ({$table})";
    mysqli_query($conn, $create);
    if(mysqli_error($conn)!=''){
        var_dump(mysqli_error($conn));
        var_dump($create);
        exit();
    }


    $columns = [];
    $data = "(";
    $columnsArray = array_keys(json_decode(json_encode($res), true));

    foreach ($columnsArray as $c) {
        array_push($columns, "`" . $c . "`");
    }
    $columns = implode(", ", $columns);
//        var_dump($array);
    foreach ($res as $a) {

        if ($a == null) {
            $data = $data . 'null, ';
        } else {


            $a = str_replace("'", "\'", $a);

            $a = utf8_decode($a);
            $data = $data . "'" . $a . "', ";
        }
    }
    $data = $data . "@";
    $data = str_replace(", @", ")", $data);


    $sql = "insert into `{$t}` ({$columns}) values {$data}";
    mysqli_query($conn, $sql);

    if(mysqli_error($conn)!=''){
        var_dump(mysqli_error($conn));
        var_dump($sql);

    }



//    exit();

//echo         ibase_blob_get($blob_hndl, $blob_data[0]);

//    $txt = ibase_blob_get($blob_hndl, $blob_data[0]);
//    $txt = utf8_encode(utf8_decode($txt));

//    $txt = str_replace("'", '@', $txt);
//   exit();
//    $sql = "insert into skinlaseratualizado3_0._8_copy (id, PacienteID, datahora, sysuser, `50`) values({$res->HANDLE}, {$pacienteid}, '{$res->DT}',0 ,'{$txt}')";
//    mysqli_query($conn, $sql);
//    if(mysqli_error($conn)!=''){
//        var_dump(mysqli_error($conn));
//        exit();
//    }
//    ibase_blob_close($blob_hndl);
}
$fb = "select  from l_admissao_laudo";
$sql = "update l_admissao_laudo2 set laudo = {}";



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