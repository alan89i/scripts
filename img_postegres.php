<?php
$clincia = "6425";
//$dbh = ibase_connect("C:\\temp\\skinlaser atualizado\\skinlaser skinlaser - SKINIMAGENS\\SKINIMAGENS.FDB", "sysdba", "masterkey", "WIN1250");
//$dbh = ibase_connect("C:\\temp\\PRJ.FDB", "sysdba", "masterkey", "WIN1250");
$dbh = $d=pg_connect('host=localhost user=postgres dbname=evancley password=pipoca453');
$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "cliniccoe");

//$result = ibase_query("select first 10 documento ha, EXTENSAOARQUIVO ex from cl_pacientedocs where documento is not null and EXTENSAOARQUIVO is not null");
//$result = ibase_query("select  handle, documento ha, EXTENSAOARQUIVO EX, paciente from cl_pacientedocs");
//$result = ibase_query("select handle, documento ha, paciente from cl_pacientedocs");
//$result = ibase_query("select imagem ha, paciente_id paciente, prontuario_id handle, nomearquivo arq from prj020149 where imagem is not null and imagem !='' and prontuario_id > 6843 order by prontuario_id");
$result = pg_query($dbh, "SELECT id, apagadoem, paciente, data, tipo, usuario, texto, revisao, datarevisao, especialidade, arquivo, imagem, imagemminiatura, nomedocumento, documento, assinatura, assinaturaimagem, assinaturadocumento, origemregistro, tipotexto, extensaodocumento, tamanhodocumento
	FROM public.t_pacientesimagens where imagem is not null;");
$count = 0;
while ($res = pg_fetch_array($result)) {

    $img = pg_unescape_bytea($res['imagem']);
    $count += 10;
    $pacienteid = $res->PACIENTE;
    $blob_data = ibase_blob_info($res['imagem']);
    $blob_hndl = ibase_blob_open($res['imagem']);
    $descricao  =$res->ARQ;
    $handle = $res->HANDLE;
//echo         ibase_blob_get($blob_hndl, $blob_data[0]);
    $nome = hash('md5',  $clinica . $pacienteid . $count).".jpg";
    file_put_contents("C:/temp/pg_img/test.jpg", $img);

//    $sql = "insert into cliniccoe.arquivos (id, NomeArquivo, Descricao, Tipo, Pacienteid) values($handle, '{$nome}', '{$descricao}', 'I', {$pacienteid})";
//
//    mysqli_query($conn, $sql);
//    if(mysqli_error($conn)!=''){
//        var_dump(mysqli_error($conn));
//    }
    ibase_blob_close($blob_hndl);
    exit();
}