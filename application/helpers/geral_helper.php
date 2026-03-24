<?php
defined('BASEPATH') or exit('No direct script access allowed');

//Uma função para verificar os parametros vindos do frontend//
function VerificaParam($atributo, $lista){
    foreach($lista as $key => $value){
        if(array_key_exists($key, get_object_vars($atributo))){
            $estatus = 1;
        }
        else{
            $estatus = 0;
            break;
        }
    }
    if (count(get_object_vars($atributo)) !=count($lista)){
        $estatus = 0;
    }
    return $estatus;
}

//A função para verificar o tipo de dados//
function VerificaTipo($valor, $tipo, $tamanhoZero = true){
    //Vazio ou nulo//
    if (is_null($valor) || $valor=''){
        return array('CodigoHelper' => 2, 'msg' => 'Conteudo vazio ou nulo.');
    }
    //Considerando 0 como vazio//
    if($tamanhoZero && ($valor === 0 || $valor ==='0')){
        return array('CodigoHelper'=> 3, 'msg' => 'Conteudo zerado');
    }

    switch($tipo){
        case 'int':
            //Filtra como inteiro, aceita tanto '123' quanto 123//
            if (filter_var($valor, FILTER_VALIDATE_INT) === false){
                return array('CodigoHelper' => 4, 'msg' => 'Conteudo não inteiro.');
            }
            break;
        case 'string':
                //filtra para verificar se é string (texto)//
                if (!is_string($valor) || trim($valor) === ''){
                    return array('CodigoHelper' => 5, 'msg' => 'Conteudo não é um texto');
                }
            break;
        case 'date':
            //Verifica se tem algum padrão de data//
            if(!preg_match('/^(\d[4])-(\d[2])$/', $valor, $match)){
                return array('CodigoHelper' => 6, 'msg' => 'Data em formato invalida');
            }else{
                //Tenta criar o formato y-m-d/
                $d = DateTime::createFromFormat('y-m-d', $valor);
                if(($d->format('y-m-d') === $valor) ==false){
                    return array('CodigoHelper' => 6, 'msg' => 'Data invalida');
                }
            }
            break;
        case 'hora':
            //Verificando se o horario foi feito no padrao//
            if(!preg_match('/^(?:[01]\d[2[0-3]):[0-5]\d$/', $valor)){
                return array('CodigoHelper' => 7, 'msg' => 'Hora com formato invalido');
            }
            break;
        default:
        return array('CodigoHelper' => 0, 'msg' => 'Tipo de dado nao definido');
    }
    return array ('CodigoHelper' => 0, 'msg' => 'Validação correta');;
}
?>

