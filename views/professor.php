<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styleCadastro.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>

    <title>Docente</title>
    <link rel="icon" href="../../fatecsrdsii202502/assets/img/icone_fatecSR.ico" type="image/x-icon">
    <style>
        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: space-around;
        }

        .nav-item {
            flex-grow: 1;
            text-align: center;
        }

        .nav-link {
            display: block;
            color: #ffffff !important;
            font-weight: bold;
            padding: 0px;
        }

        .nav-link:hover {
            background-color: #44444e;
        }
    </style>
</head>

<body>
    <header>
        <div id="headerMenu">
            <a href="../Funcoes/indexPagina">
                <h1 id="headerTitle">Mapeamento de Salas</h1>
            </a>

            <nav class="navbar navbar-expand-lg navbar-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abreSala">Sala de Aula</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abreProfessor">Docente</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abreTurma">Turma</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abrePeriodo">Periodo</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abreMapa">Reservas</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Funcoes/abreRelatorio">Relatorio</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="secao4" id="cadastroProfessor">
            <div id="btnCadastroModal">
                <input type="text" id="inputPesquisa" class="form-control" placeholder="Pesquisar" onkeyup="filtrarTabela()">
                <button class="btn btn-outline-primary btnAcao modalBtn" id="botaoModal" type="button" data-toggle="modal" data-target="#cadastroProfessorModal">
                    Cadastrar novo docente</button>
            </div>
            <div class="modal fade" id="cadastroProfessorModal" tabindex="-1" role="dialog" aria-labelledby="cadastroProfessorModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cadastroProfessorModalLabel">Cadastrar Novo Docente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formCadastroProfessor" method="post" class="modal-content">
                            <div class="modal-body">
                                <div class="form-group row">
                                        <label for="nome" class="col-form-label">Nome</label>
                                        <input type="text" id="nome" name="nome" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="cpd" class="col-form-label">CPF</label>
                                        <input type="number" id="cpf" name="cpf" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="tipo" class="col-form-label">Tipo</label>
                                        <select name="tipo" id="tipo" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="F">Funcionário</option>
                                            <option value="C">Carta Convite</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btnAcao" onclick="cadastro();">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal de Edição -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Professor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formEditProfessor" method="post">
                            <div class="modal-body">
                                <input type="hidden" id="editId" name="editId">
                                <div class="form-group">
                                    <label for="editDNome">Nome</label>
                                    <input type="text" id="editNome" name="editNome" class="form-control" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="editCpf">CPF</label>
                                        <input type="number" name="editCpf" id="editCpf" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="editTipo" class="col-form-label">Tipo</label>
                                        <select name="editTipo" id="editTipo" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="F">Funcionário</option>
                                            <option value="C">Carta Convite</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btnAcao" onclick="editarProfessor();">Salvar</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section id="mostrarCadastro">
            <div class="table-responsive tabela-scroll">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Professor</th>
                            <th>CPF</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="conteudo-professor">
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <!-- Apenas para seguir o estilo css já definido para uma aparencia corrente-->
    </footer>
    <script src="../../ds2mf/assets/js/jquery-3.6.0.min.js"></script>
    <script src="../../ds2mf/assets/js/bootstrap.min.js"></script>
    <script src="../../ds2mf/assets/js/sweetalert2.all.min.js"></script>

    <script>
        function openEditModal(button) {
            //Linha do botão clicado
            const row = button.closest('tr');
            //pegaos dados da linha
            const nome = row.cells[0].innerText;
            const cpf = row.cells[1].innerText;
            const tipo = row.cells[2].innerText.charAt(0);
            document.getElementById('editId').value = codigo;
            document.getElementById('editNome').value = nome;
            document.getElementById('editCpf').value = cpf;
            document.getElementById('editTipo').value = tipo;

            //abre o modal
            $('#editModal').modal('show');
        }

        async function carregarDados() {
            try {

                const response = await fetch('../Professor/consultar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: '',
                        nome: '',
                        cpf: '',
                        tipo: ''
                    })
                });

                const result = await response.json();
                const conteudoAcesso = document.getElementById('conteudo-professor');

                conteudoAcesso.innerHTML = '';

                //preencher com os dados recebidos
                if (!result.sucesso || !result.dados || result.dados.length === 0) {
                    conteudoAcesso.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado.</td></tr>';
                    return;
                }
                console.log(result);
                result.dados.forEach(item => {
                    tipo = item.tipo;
                    if (tipo == 'F') {
                        tipo = 'Funcionario';
                    } else {
                        tipo = 'Carta Convite'
                    }
                    codigo = item.codigo;
                    conteudoAcesso.innerHTML += `<tr class="alert alert-warning">
                    <td>${item.nome}</td>
                    <td>${item.cpf}</td>
                    <td>${tipo}</td>
                    <td>
                        <div class="row">
                            <button class="btn btn-warning btnAcao" onclick="openEditModal(this)">
                                <i class="fas fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btnAcao btnAcaoExcluir" onclick="deletarProfessor(${item.codigo})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                    </tr>`;
                })

            } catch (erro) {
                console.error('Erro ao carregar dados: ', erro)
            }
        }


        async function cadastro() {
            event.preventDefault();
            try {
                const nome = document.getElementById('nome').value;
                const cpf = document.getElementById('cpf').value;
                const tipo = document.getElementById('tipo').value;

                const response = await fetch('../Professor/inserir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nome: nome,
                        cpf: cpf,
                        tipo: tipo
                    })
                });
                const result = await response.json();

                if (result.sucesso == true) {
                    //fecha o modal
                    $('#cadsatroProfessorModal').modal('hide');

                    //Mostrar uma mensagem de sucesso
                    Swal.fire('Sucesso!', result.msg, 'success');
                    //Atualizar a tabela
                    carregarDados();
                } else {
                    //aqui entra em caso de erro
                    //começa juntando todas as mensagens de erro e mapeia em um bloco HTML
                    const mensagensErro = result.erros.map(erro => {
                        return `<p><strong>[${erro.campo ?? erro.codigo}]</strong> ${erro.msg}</p>`;
                    }).join('');

                    Swal.fire({
                        title: 'Houve(ram) erro(s) de validação:',
                        html: mensagensErro, //por causa dessa propriedade, vai poder exibir as tags <strong> e <p>
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    })
                }

            } catch (error) {
                console.error('Erro ao cadastrar o professor: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        $(document).ready(function() {
            carregarDados();
            $('#cadastroProfessorModal').on('show.bs.modal', function() {
                $('#formCadastroProfessor')[0].reset();
            });
        });

        async function editarProfessor() {
            event.preventDefault();
            try {
                const codigo = document.getElementById('editId').value;
                const nome = document.getElementById('editNome').value;
                const cpf = document.getElementById('editCpf').value;
                const tipo = document.getElementById('editTipo').value;

                const response = await fetch('../Professor/alterar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: codigo,
                        nome: nome,
                        cpf: cpf,
                        tipo: tipo
                    })
                });
                const result = await response.json();
                if (result.codigo == 1) {
                    //fecha o modal
                    $('#editModal').modal('hide');

                    //Mostrar uma mensagem de sucesso
                    Swal.fire('Sucesso!', result.msg, 'success');
                    //Atualizar a tabela
                    carregarDados();
                } else {
                    //aqui entra em caso de erro
                    //começa juntando todas as mensagens de erro e mapeia em um bloco HTML
                    const mensagensErro = result.erro.map(erro => {
                        return `<p><strong>[${erro.campo ?? erro.codigo}]</strong> ${erro.msg}</p>`;
                    }).join('');

                    Swal.fire({
                        title: 'Houve(ram) erro(s) de validação:',
                        html: mensagensDeErro, //por causa dessa propriedade, vai poder exibir as tags <strong> e <p>
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    })
                }
                $('#cadastroProfessorModal').modal('hide');
                carregarDados(); //atualizar a tabela
            } catch (error) {
                console.error('Erro ao editar a sala: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        async function deletarProfessor(codigo) {
            Swal.fire({
                title: 'Ateção',
                text: 'Tem certeza que deseja excluir esse professor?',
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    html: 'my-swal-text',
                    confirmButton: 'btn btn-danger btnAcao my-swal-button',
                    cancelButton: 'btn btn-secondary btnAcao my-swal-butotn',
                },
                buttonStyling: false
            }).then(async function(res) {
                if (res.isConfirmed) {
                    const config = {
                        method: 'post',
                        body: JSON.stringify({
                            codigo: codigo
                        })
                    };
                    const request = await fetch('../Professor/desativar', config);
                    const response = await request.json();

                    Swal.fire({
                        title: 'Atenção!',
                        text: response.msg,
                        icon: response.codigo == 1 ? 'success' : 'error',
                        customClass: {
                            popup: 'my-swal-popup',
                            title: 'my-swal-title',
                            html: 'my-swal-text',
                            confirmButton: 'btn btn-primary btnAcao',
                        },
                        buttonStyling: false
                    });
                    carregarDados();
                }
            })
        }

        function filtrarTabela() {
            const input = document.getElementById("inputPesquisa");
            const filter = input.value.toLowerCase();
            const tabela = document.getElementById("conteudo-professor");
            const linhas = tabela.getElementsByTagName("tr");

            for (let i = 0; i < linhas.length; i++) {
                const colProfessor = linhas[i].getElementsByTagName("td")[0];
                const colCpf = linhas[i].getElementsByTagName("td")[1];
                const colTipo = linhas[i].getElementsByTagName("td")[2];

                //verifica se o filtro corresponde ao numero de sala ou à descrição
                if (colProfessor) {
                    const professorTexto = colProfessor.textContent || colProfessor.innerText;
                    const tipoTexto = colTipo.textContent || colTipo.innerText;
                    const cpfTexto = colCpf.textContent || colCpf.innerText;

                    if (professorTexto.toLowerCase().indexOf(filter) > 1 || (tipoTexto.toLowerCase().indexOf(filter) > -1)) {
                        linhas[i].style.display = "";
                    } else {
                        linhas[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>