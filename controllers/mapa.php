<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapa extends CI_Controller
{

    /*
1 - operação realizada no bancod de dados com sucesso
2 - conteudo vazio ou nulo
3 - conteudo zerado
4 - conteudo não inteiro
5 - conteudo não é um texto
6 - data em formato inválido
12 - na atualização, pelo menos um atributo precisa ser passado
99 - parametros passados no frontend não correspondem ao metodo

*/

    private $codigo;
    private $dataReserva;
    private $codigo_sala;
    private $codigo_horario;
    private $codigo_turma;
    private $codigo_professor;
    private $estatus;

    private $dataInicio;
    private $dataFim;
    private $diaSemana;


    // Getters e Setters

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigoFront)
    {
        $this->codigo = $codigoFront;
    }

    public function getDataReserva()
    {
        return $this->dataReserva;
    }

    public function setDataReserva($dataReservaFront)
    {
        $this->dataReserva = $dataReservaFront;
    }

    public function getCodigoSala()
    {
        return $this->codigo_sala;
    }

    public function setCodigoSala($codigo_salaFront)
    {
        $this->codigo_sala = $codigo_salaFront;
    }

    public function getCodigoHorario()
    {
        return $this->codigo_horario;
    }

    public function setCodigoHorario($codigo_horarioFront)
    {
        $this->codigo_horario = $codigo_horarioFront;
    }

    public function getCodigoTurma()
    {
        return $this->codigo_turma;
    }

    public function setCodigoTurma($codigo_turmaFront)
    {
        $this->codigo_turma = $codigo_turmaFront;
    }

    public function getCodigoProfessor()
    {
        return $this->codigo_professor;
    }

    public function setCodigoProfessor($codigo_professorFront)
    {
        $this->codigo_professor = $codigo_professorFront;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicioFront)
    {
        $this->dataInicio = $dataInicioFront;
    }

    public function getDataFim()
    {
        return $this->dataFim;
    }

    public function setDataFim($dataFimFront)
    {
        $this->dataFim = $dataFimFront;
    }

    public function getDiaSemana()
    {
        return $this->diaSemana;
    }

    public function setDiaSemana($diaSemanaFront)
    {
        $this->diaSemana = $diaSemanaFront;
    }


    public function inserir()
    {

        $erros = [];
        $sucesso = false;


        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                "dataReserva" => '0',
                "codSala" => '0',
                "codHorario" => '0',
                "codTurma" => '0',
                "codProfessor" => '0'
            ];

            if (VerificaParam($resultado, $lista) !== 1) {
                //Validar se os dados vindos da front estão corretos
                $erros[] = ['codigo' => 99, 'msg' => 'Parametros passados no frontend não correspondem ao metodo.'];
            } else {
                //validar campos
                $retornoDataReserva = VerificaTipo($resultado->dataReserva, 'date', false);
                $retornoCodSala = VerificaTipo($resultado->codSala, 'int', true);
                $retornoCodHorario = VerificaTipo($resultado->codHorario, 'int', true);
                $retornoCodTurma = VerificaTipo($resultado->codTurma, 'int', true);
                $retornoCodProfessor = VerificaTipo($resultado->codProfessor, 'int', true);

                if ($retornoDataReserva['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDataReserva['CodigoHelper'], 'campo' => 'data de reserva', 'msg' => $retornoDataReserva['msg']];
                }
                if ($retornoCodSala['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodSala['CodigoHelper'], 'campo' => 'código da sala', 'msg' => $retornoCodSala['msg']];
                }
                if ($retornoCodHorario['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodHorario['CodigoHelper'], 'campo' => 'código do horário', 'msg' => $retornoCodHorario['msg']];
                }
                if ($retornoCodTurma['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodTurma['CodigoHelper'], 'campo' => 'código da turma', 'msg' => $retornoCodTurma['msg']];
                }
                if ($retornoCodProfessor['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodProfessor['CodigoHelper'], 'campo' => 'código do professor', 'msg' => $retornoCodProfessor['msg']];
                }

                //caso nao tenha erros
                if (empty($erros)) {
                    $this->setDataReserva($resultado->dataReserva);
                    $this->setCodigoSala($resultado->codSala);
                    $this->setCodigoHorario($resultado->codHorario);
                    $this->setCodigoTurma($resultado->codTurma);
                    $this->setCodigoProfessor($resultado->codProfessor);

                    $this->load->model('M_mapa');
                    $resBanco = $this->M_mapa->inserir(
                        $this->getDataReserva(),
                        $this->getCodigoSala(),
                        $this->getCodigoHorario(),
                        $this->getCodigoTurma(),
                        $this->getCodigoProfessor()
                    );
                }

                if ($resBanco['codigo'] == 1) {
                    $sucesso = true;
                } else {
                    $erros[] = ['codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
                }
            }
        } catch (Exception $e) {
            $erros[] = [
                'codigo' => 0,
                'msg' => 'Atenção: O seguinte erro aconteceu -> ' . $e->getMessage()
            ];
        }
        //montando retorno para o front
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //retornando o resultado para o front
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
                "codigo" => '0',
                "dataReserva" => '0',
                "codSala" => '0',
                "codHorario" => '0',
                "codTurma" => '0',
                "codProfessor" => '0'
            ];

            if (VerificaParam($resultado, $lista) !== 1) {
                //Validar se os dados vindos da front estão corretos
                $dados = array(
                    'codigo' => 99,
                    'msg' => 'Parametros passados no frontend não correspondem ao metodo.'
                );
            } else {
                //validar campos
                $retornoCodigo = VerificaConsulta($resultado->codigo, 'int');
                $retornoDataReserva = VerificaConsulta($resultado->dataReserva, 'date');
                $retornoCodSala = VerificaConsulta($resultado->codSala, 'int');
                $retornoCodHorario = VerificaConsulta($resultado->codHorario, 'int');
                $retornoCodTurma = VerificaConsulta($resultado->codTurma, 'int');
                $retornoCodProfessor = VerificaConsulta($resultado->codProfessor, 'int');

                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'código', 'msg' => $retornoCodigo['msg']];
                }
                if ($retornoDataReserva['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDataReserva['CodigoHelper'], 'campo' => 'data de reserva', 'msg' => $retornoDataReserva['msg']];
                }
                if ($retornoCodSala['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodSala['CodigoHelper'], 'campo' => 'código da sala', 'msg' => $retornoCodSala['msg']];
                }
                if ($retornoCodHorario['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodHorario['CodigoHelper'], 'campo' => 'código do horário', 'msg' => $retornoCodHorario['msg']];
                }
                if ($retornoCodTurma['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodTurma['CodigoHelper'], 'campo' => 'código da turma', 'msg' => $retornoCodTurma['msg']];
                }
                if ($retornoCodProfessor['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodProfessor['CodigoHelper'], 'campo' => 'código do professor', 'msg' => $retornoCodProfessor['msg']];
                }

                //caso nao tenha erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);
                    $this->setDataReserva($resultado->dataReserva);
                    $this->setCodigoSala($resultado->codSala);
                    $this->setCodigoHorario($resultado->codHorario);
                    $this->setCodigoTurma($resultado->codTurma);
                    $this->setCodigoProfessor($resultado->codProfessor);

                    $this->load->model('M_mapa');
                    $resBanco = $this->M_mapa->consultar(
                        $this->getCodigo(),
                        $this->getDataReserva(),
                        $this->getCodigoSala(),
                        $this->getCodigoHorario(),
                        $this->getCodigoTurma(),
                        $this->getCodigoProfessor()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros = array(
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        );
                    }
                }
            }
        } catch (Exception $e) {
            $erros = array(
                'codigo' => 0,
                'msg' => 'Atenção: O seguinte erro aconteceu -> ' . $e->getMessage()
            );
        }
        //montando retorno para o front
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg'], 'dados' => $resBanco['dados']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //retornando o resultado para o front
        echo json_encode($retorno);
    }

    public function alterar()
    {
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                "codigo" => '0',
                "dataReserva" => '0',
                "codSala" => '0',
                "codHorario" => '0',
                "codTurma" => '0',
                "codProfessor" => '0'
            ];

            if (VerificaParam($resultado, $lista) !== 1) {
                //Validar se os dados vindos da front estão corretos
                $dados = array(
                    'codigo' => 99,
                    'msg' => 'Parametros passados no frontend não correspondem ao metodo.'
                );
            }else{
                //pelo menos um campo além do código deve ser preenchido para atualizar
                if(trim($resultado->dataReserva) == '' && trim($resultado->codSala) == '' && 
                trim($resultado->codHorario) == '' && trim($resultado->codTurma) == '' && 
                trim($resultado->codProfessor) == ''){
                    $erros[] = ['codigo' => 12, 'msg' => 'Pelo menos um campo deve ser preenchido para atualização.'];
            }else{
                //validar campos
                $retornoCodigo = VerificaTipo($resultado->codigo, 'int', true);
                $retornoDataReserva = VerificaConsulta($resultado->dataReserva, 'date');
                $retornoCodSala = VerificaConsulta($resultado->codSala, 'int');
                $retornoCodHorario = VerificaConsulta($resultado->codHorario, 'int');
                $retornoCodTurma = VerificaConsulta($resultado->codTurma, 'int');
                $retornoCodProfessor = VerificaConsulta($resultado->codProfessor, 'int');

                //verificar se houve erros na validação dos campos
                if ($retornoCodigo['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'código', 'msg' => $retornoCodigo['msg']];
                }
                if ($retornoDataReserva['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoDataReserva['CodigoHelper'], 'campo' => 'data de reserva', 'msg' => $retornoDataReserva['msg']];
                }
                if ($retornoCodSala['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodSala['CodigoHelper'], 'campo' => 'código da sala', 'msg' => $retornoCodSala['msg']];
                }
                if ($retornoCodHorario['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodHorario['CodigoHelper'], 'campo' => 'código do horário', 'msg' => $retornoCodHorario['msg']];
                }
                if ($retornoCodTurma['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodTurma['CodigoHelper'], 'campo' => 'código da turma', 'msg' => $retornoCodTurma['msg']];
                }
                if ($retornoCodProfessor['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoCodProfessor['CodigoHelper'], 'campo' => 'código do professor', 'msg' => $retornoCodProfessor['msg']];
                }

                //se nao houver erros
                if (empty($erros)) {
                    $this->setCodigo($resultado->codigo);
                    $this->setDataReserva($resultado->dataReserva);
                    $this->setCodigoSala($resultado->codSala);
                    $this->setCodigoHorario($resultado->codHorario);
                    $this->setCodigoTurma($resultado->codTurma);
                    $this->setCodigoProfessor($resultado->codProfessor);

                    $this->load->model('M_mapa');
                    $resBanco = $this->M_mapa->alterar(
                        $this->getCodigo(),
                        $this->getDataReserva(),
                        $this->getCodigoSala(),
                        $this->getCodigoHorario(),
                        $this->getCodigoTurma(),
                        $this->getCodigoProfessor()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros = array(
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        );
                    }
                }
            }
        }
        } catch (Exception $e) {
            $erros = array(
                'codigo' => 0,
                'msg' => 'Atenção: O seguinte erro aconteceu -> ' . $e->getMessage()
            );
        }
        //montando retorno para o front
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //retornando o resultado para o front
        echo json_encode($retorno);
    }

    public function desativar(){
            $erros = [];
            $sucesso = false;
    
            try {
                $json = file_get_contents('php://input');
                $resultado = json_decode($json);
                $lista = [
                    "codigo" => '0'
                ];
    
                if (VerificaParam($resultado, $lista) !== 1) {
                    //Validar se os dados vindos da front estão corretos
                    $dados = array(
                        'codigo' => 99,
                        'msg' => 'Parametros passados no frontend não correspondem ao metodo.'
                    );
                } else {
                    //validar campos
                    $retornoCodigo = VerificaTipo($resultado->codigo, 'int', true);
    
                    if ($retornoCodigo['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoCodigo['CodigoHelper'], 'campo' => 'código', 'msg' => $retornoCodigo['msg']];
                    }
    
                    //caso nao tenha erros
                    if (empty($erros)) {
                        $this->setCodigo($resultado->codigo);
    
                        $this->load->model('M_mapa');
                        $resBanco = $this->M_mapa->desativar(
                            $this->getCodigo()
                        );
                        if ($resBanco['codigo'] == 1) {
                            $sucesso = true;
                        } else {
                            $erros = array(
                                'codigo' => $resBanco['codigo'],
                                'msg' => $resBanco['msg']
                            );
                        }
                    }
                }
            } catch (Exception $e) {
                $erros = array(
                    'codigo' => 0,
                    'msg' => 'Atenção: O seguinte erro aconteceu -> ' . $e->getMessage()
                );
            }
            //montando retorno para o front
            if ($sucesso == true) {
                $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
            } else {
                $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
            }
            //retornando o resultado para o front
            echo json_encode($retorno);
    }
}
