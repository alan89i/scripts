<?php
ini_set('memory_limit', '-1');
$con = mysqli_connect("192.168.0.27", "root", "pipoca453", "sanicorpus_relacaoimagem");

$con2 = mysqli_connect("192.168.0.27", "root", "pipoca453", "clinicsanicorpus");

function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

$dir = getDirContents('D:\copia\teste');

print_r("Iniciando a copia dos arquivos");
$count = 0;

foreach ($dir as $d) {
    if (is_file($d)) {


        $file = end(explode('\\', $d));


//        $sql = "select b.id pacienteId, a.id, `data` as datahora  from historico a inner join contatos b on b.`Id do Cliente` = a.`Id do Cliente` where a.classe = '$file'";
        // $sql = "select pacienteId, id, concat(fot_data,' ', fot_hora)datahora from fotos_pacientes where fot_nomeFoto = '$file' limit 1";
//        $sql = "select paccodigo pacienteId, pacarqcodigo id, pacarqdatahora datahora, pacarqdescricao descricao from cadpacarquivos  where pacarqnomearq = '{$file}'";
//        $file = current(explode('.', $file));
//        $file = str_replace("'", "\'", $file);
//        $file = utf8_encode($file);
//        $file = utf8_decode($file);
        $file = mysqli_real_escape_string($con2, $file);
        $file = utf8_decode($file);
//        Foto
//        $sql = "select a.id pacienteId, b.createtime from view_pacientes_relacao_copy a inner join image b on b.LINKNUM = a.RECNUM where b.image_feegow = '{$file}'";
//        Laudo
//        $sql = "select codigo_paciente pacienteId, id, arquivo, `data`, tipo from imagenspacientes where arquivo = '{$file}'";
        $pacienteid = '';
        $sql = "insert into arquivos (nomearquivo, tipo)values('{$file}', 'I')";
        $res = mysqli_query($con2, $sql);

        if (mysqli_error($con2) !== "") {
            var_dump(mysqli_error($con2));
            var_dump($sql);
        }
    };
};