<?php

$con = mysqli_connect("192.168.0.27", "root", "pipoca453", "dziabas");
$con2 = mysqli_connect("192.168.0.27", "root", "pipoca453", "clinicdziabas");
$clinica = '6517';
//$dir1 = scandir('C:\Users\paulo\OneDrive\Documentos\Fotos_vilela');
//$dir = array_slice($dir1, 2);

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

$dir = getDirContents('C:\Users\paulo\OneDrive\Documentos\dziabasimg');

print_r("Iniciando a copia dos arquivos");
$count = 0;

foreach ($dir as $d) {
    if (is_file($d)) {

        $count += 1;
        $file = utf8_encode(explode('\\', $d)[8]);


//        $sql = "select b.id pacienteId, a.id, `data` as datahora  from historico a inner join contatos b on b.`Id do Cliente` = a.`Id do Cliente` where a.classe = '$file'";
        // $sql = "select pacienteId, id, concat(fot_data,' ', fot_hora)datahora from fotos_pacientes where fot_nomeFoto = '$file' limit 1";
//        $sql = "select paccodigo pacienteId, pacarqcodigo id, pacarqdatahora datahora, pacarqdescricao descricao from cadpacarquivos  where pacarqnomearq = '{$file}'";
        $sql = "select column1 pacienteId from pacientes1 where column29 like '%{$file}%' and column29 is not null";
        $pacienteid = '';
        $d = utf8_decode(utf8_encode($d));
        var_dump($file);
        $res = mysqli_query($con, $sql);
        if (mysqli_error($con) !== "") {
            var_dump(mysqli_error($con));
        }

//        print_r(utf8_encode($file."\n"));
        foreach ($res as $i) {

            if (!empty($i['pacienteId'])) {

                $pacienteid = $i['pacienteId'];


                $extensao = explode('.', $file)[1];
                $tipo = 'A';

                if ($extensao == 'jpg' or $extensao == 'png') {
                    $tipo = 'I';
                }

                $nome = hash('md5', $file . $clinica . $pacienteid . $count) . '.' . $extensao;
//                $sql = "insert into arquivos (NomeArquivo, Descricao, Tipo, pacienteid, datahora) values('$nome', '$descricao', '$tipo', $pacienteid, '$datahora')";
                $sql ="update pacientes set foto = '$nome' where id = {$pacienteid}";
                mysqli_query($con2, $sql);
                if (mysqli_error($con2) !== "") {
                    var_dump(mysqli_error($con2));
                }

                $folder = "C:\Users\paulo\OneDrive\Documentos\arquivo\img\\" . $nome;

                if ($tipo == 'A') {
                    $folder = "C:\Users\paulo\OneDrive\Documentos\arquivo\arquivo\\" . $nome;
                }

                //var_dump($d);
                rename($d, $folder);
            }

        }


    }
}

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


