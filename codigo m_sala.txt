<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sala extends CI_Model{
/* 
Lista de validações de retornos (codigo de erro)
0 - Erro de exceção
1 - Operação realizada no banco de dados com sucesso
8 - Houve algum problema com a ação (Inserir, atualizar, consultar ou excluir)
9 - Sala desativada no sistema
10 - Sala já cadastrada
98 - Método auxiliar de consulta que não trouxe dados
*/

//Metodo Auxiliar para essa classe
private function ConsultaSala($codigo){
try{
    //Query para consultar se o codigo da sala já existe
    $sql = "select * from tbl_sala where codigo = $codigo ";

    $retornoSala = $this->db->query($sql);

    //Verifica se a consulta funcionou
    if($retornoSala->num_rows() > 0){
        $linha = $retornoSala->row();
    if(trim($linha->estatus) == "D"){
        $dados = array(
            'codigo' => 9,
            'msg' => 'Sala desativada, caso precise, chame um administrador'
        );
    }else{
        $dados = array(
            'codigo' => 10,
            'msg' => 'Sala já cadastrada'
        );
    }
    } else{
        $dados = array(
            'codigo' => 98,
            'msg' => 'sala não encontrada'
        );
    }
} catch(Exception $e){
    $dados = array(
        'codigo' => 0,
        'msg' => 'Atenção, um erros ocorreu: ' . $e->getMessage()
    );
}
return $dados;
}
public function inserir ($codigo, $descricao, $andar, $capacidade){
    try{
        //Verificar se a sala ja esta cadastrada
        $retornoConsulta = $this->ConsultaSala($codigo);
        if($retornoConsulta['codigo'] !=9 &&
           $retornoConsulta['codigo'] != 10){
            //Query para inserir dados
                $this->db->query("insert into tbl_sala (codigo, descricao, andar, capacidade) values ($codigo, '$descricao', $andar, $capacidade)");
                //verificar se deu tudo certo
                if($this->db->affected_rows()>0){
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Sala cadastrada com sucesso'
                    );
                }else{
                    $dados = array(
                        'codigo' => 8,
                        'msg' => 'Erro ao inserir na tabela SALAS'
                    );
                }
           }else{
            $dados = array(
                'codigo' => $retornoConsulta['codigo'],
                'msg' => $retornoConsulta['msg']);
           }
    } catch(Exception $e){
        $dados = array(
            'codigo' => 0,
            'msg' => 'Atenção, o seguinte erro aconteceu: ' . $e->getMessage()
        
            );
    }
    return $dados;
}
}

?>
