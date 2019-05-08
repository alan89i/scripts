<?php
/**
 * Gera um documento com valores separados por vírgula
 */
class CSV {
    /**
     * Matriz que irá armazenar todas as linhas do CSV
     * @var array
     */
    private $data = array();

    /**
     * Número de colunas
     * @var integer
     */
    private $fields = 0;

    /**
     * Salva o arquivo em disco
     * @param string $file O nome do arquivo
     */
    public function save( $file ){
        $dir = dirname( $file );
        $ret = false;

        if ( !empty( $dir ) ){
            if ( !is_dir( $dir ) ){
                throw new Exception( "O diretório não existe." );
            }
        }

        if ( file_exists( $file ) ){
            if ( !is_writable( $file ) ){
                throw new Exception( "O arquivo de destino não é gravável." );
            }
        }

        if ( ( $fh = fopen( $file , "w+" ) ) ){
            $csv = (string) $this;
            fwrite( $fh , $csv , strlen( $csv ) );
            fclose( $fh );
            $ret = true;
        } else {
            throw new Exception( "Não foi possível abrir/criar o arquivo para gravação." );
        }

        return( $ret );
    }

    /**
     * Adiciona uma nova linha ao CSV
     * @param CSVLine $line A linha que será adicionada
     * @return CSV Referência ao próprio objeto
     */
    public function addLine( CSVLine $line ){
        if ( !count( $this->data ) ){
            $this->fields = $line->count();
        } elseif ( $this->fields != $line->count() ){
            throw new Exception( "Todas as linhas devem ter o mesmo número de colunas" );
        }

        $this->data[] = $line;
        return( $this );
    }

    /**
     * Converte o objeto para sua representação em string
     * @return string
     */
    public function __toString(){
        return( implode( "\n" , $this->data ) );
    }
}


/**
 * Gera uma linha de um documento com valores separados por vírgula
 */
class CSVLine {
    /**
     * Matriz que irá armazenar os dados das colunas
     * @var array
     */
    private $data = array();

    /**
     * Número de campos da linha
     * @var integer
     */
    private $fields = 0;

    /**
     * Constroi uma nova linha de valores separados por vírgula
     * @param mixed $arg1[optional] Um valor que será armazenado na linha
     * @param mixed $arg2[optional] Um valor que será armazenado na linha
     * @param mixed ... Um valor que será armazenado na linha
     * @param mixed $argn[optional] Um valor que será armazenado na linha
     */
    public function __construct( $arg1 , $arg2 , $argn ){
        $argv = func_get_args();
        $argc = count( $argv );

        for ( $i = 0 ; $i < $argc ; $i++ ){
            $this->addData( $argv[ $i ] );
        }
    }

    /**
     * Converte o objeto para sua representação em string
     * @return string
     */
    public function __toString(){
        return( implode( "," , $this->data ) );
    }

    /**
     * Adiciona um novo valor à linha
     * @param mixed $value Um valor qualquer
     * @return CSVLine Referência ao próprio objeto
     */
    public function addData( $value ){
        if ( preg_match( "/(,|\r\n|\n|\"|')+/" , $value ) ){
            $value = preg_replace( "/\"+/" , "\"\"" , $value );
            $value = sprintf( "\"%s\"" , $value );
        }

        $this->data[] = $value;
        ++$this->fields;
    }

    /**
     * Conta o número de colunas que a linha possui
     * @return integer
     */
    public function count(){
        return( count( $this->data ) );
    }
}




$csv = new CSV();
$a = ["primeiro", "segundo"];
$csv->addLine(new CSVLine( 1997 , "Ford"  ));
//$csv
//    ->addLine( new CSVLine( 1997 , "Ford"  , "E350" , "ac, abs, moon" , 3000.00 ) )
//    ->addLine( new CSVLine( 1999 , "Chevy" , "Venture \"Extended Edition\"" , null , 4900.00 ) )
//    ->addLine( new CSVLine( 1996 , "Jeep"  , "Grand Cherokee" , "MUST SELL!
//air, moon roof, loaded" , 4799.00 ) );

$csv->save( "arquivo.csv" );