<?php
ini_set('memory_limit', '-1');
$con = mysqli_connect("192.168.0.27", "root", "pipoca453", "dermathos2");
$con2 = mysqli_connect("192.168.0.27", "root", "pipoca453", "clinicdermathos");
$clinica = '6586';
//$dir1 = scandir('C:\Users\paulo\OneDrive\Documentos\Fotos_vilela');
//$dir = array_slice($dir1, 2);

list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;


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

//print_r(getDirContents('C:\Users\paulo\OneDrive\Documentos\Fotos_vilela'));

$dir = getDirContents('D:\copia\fotos_faltantes_pt2');

print_r("Iniciando a copia dos arquivos");
$count = 0;
$contato = 1;
foreach ($dir as $d) {
//    $contador = $contador + 1;
    if (is_file($d)) {


//        var_dump($file);
        $count += 1;
        $file = utf8_encode(end(explode('\\', $d)));
        $file =  utf8_decode($file);


//        $sql = "select b.id pacienteId, a.id, `data` as datahora  from historico a inner join contatos b on b.`Id do Cliente` = a.`Id do Cliente` where a.classe = '$file'";
        // $sql = "select pacienteId, id, concat(fot_data,' ', fot_hora)datahora from fotos_pacientes where fot_nomeFoto = '$file' limit 1";
//        $sql = "select paccodigo pacienteId, pacarqcodigo id, pacarqdatahora datahora, pacarqdescricao descricao from cadpacarquivos  where pacarqnomearq = '{$file}'";


            $sql = "select codigo_paciente pacienteId from cadpaci where foto_pac like '%{$file}%'";
            $pacienteid = '';
            $d = utf8_decode(utf8_encode($d));


//            $res = mysqli_query($con, $sql);
//            if (mysqli_error($con) !== "") {
//                var_dump(mysqli_error($con));
//            }


//        print_r(utf8_encode($file."\n"));
//            for ($i =  0; $i <= 9; $i++) {

//                if (!empty($i['pacienteId'])) {

//                    $pacienteid = $i['pacienteId'];


//                    $extensao = explode('.', $file)[1];
//                    $tipo = 'A';

//                    if ($extensao == 'jpg' or $extensao == 'png') {
//                        $tipo = 'I';
//                    }

//                    $nome = hash('md5', $file . $clinica . $pacienteid . $count) . '.' . $extensao;
////                $sql = "insert into arquivos (NomeArquivo, Descricao, Tipo, pacienteid, datahora) values('$nome', '$descricao', '$tipo', $pacienteid, '$datahora')";
//                    $sql = "update pacientes set foto = '$nome' where id = {$pacienteid}";
//                    mysqli_query($con2, $sql);
//                    if (mysqli_error($con2) !== "") {
//                        var_dump(mysqli_error($con2));
//                    }

                    $folder = "D:\\copia\\fotos_faltantes_tratada_pt2";

//                    if ($tipo == 'A') {
//                        $folder = "C:\Users\paulo\OneDrive\Documentos\arquivo\arquivo\\" . $nome;
//                    }

                    //var_dump($d);
                    //rename($d, $folder);

//                    $nomeHash = hash('md5', $file . $clinica . $pacienteid . $count). ".". $extensao;
                        $nomeHash = $file;

//                    reduzirImagem($d, $nomeHash, $folder, (1024 * 1024 * 4));
//                }

//            }
        }

//    if($contato == 1001){
//        break;
//    }
}

function reduzirImagem($dirFile, $nameHash, $newFolder, $limiteSize = (1024 * 1024 * 5)){

    //Caminho do arquivo
//    $imageFile = $dirFile . DIRECTORY_SEPARATOR. $nameFile;
    $imageFile = $dirFile;
    //Valida se o arquivo existe

        if(is_file($imageFile)) {
            //pegar o tamanho od arquivo
            $size = filesize($imageFile);

            //se o tamanhp for maior que o tamanho minomo (5mb)
            if ($size > $limiteSize) {
                //+Pegar largura e altura do arquivo
                list($width, $height) = getimagesize($imageFile);

                //Criar uma imagem em branco com a lar e alt
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($imageFile);
                //Fazer a copia do arquivo original para o novo arquivo (imagem em branco)
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);

                //criar a nova imagem com 70% de qualidade da anteriore


                imagejpeg($image_p, $newFolder .'\\'. $nameHash, 70);
                imagedestroy($image_p);
                //unlink($dirFile.  DIRECTORY_SEPARATOR . $imageFile);
            }
        }
}



list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
var_dump($elapsed_time);
//Caso id esteja no nome da pasta ------
//$dir = getDirContents('C:\Users\paulo\OneDrive\Documentos\Fotos_vilela');
//$i = 0;
//foreach ($dir as $d) {
//    if(is_file($d)){
//        $i++;
//        $pacienteid = explode('_', explode("\\", $d)[6])[0];
////        var_dump($pacienteid);
//        $nomeArquivo = end(explode("\\",$d));
//        $extensao = end(explode(".", $nomeArquivo));
//        $hash = hash('md5', $d.'clinic5856_'.$pacienteid.$i);
//        var_dump($nomeArquivo);
//        $folder = "C:\Users\paulo\OneDrive\Documentos\BIBLIOTECADIGITAL_PACIENTE\\" . "img" . "\\" . $hash.'.'.$extensao;
//        $sql = "insert into arquivos (NomeArquivo, Descricao, Tipo, PacienteID) values('$hash', '$nomeArquivo', 'A', $pacienteid)";
//        mysqli_query($con, $sql);
//        if(mysqli_error($con)!==""){
//            var_dump(mysqli_error($con));
//        }
//        rename($d, $folder);
//
//    }
//
//
//}
//mysqli_close($con);
var_dump($count);


