<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sala extends CI_Controller{
/*
Explicação rapida de tipos de retorno do codigo (CODIGOS DE ERRO)
1 - Operação realizada no banco de dados com sucesso
2 - Conteudo Nulo ou vazio
3 - Conteudo zerado
4 - Conteudo não inteiro
5 - Conteudo não é um texto
6 - Data em formato inválido
7 - Hora em formato inválido
99- Parâmetros passados do front nao correspondem ao metodo
*/

//Atributos privados
private $codigo;
private $descricao;
private $andar;
private $capacidade;
private $estatus;

//Getters
public function getCodigo(){
    return $this->codigo;
}
public function getDescricao(){
    return $this->descricao;
}
public function getAndar(){
    return $this->andar;
}
public function getCapacidade(){
    return $this->capacidade;
}
public function getEstatus(){
    return $this->estatus;
}
//setters
public function setCodigo($codigoFront){
    $this->codigo = $codigoFront;
}
public function setDescricao($descricaoFront){
    $this->descricao = $descricaoFront;
}
public function setAndar($andarFront){
    $this->andar = $andarFront;
}
public function setCapacidade($capacidadeFront){
    $this->capacidade = $capacidadeFront;
}
public function setEstatus($estatusFront){
    $this->TipoUsuario = $estatusFront;
}

public function Inserir(){
    //Atributos para controlar o status de nosso metodo
    $erros = [];
    $sucesso =false;

    try {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = [
            "codigo" => '0',
            "descricao" =>'0',
            "andar" => '0',
            "capacidade" => '0'
        ];

        if(VerificaParam($resultado, $lista) !=1){
            //valida os que vem de forma correta pelo front (helper)
            $erros[] = ['codigo' => 99, 'msg' => 'Campos incexistentes ou incorretos'];
        }else{
            //Valida campos e os tipos de dado (helper)
            $retornoCodigo = VerificaTipo($resultado->codigo, 'int' ,true);
            $retornoDescricao = VerificaTipo($resultado->descricao, 'string' , true);
            $retornoAndar = VerificaTipo($resultado->andar, 'int' , true);
            $retornoCapacidade = VerificaTipo($resultado->capacidade,'int' ,true);

            if ($retornoCodigo['CodigoHelper'] != 0){
                $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'],
                'campo' => 'Codigo',
                'msg' => $retornoCodigo['msg']];
            }
            if($retornoDescricao['CodigoHelper'] !=0){
            $erros[] = ['descricao' => $retornoDescricao['CodigoHelper'],
            'campo' => 'Descrição',
            'msg' => $retornoDescricao['msg']];
            }
            if($retornoAndar['CodigoHelper'] != 0){
                $erros[] = ['codigo' => $retornoAndar['CodigoHelper'],
                'campo' => 'Andar',
                'msg' => $retornoAndar['msg']];
            }
            if($retornoCapacidade['CodigoHelper'] != 0){
                $erros[] = ['capacidade' => $retornoCapacidade['CodigoHelper'],
                'campo' => 'Capacidade',
                'msg' => $retornoCapacidade['msg']];
            }
            if (empty($erros)){
                $this->setCodigo($resultado->codigo);
                $this->setDescricao($resultado->descricao);
                $this->setAndar($resultado->andar);
                $this->setCapacidade($resultado->capacidade);

                $this->load->model('M_sala');
                $resBanco = $this->M_sala->inserir(
                    $this->getCodigo(),
                    $this->getDescricao(),
                    $this->getAndar(),
                    $this->getCapacidade()
                );

                if ($resBanco['codigo']== 1){
                    $sucesso = true;
                }else{
                    //Erros encontrados no Banco
                    $erros[] = [
                        'codigo' => $resBanco['codigo'],
                        'msg' => $resBanco['msg']
                    ];
                }
            }
        }
    } catch(Exception $e) {
        $erros[] = ['codigo' => 0, 'msg' => 'Erro inesperado: '. $e->getMessage()];
    }

    //monta retorno unico
    if ($sucesso == true) {
        $retorno = ['sucesso' => $sucesso, 'msg' => 'Sala cadasatrada corretamente.'];
    }else{
        $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
    }

    echo json_encode($retorno);
}

}
?>