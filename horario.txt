<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Horario extends CI_Controller
{
    /*
    Lista de Erros:
    1 - Operação realizada com Sucesso no banco de dados
    2 - Conteudo passado nulo ou vazio
    3 - Conteudo passado zerado
    4 - Conteudo passado não é do tipo inteiro
    5- Conteudo passado não é do tipo string
    6 - Data em formato invalido ou data inválida
    7 - Hora em formato invalido ou hora inválida
    12 - Na atualização, pelo menos um atributo deve ser passado
    13 - Hora inicial não pode ser maior que a hora final
    14 - Data inicial não pode ser maior que a data final
    99 - Parâmetros passados não correspondem ao metodo
    */

    //Atributos privados da classe
    private $codigo;
    private $descricao;
    private $horaInicial;
    private $horaFinal;
    private $estatus;

    //getters
    public function getCodigo()
    {
        return $this->codigo;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getHoraInicial()
    {
        return $this->horaInicial;
    }
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }
    public function getEstatus()
    {
        return $this->estatus;
    }

    //setters
    public function setCodigo($codigoFront)
    {
        $this->codigo = $codigoFront;
    }
    public function setDescricao($descricaoFront)
    {
        $this->descricao = $descricaoFront;
    }
    public function setHoraInicial($horaInicialFront)
    {
        $this->horaInicial = $horaInicialFront;
    }
    public function setHoraFinal($horaFinalFront)
    {
        $this->horaFinal = $horaFinalFront;
    }
    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    //Funções principais da classe
    public function Inserir()
    {
        //Atributos para controlar status do metodo
        $sucesso = false;
        $erros = [];

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'descricao' => '0',
                'horaInicial' => '0',
                'horaFinal' => '0'
            ];
            if (VerificaParam($resultado, $lista) != 1) {
                //Verifica quantidade de dados vindos (HELPER)
                $erros[] = array('codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos');
            } else {
                //Validações de tipo e conteúdo
                $retornoDescricao = VerificaTipo($resultado->descricao, 'string', true);
                $retornoHoraInicial = VerificaTipo($resultado->horaInicial, 'hora', true);
                $retornoHoraFinal = VerificaTipo($resultado->horaFinal, 'hora', true);
                $retornoComparacaoHora = VerificarDataHora($resultado->horaInicial, $resultado->horaFinal, 'hora');

                if ($retornoDescricao['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoDescricao['CodigoHelper'],
                        'campo' => 'descricao',
                        'msg' => $retornoDescricao['msg']
                    ];
                }
                if ($retornoHoraInicial['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoHoraInicial['CodigoHelper'],
                        'campo' => 'hora Inicial',
                        'msg' => $retornoHoraInicial['msg']
                    ];
                }
                if ($retornoHoraFinal['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoHoraFinal['CodigoHelper'],
                        'campo' => 'hora Final',
                        'msg' => $retornoHoraFinal['msg']
                    ];
                }
                if ($retornoComparacaoHora['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoComparacaoHora['CodigoHelper'],
                        'campo' => 'Hora inicial e Hora final',
                        'msg' => $retornoComparacaoHora['msg']
                    ];
                }
                //caso não encontre erros
                if (empty($erros)) {
                    $this->setDescricao($resultado->descricao);
                    $this->setHoraInicial($resultado->horaInicial);
                    $this->setHoraFinal($resultado->horaFinal);

                    $this->load->model('M_horario');
                    $resBanco = $this->M_horario->Inserir(
                        $this->getDescricao(),
                        $this->getHoraInicial(),
                        $this->getHoraFinal()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        //Captura de erros do banco de dados
                        $erros[] = [
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro inesperado: ' . $e->getMessage()];
        }
        //Montado retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //fazendo o retorno
        echo json_encode($retorno);
    }

    public function Consultar()
    {
        //Atributos para controlar status do metodo
        $sucesso = false;
        $erros = [];

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0',
                'descricao' => '0',
                'horaInicial' => '0',
                'horaFinal' => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //Verifica quantidade de dados vindos (HELPER)
                $erros[] = array('codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos');
            } else {
                //Validações de tipo e conteúdo
                $retornoCodigo = VerificaConsulta($resultado->codigo, 'int');
                $retornoDescricao = VerificaConsulta($resultado->descricao, 'string');
                $retornoHoraInicial = VerificaConsulta($resultado->horaInicial, 'hora');
                $retornoHoraFinal = VerificaConsulta($resultado->horaFinal, 'hora');
                $retornoComparacaoHora = VerificarDataHora($resultado->horaInicial, $resultado->horaFinal, 'hora');

                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoCodigo['CodigoHelper'],
                        'campo' => 'codigo',
                        'msg' => $retornoCodigo['msg']
                    ];
                }
                if ($retornoDescricao['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoDescricao['CodigoHelper'],
                        'campo' => 'descricao',
                        'msg' => $retornoDescricao['msg']
                    ];
                }
                if ($retornoHoraInicial['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoHoraInicial['CodigoHelper'],
                        'campo' => 'hora Inicial',
                        'msg' => $retornoHoraInicial['msg']
                    ];
                }
                if ($retornoHoraFinal['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoHoraFinal['CodigoHelper'],
                        'campo' => 'hora Final',
                        'msg' => $retornoHoraFinal['msg']
                    ];
                }

                if ($retornoComparacaoHora['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoComparacaoHora['CodigoHelper'],
                        'campo' => 'Hora inicial e Hora final',
                        'msg' => $retornoComparacaoHora['msg']
                    ];
                }
                //caso não encontre erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);
                    $this->setDescricao($resultado->descricao);
                    $this->setHoraInicial($resultado->horaInicial);
                    $this->setHoraFinal($resultado->horaFinal);

                    $this->load->model('M_horario');
                    $resBanco = $this->M_horario->Consultar(
                        $this->getCodigo(),
                        $this->getDescricao(),
                        $this->getHoraInicial(),
                        $this->getHoraFinal()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        //Captura de erros do banco de dados
                        $erros[] = [
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro inesperado: ' . $e->getMessage()];
        }
        //Montado retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg'], 'dados' => $resBanco['dados']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //fazendo o retorno
        echo json_encode($retorno);
    }

    public function Alterar()
    {
        //Atributos para controlar status do metodo
        $sucesso = false;
        $erros = [];

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0',
                'descricao' => '0',
                'horaInicial' => '0',
                'horaFinal' => '0'
            ];
            if (VerificaParam($resultado, $lista) != 1) {
                //Verifica quantidade de dados vindos (HELPER)
                $erros[] = array('codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos');
            } else {
                //Pelo menos um campo deve ser passado para atualização
                if (trim($resultado->descricao) == '' && trim($resultado->horaInicial) == '' && trim($resultado->horaFinal) == '') {
                    $erros[] = array('codigo' => 12, 'msg' => 'Pelo menos um campo deve ser passado para atualização');
                } else {
                    //Validações de tipo e conteúdo
                    $retornoCodigo = VerificaTipo($resultado->codigo, 'int', false);
                    $retornoDescricao = VerificaConsulta($resultado->descricao, 'string');
                    $retornoHoraInicial = VerificaConsulta($resultado->horaInicial, 'hora');
                    $retornoHoraFinal = VerificaConsulta($resultado->horaFinal, 'hora');
                    $retornoComparacaoHora = VerificarDataHora($resultado->horaInicial, $resultado->horaFinal, 'hora');

                    if ($retornoCodigo['CodigoHelper'] != 0) {
                        $erros[] = [
                            'codigo' => $retornoCodigo['CodigoHelper'],
                            'campo' => 'codigo',
                            'msg' => $retornoCodigo['msg']
                        ];
                    }
                    if ($retornoDescricao['CodigoHelper'] != 0) {
                        $erros[] = [
                            'codigo' => $retornoDescricao['CodigoHelper'],
                            'campo' => 'descricao',
                            'msg' => $retornoDescricao['msg']
                        ];
                    }
                    if ($retornoHoraInicial['CodigoHelper'] != 0) {
                        $erros[] = [
                            'codigo' => $retornoHoraInicial['CodigoHelper'],
                            'campo' => 'hora Inicial',
                            'msg' => $retornoHoraInicial['msg']
                        ];
                    }
                    if ($retornoHoraFinal['CodigoHelper'] != 0) {
                        $erros[] = [
                            'codigo' => $retornoHoraFinal['CodigoHelper'],
                            'campo' => 'hora Final',
                            'msg' => $retornoHoraFinal['msg']
                        ];
                    }

                    if ($retornoComparacaoHora['CodigoHelper'] != 0) {
                        $erros[] = [
                            'codigo' => $retornoComparacaoHora['CodigoHelper'],
                            'campo' => 'Hora inicial e Hora final',
                            'msg' => $retornoComparacaoHora['msg']
                        ];
                    }

                    //caso não encontre erros
                    if (empty($erros)) {
                        $this->setCodigo($resultado->codigo);
                        $this->setDescricao($resultado->descricao);
                        $this->setHoraInicial($resultado->horaInicial);
                        $this->setHoraFinal($resultado->horaFinal);

                        $this->load->model('M_horario');
                        $resBanco = $this->M_horario->Alterar(
                            $this->getCodigo(),
                            $this->getDescricao(),
                            $this->getHoraInicial(),
                            $this->getHoraFinal()
                        );
                        if ($resBanco['codigo'] == 1) {
                            $sucesso = true;
                        } else {
                            //Captura de erros do banco de dados
                            $erros[] = [
                                'codigo' => $resBanco['codigo'],
                                'msg' => $resBanco['msg']
                            ];
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro inesperado: ' . $e->getMessage()];
        }
        //Montado retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //fazendo o retorno
        echo json_encode($retorno);
    }

    public function Desativar()
    {
        //Atributos para controlar status do metodo
        $sucesso = false;
        $erros = [];

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                'codigo' => '0'
            ];
            if (VerificaParam($resultado, $lista) != 1) {
                //Verifica quantidade de dados vindos (HELPER)
                $erros[] = array('codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos');
            } else {
                //Validações de tipo e conteúdo
                $retornoCodigo = VerificaTipo($resultado->codigo, 'int', false);

                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = [
                        'codigo' => $retornoCodigo['CodigoHelper'],
                        'campo' => 'codigo',
                        'msg' => $retornoCodigo['msg']
                    ];
                }
                //caso não encontre erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);

                    $this->load->model('M_horario');
                    $resBanco = $this->M_horario->Desativar(
                        $this->getCodigo()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        //Captura de erros do banco de dados
                        $erros[] = [
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro inesperado: ' . $e->getMessage()];
        }
        //Montado retorno unico
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //fazendo o retorno
        echo json_encode($retorno);
    }
}
