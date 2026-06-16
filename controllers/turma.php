<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Turma extends CI_Controller
{
    /*
    Lista de Erros:
    1 - Operação realizada com Sucesso no banco de dados
    2 - Conteudo passado nulo ou vazio
    3 - Conteudo passado zerado
    4 - Conteudo passado não é do tipo inteiro
    5- Conteudo passado não é do tipo string
    6 - Data em formato invalido ou data inválida
    12 - Na atualização, pelo menos um atributo deve ser passado
    99 - Parâmetros passados não correspondem ao metodo
    */

    //Atributos privados da classe
    private $codigo;
    private $descricao;
    private $capacidade;
    private $dataInicio;
    private $estatus;

    //GETTERS--------------------------------------------------------------0

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getCapacidade()
    {
        return $this->capacidade;
    }

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    //SETTERS--------------------------------------------------------------0

    public function setCodigo($codigoFront)
    {
        $this->codigo = $codigoFront;
    }

    public function setDescricao($descricaoFront)
    {
        $this->descricao = $descricaoFront;
    }

    public function setCapacidade($capacidadeFront)
    {
        $this->capacidade = $capacidadeFront;
    }

    public function setDataInicio($dataInicioFront)
    {
        $this->dataInicio = $dataInicioFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function inserir()
    {
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'descricao' => '0',
                'capacidade' => '0',
                'dataInicio' => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //validar dados vindo de forma correta do front(helper)
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos.'];
            } else {
                //Validar campos - tipos e tamanho
                $retornoDescricao = VerificaTipo($resultado->descricao, 'string', true);
                $retornoCapacidade = VerificaTipo($resultado->capacidade, 'int', true);
                $retornoDataInicio = VerificaTipo($resultado->dataInicio, 'date', true);

                //Pega os erros de cada campo e joga em um array para retornar para o front
                if ($retornoDescricao['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDescricao['CodigoHelper'], 'campo' => 'descricao', 'msg' => $retornoDescricao['msg']];
                }
                if ($retornoCapacidade['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCapacidade['CodigoHelper'], 'campo' => 'capacidade', 'msg' => $retornoCapacidade['msg']];
                }
                if ($retornoDataInicio['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDataInicio['CodigoHelper'], 'campo' => 'Data Inicial', 'msg' => $retornoDataInicio['msg']];
                }

                //Caso nao encontre erros
                if (empty($erros)) {
                    $this->setDescricao($resultado->descricao);
                    $this->setCapacidade($resultado->capacidade);
                    $this->setDataInicio($resultado->dataInicio);

                    //Mandar dados para o model
                    $this->load->model('M_turma');
                    $resBanco = $this->M_turma->inserir(
                        $this->getDescricao(),
                        $this->getCapacidade(),
                        $this->getDataInicio()
                    );
                    //verifica se deu erro no model
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros[] = ['codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Ocorreu um erro inesperado: ' . $e->getMessage()];
        }
        //Montando retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //Transformando em json para retornar
        echo json_encode($retorno);
    }

    public function consultar()
    {
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0',
                'descricao' => '0',
                'capacidade' => '0',
                'dataInicio' => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //validar dados vindo de forma correta do front(helper)
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos.'];
            } else {
                //Validar campos - tipos e tamanho
                $retornoCodigo = VerificaConsulta($resultado->codigo, 'int');
                $retornoDescricao = VerificaConsulta($resultado->descricao, 'string');
                $retornoCapacidade = VerificaConsulta($resultado->capacidade, 'int');
                $retornoDataInicio = VerificaConsulta($resultado->dataInicio, 'date');

                //Pega os erros de cada campo e joga em um array para retornar para o front
                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'codigo', 'msg' => $retornoCodigo['msg']];
                }
                if ($retornoDescricao['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDescricao['CodigoHelper'], 'campo' => 'descricao', 'msg' => $retornoDescricao['msg']];
                }
                if ($retornoCapacidade['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCapacidade['CodigoHelper'], 'campo' => 'capacidade', 'msg' => $retornoCapacidade['msg']];
                }
                if ($retornoDataInicio['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDataInicio['CodigoHelper'], 'campo' => 'Data Inicial', 'msg' => $retornoDataInicio['msg']];
                }
                //Caso nao encontre erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);
                    $this->setDescricao($resultado->descricao);
                    $this->setCapacidade($resultado->capacidade);
                    $this->setDataInicio($resultado->dataInicio);

                    //Mandar dados para o model
                    $this->load->model('M_turma');
                    $resBanco = $this->M_turma->consultar(
                        $this->getCodigo(),
                        $this->getDescricao(),
                        $this->getCapacidade(),
                        $this->getDataInicio()
                    );
                    //verifica se deu erro no model
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros[] = ['codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Ocorreu um erro inesperado: ' . $e->getMessage()];
        }

        //montando retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg'], 'dados' => $resBanco['dados']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //Transformando em json para retornar
        echo json_encode($retorno);
    }

    public function alterar()
    {
        //padrão de sempre
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0',
                'descricao' => '0',
                'capacidade' => '0',
                'dataInicio' => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //validar dados vindo de forma correta do front(helper)
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos.'];
            } else {
                if (trim($resultado->descricao) == '' && trim($resultado->capacidade) == '' && trim($resultado->dataInicio) == '') {
                    $erros[] = ['codigo' => 12, 'msg' => 'Pelo menos um campo deve ser preenchido para atualização.'];
                    $retornoCodigo = VerificaTipo($resultado->codigo, 'int', true);
                    if ($retornoCodigo['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'codigo', 'msg' => $retornoCodigo['msg']];
                    }
                } else {
                    //Validar campos - tipos e tamanho
                    $retornoCodigo = VerificaTipo($resultado->codigo, 'int', true);
                    $retornoDescricao = VerificaConsulta($resultado->descricao, 'string');
                    $retornoCapacidade = VerificaConsulta($resultado->capacidade, 'int');
                    $retornoDataInicio = VerificaConsulta($resultado->dataInicio, 'date');

                    //Pega os erros de cada campo e joga em um array para retornar para o front
                    if ($retornoCodigo['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'codigo', 'msg' => $retornoCodigo['msg']];
                    }
                    if ($retornoDescricao['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoDescricao['CodigoHelper'], 'campo' => 'descricao', 'msg' => $retornoDescricao['msg']];
                    }
                    if ($retornoCapacidade['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoCapacidade['CodigoHelper'], 'campo' => 'capacidade', 'msg' => $retornoCapacidade['msg']];
                    }
                    if ($retornoDataInicio['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoDataInicio['CodigoHelper'], 'campo' => 'Data Inicial', 'msg' => $retornoDataInicio['msg']];
                    }
                    //Caso nao encontre erros
                    if (empty($erros)) {
                        $this->setCodigo($resultado->codigo);
                        $this->setDescricao($resultado->descricao);
                        $this->setCapacidade($resultado->capacidade);
                        $this->setDataInicio($resultado->dataInicio);

                        //Mandar dados para o model
                        $this->load->model('M_turma');
                        $resBanco = $this->M_turma->alterar(
                            $this->getCodigo(),
                            $this->getDescricao(),
                            $this->getCapacidade(),
                            $this->getDataInicio()
                        );
                        //verifica se deu erro no model
                        if ($resBanco['codigo'] == 1) {
                            $sucesso = true;
                        } else {
                            $erros[] = ['codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Ocorreu um erro inesperado: ' . $e->getMessage()];
        }
        //Montando outro retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //Transformando em json para retornar
        echo json_encode($retorno);
    }

    public function desativar()
    {
        $erros = [];
        $sucesso = false;
        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //validar dados vindo de forma correta do front(helper)
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos.'];
            } else {
                //Validar campos - tipos e tamanho
                $retornoCodigo = VerificaTipo($resultado->codigo, 'int', true);

                //Pega os erros de cada campo e joga em um array para retornar para o front
                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'codigo', 'msg' => $retornoCodigo['msg']];
                }
                //Caso nao encontre erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);

                    //Mandar dados para o model
                    $this->load->model('M_turma');
                    $resBanco = $this->M_turma->desativar(
                        $this->getCodigo()
                    );
                    //verifica se deu erro no model
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros[] = ['codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Ocorreu um erro inesperado: ' . $e->getMessage()];
        }

        //montando retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }

        //tranformando em json para retornar
        echo json_encode($retorno);
    }
}
