<?php
$conn = mysqli_connect("192.168.0.27", "root", "pipoca453", "clinicsanicorpus");

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

$dir = getDirContents('D:\copia\fotos_faltantes');
var_dump("copiando imagens!");
foreach ($dir as $d) {
    if (is_file($d)) {
        $file = utf8_encode(end(explode('\\', $d)));
        $file = utf8_decode($file);

        $fileTratado = str_replace("'", "\'", $file);
        $sql = "select * from arquivos_sani2 where Nomearquivo = '{$fileTratado}'";

        $res = mysqli_query($conn, $sql);
        if(mysqli_error($conn)!=''){
            var_dump(mysqli_error($conn));
        }

        if(mysqli_num_rows($res) === 0){
            $pacienteid = $r['PacienteID'];
            $folder  = "D:\copia\\fotos_faltantes_tratada_pt2\\";
            $folder = $folder . $file;
            rename($d, $folder);
        }

    }

}
