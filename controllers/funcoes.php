<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcoes extends CI_Controller{
    public function index(){
        $this->load->view('login');
    }

    public function indexPagina(){
        $this->load->view('index');
    }
    //para redirecionar de volta a pagina de login
    public function encerraSistema(){
        header('Location: ' . base_url());
    }

    public function abreSala(){
        $this->load->view('sala');
    }

    public function abreProfessor(){
        $this->load->view('professor');
    }

    public function abreTurma(){
        $this->load->view('turma');
    }

    public function abrePeriodo(){
        $this->load->view('periodo');
    }
}