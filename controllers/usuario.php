<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
{

    private $idUsuario;
    private $nome;
    private $email;
    private $usuario;
    private $senha;

    //GETTERS
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    //SETTERS
    public function setIdUsuario($idUsuarioFront)
    {
        $this->idUsuario = $idUsuarioFront;
    }

    public function setNome($nomeFront)
    {
        $this->nome = $nomeFront;
    }

    public function setEmail($emailFront)
    {
        $this->email = $emailFront;
    }

    public function setUsuario($usuarioFront)
    {
        $this->usuario = $usuarioFront;
    }

    public function setSenha($senhaFront)
    {
        $this->senha = $senhaFront;
    }

    public function inserir()
    {
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                "nome" => '0',
                "email" => '0',
                "usuario" => '0',
                "senha" => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //verifica os dados passados do front com os campos esperados
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos no FrontEnd'];
            } else {
                $retornoNome = VerificaTipo($resultado->nome, 'string', true);
                $retornoEmail = VerificaTipo($resultado->email, 'email', true);
                $retornoUsuario = VerificaTipo($resultado->usuario, 'string', true);
                $retornoSenha = VerificaTipo($resultado->senha, 'string', true);
            
            if ($retornoNome['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoNome['CodigoHelper'], 'campo' => 'nome', 'msg' => $retornoNome['msg']];
            }
            if ($retornoEmail['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoEmail['CodigoHelper'], 'campo' => 'email', 'msg' => $retornoEmail['msg']];
            }
            if ($retornoUsuario['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoUsuario['CodigoHelper'], 'campo' => 'usuario', 'msg' => $retornoUsuario['msg']];
            }
            if ($retornoSenha['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoSenha['CodigoHelper'], 'campo' => 'senha', 'msg' => $retornoSenha['msg']];
            }

            //caso nao tenha nenhum erro
            if (empty($erros)) {
                $this->setNome($resultado->nome);
                $this->setEmail($resultado->email);
                $this->setUsuario($resultado->usuario);
                $this->setSenha($resultado->senha);

                //carregando o model de professor para inserir os dados no banco
                $this->load->model('M_usuario');
                $resBanco = $this->M_usuario->inserir($this->getNome(), $this->getEmail(), $this->getUsuario(), $this->getSenha());
                if ($resBanco['codigo'] == 1) {
                    $sucesso = true;
                } else {
                    $erros[] = array(
                        'codigo' => $resBanco['codigo'],
                        'msg' => $resBanco['msg']
                    );
                }
            }
        }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro Inesperado: ' . $e->getMessage()];
        }
        //montando retorno para o front        
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //mandando o retorno para o front em formato json
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
                "nome" => '0',
                "email" => '0',
                "usuario" => '0'
            ];
            if (VerificaParam($resultado, $lista) != 1) {
                //verifica os dados passados do front com os campos esperados
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos no FrontEnd'];
            } else {
                $retornoNome = VerificaConsulta($resultado->nome, 'string');
                $retornoEmail = VerificaConsulta($resultado->email, 'email');
                $retornoUsuario = VerificaConsulta($resultado->usuario, 'string');

            if ($retornoNome['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoNome['CodigoHelper'], 'campo' => 'nome', 'msg' => $retornoNome['msg']];
            }
            if ($retornoEmail['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoEmail['CodigoHelper'], 'campo' => 'email', 'msg' => $retornoEmail['msg']];
            }
            if ($retornoUsuario['CodigoHelper'] != 0) {
                $erros[] = ['codigo' => $retornoUsuario['CodigoHelper'], 'campo' => 'usuario', 'msg' => $retornoUsuario['msg']];
            }

            //caso nao tenha nenhum erro
            if (empty($erros)) {
                $this->setNome($resultado->nome);
                $this->setEmail($resultado->email);
                $this->setUsuario($resultado->usuario);

                //carregando o model de professor para consultar os dados no banco
                $this->load->model('M_usuario');
                $resBanco = $this->M_usuario->consultar(
                    $this->getNome(),
                    $this->getEmail(),
                    $this->getUsuario()
                );
                if ($resBanco['codigo'] == 1) {
                    $sucesso = true;
                } else {
                    $erros[] = array(
                        'codigo' => $resBanco['codigo'],
                        'msg' => $resBanco['msg']
                    );
                }
            }
        }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro Inesperado: ' . $e->getMessage()];
        }
        //montando retorno para o front        
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg'], 'dados' => $resBanco['dados']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //mandando o retorno para o front em formato json
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
                "idUsuario" => '0',
                "nome" => '0',
                "email" => '0',
                "senha" => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //verifica os dados passados do front com os campos esperados
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos no FrontEnd'];
            } else {
                if (trim($resultado->nome) == '' && trim($resultado->email) == '' && trim($resultado->senha) == '') {
                    $erros[] = ['codigo' => 12, 'msg' => 'Pelo menos um campo deve ser preenchido para alteração'];
                } else {
                    $retornoIdUsuario = VerificaTipo($resultado->idUsuario, 'int', true);
                    $retornoNome = VerificaConsulta($resultado->nome, 'string');
                    $retornoEmail = VerificaConsulta($resultado->email, 'email');
                    $retornoSenha = VerificaConsulta($resultado->senha, 'string');

                    if ($retornoIdUsuario['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoIdUsuario['CodigoHelper'], 'campo' => 'idUsuario', 'msg' => $retornoIdUsuario['msg']];
                    }
                    if ($retornoNome['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoNome['CodigoHelper'], 'campo' => 'nome', 'msg' => $retornoNome['msg']];
                    }
                    if ($retornoEmail['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoEmail['CodigoHelper'], 'campo' => 'email', 'msg' => $retornoEmail['msg']];
                    }
                    if ($retornoSenha['CodigoHelper'] != 0) {
                        $erros[] = ['codigo' => $retornoSenha['CodigoHelper'], 'campo' => 'senha', 'msg' => $retornoSenha['msg']];
                    }

                    //caso nao tenha nenhum erro
                    if (empty($erros)) {
                        $this->setIdUsuario($resultado->idUsuario);
                        $this->setNome($resultado->nome);
                        $this->setEmail($resultado->email);
                        $this->setSenha($resultado->senha);

                        //carregando o model de professor para alterar os dados no banco
                        $this->load->model('M_usuario');
                        $resBanco = $this->M_usuario->alterar(
                            $this->getIdUsuario(),
                            $this->getNome(),
                            $this->getEmail(),
                            $this->getSenha()
                        );
                        if ($resBanco['codigo'] == 1) {
                            $sucesso = true;
                        } else {
                            $erros[] = array(
                                'codigo' => $resBanco['codigo'],
                                'msg' => $resBanco['msg']
                            );
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro Inesperado: ' . $e->getMessage()];
        }
        //montando retorno para o front        
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //mandando o retorno para o front em formato json
        echo json_encode($retorno);
    }

    public function desativar(){
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $lista = array(
                "idUsuario" => '0'
            );

            if (VerificaParam($resultado, $lista) != 1) {
                //verifica os dados passados do front com os campos esperados
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos no FrontEnd'];
            } else {
                $retornoIdUsuario = VerificaTipo($resultado->idUsuario, 'int', true);

                if ($retornoIdUsuario['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoIdUsuario['CodigoHelper'], 'campo' => 'idUsuario', 'msg' => $retornoIdUsuario['msg']];
                }

                //caso nao tenha nenhum erro
                if (empty($erros)) {
                    $this->setIdUsuario($resultado->idUsuario);

                    //carregando o model de professor para desativar os dados no banco
                    $this->load->model('M_usuario');
                    $resBanco = $this->M_usuario->desativar(
                        $this->getIdUsuario()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros[] = array(
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        );
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro Inesperado: ' . $e->getMessage()];
        }
        //montando retorno para o front        
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //mandando o retorno para o front em formato json
        echo json_encode($retorno);
    }

    public function logar()
    {
        //Usuario e senha recebios via JSON
        $erros = [];
        $sucesso = false;

        try {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);
            $lista = [
                "usuario" => '0',
                "senha" => '0'
            ];

            if (VerificaParam($resultado, $lista) != 1) {
                //verifica os dados passados do front com os campos esperados
                $erros[] = ['codigo' => 99, 'msg' => 'Campos inexistentes ou incorretos no FrontEnd'];
            } else {
                $retornoUsuario = VerificaTipo($resultado->usuario, 'string', true);
                $retornoSenha = VerificaTipo($resultado->senha, 'string', true);
                if ($retornoUsuario['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoUsuario['CodigoHelper'], 'campo' => 'usuario', 'msg' => $retornoUsuario['msg']];
                }
                if ($retornoSenha['CodigoHelper'] != 0) {
                    $erros[] = ['codigo' => $retornoSenha['CodigoHelper'], 'campo' => 'senha', 'msg' => $retornoSenha['msg']];
                }

                //caso nao tenha nenhum erro
                if (empty($erros)) {
                    $this->setUsuario($resultado->usuario);
                    $this->setSenha($resultado->senha);

                    //carregando o model de professor para consultar os dados no banco
                    $this->load->model('M_usuario');
                    $resBanco = $this->M_usuario->validaLogin(
                        $this->getUsuario(),
                        $this->getSenha()
                    );
                    if ($resBanco['codigo'] == 1) {
                        $sucesso = true;
                    } else {
                        $erros[] = array(
                            'codigo' => $resBanco['codigo'],
                            'msg' => $resBanco['msg']
                        );
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = ['codigo' => 0, 'msg' => 'Erro Inesperado: ' . $e->getMessage()];
        }
        //montando retorno para o front        
        if ($sucesso == true) {
            $retorno = ['sucesso' => $sucesso, 'codigo' => $resBanco['codigo'], 'msg' => $resBanco['msg']];
        } else {
            $retorno = ['sucesso' => $sucesso, 'erros' => $erros];
        }
        //mandando o retorno para o front em formato json
        echo json_encode($retorno);
    }
}
