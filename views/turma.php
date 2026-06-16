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

    <title>Turma</title>
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
        <section class="secao4" id="cadastroTurma">
            <div id="btnCadastroModal">
                <input type="text" id="inputPesquisa" class="form-control" placeholder="Pesquisar" onkeyup="filtrarTabela()">
                <button class="btn btn-outline-primary btnAcao modalBtn" id="botaoModal" type="button" data-toggle="modal" data-target="#cadastroTurmaModal">
                    Cadastrar novo docente</button>
            </div>
            <div class="modal fade" id="cadastroTurmaModal" tabindex="-1" role="dialog" aria-labelledby="cadastroTurmaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cadastroTurmaModalLabel">Cadastrar Nova Turma</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formCadastroTurma" method="post" class="modal-content">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="descricao" class="col-form-label">Descrição</label>
                                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="capacidade" class="col-form-label">Capacidade</label>
                                    <input type="number" id="capacidade" name="capacidade" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="descricao" class="col-form-label">Data de Inicio</label>
                                    <input type="date" id="dataInicio" name="dataInicio" class="form-control" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btnAcao" onclick="cadastro();">Cadastrar</button>
                                </div>
                            </div>
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
                            <h5 class="modal-title" id="editModalLabel">Editar Turma</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formEditTurma" method="post">
                            <div class="modal-body">
                                <input type="hidden" id="editId" name="editId">
                                <div class="form-group">
                                    <label for="editDescricao">Descrição</label>
                                    <input type="text" id="editDescricao" name="editDescricao" class="form-control" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="editCapacidade" class="col-form-label">Capacidade</label>
                                        <input type="number" name="editCapacidade" id="editCapacidade" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-6">
                                            <label for="editDataInicio" class="col-form-label">Data de Inicio</label>
                                            <input type="date" name="editDataInicio" id="editDataInicio" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btnAcao" onclick="editarTurma();">Salvar</button>
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
                            <th>Turma</th>
                            <th>Descricao</th>
                            <th>Capacidade</th>
                            <th>Data de Inicio</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="conteudo-turma">
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
            const codigo = row.cells[0].innerText;
            const descricao = row.cells[1].innerText;
            const capacidade = row.cells[2].innerText;
            const dataInicio = row.cells[4].innerText; //pulando 1 celula aqui pq tem 2 data inicio e vamos usar especificamente essa

            document.getElementById('editId').value = codigo;
            document.getElementById('editDescricao').value = descricao;
            document.getElementById('editCapacidade').value = capacidade;
            document.getElementById('editDataInicio').value = dataInicio;

            //abre o modal
            $('#editModal').modal('show');
        }

        async function carregarDados() {
            try {

                const response = await fetch('../Turma/consultar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: '',
                        descricao: '',
                        capacidade: '',
                        dataInicio: ''
                    })
                });

                const result = await response.json();
                const conteudoAcesso = document.getElementById('conteudo-turma');

                conteudoAcesso.innerHTML = '';

                //preencher com os dados recebidos
                if (!result.sucesso || !result.dados || result.dados.length === 0) {
                    conteudoAcesso.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado.</td></tr>';
                    return;
                }
                console.log(result);
                result.dados.forEach(item => {
                    conteudoAcesso.innerHTML += `<tr class="alert alert-warning">
                    <td>${item.codigo}</td>
                    <td>${item.descricao}</td>
                    <td>${item.capacidade}</td>
                    <td>${item.dataIniciobra}</td>
                    <td style="display: none;">${item.dataInicio}</td>
                    <td>
                        <div class="row">
                            <button class="btn btn-warning btnAcao" onclick="openEditModal(this)">
                                <i class="fas fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btnAcao btnAcaoExcluir" onclick="deletarTurma(${item.codigo})">
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
                const descricao = document.getElementById('descricao').value;
                const capacidade = document.getElementById('capacidade').value;
                const dataInicio = document.getElementById('dataInicio').value;

                const response = await fetch('../Turma/inserir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        descricao: descricao,
                        capacidade: capacidade,
                        dataInicio: dataInicio
                    })
                });
                const result = await response.json();

                if (result.sucesso == true) {
                    //fecha o modal
                    $('#cadastroTurmaModal').modal('hide');

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
                console.error('Erro ao cadastrar a turma: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        $(document).ready(function() {
            carregarDados();
            $('#cadastroTurmaModal').on('show.bs.modal', function() {
                $('#formCadastroTurma')[0].reset();
            });
        });

        async function editarTurma() {
            event.preventDefault();
            try {
                const codigo = document.getElementById('editId').value;
                const descricao = document.getElementById('editDescricao').value;
                const capacidade = document.getElementById('editCapacidade').value;
                const dataInicio = document.getElementById('editDataInicio').value;

                const response = await fetch('../Turma/alterar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: codigo,
                        descricao: descricao,
                        capacidade: capacidade,
                        dataInicio: dataInicio
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
                        html: mensagensErro, //por causa dessa propriedade, vai poder exibir as tags <strong> e <p>
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    })
                }
                $('#cadastroTurmaModal').modal('hide');
                carregarDados(); //atualizar a tabela
            } catch (error) {
                console.error('Erro ao editar a sala: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        async function deletarTurma(codigo) {
            Swal.fire({
                title: 'Ateção',
                text: 'Tem certeza que deseja excluir essa turma?',
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
                    const request = await fetch('../Turma/desativar', config);
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
            const tabela = document.getElementById("conteudo-turma");
            const linhas = tabela.getElementsByTagName("tr");

            for (let i = 0; i < linhas.length; i++) {
                const colDescricao = linhas[i].getElementsByTagName("td")[1];
                const colCapacidade = linhas[i].getElementsByTagName("td")[2];
                const colDataIni = linhas[i].getElementsByTagName("td")[3];

                //verifica se o filtro corresponde ao numero de sala ou à descrição
                if (colDescricao) {
                    const descricaoTexto = colDescricao.textContent || colDescricao.innerText;
                    const capacidadeTexto = colCapacidade.textContent || colCapacidade.innerText;
                    const dataIniTexto = colDataIni.textContent || colDataIni.innerText;

                    if ((descricaoTexto.toLowerCase().indexOf(filter) > -1) ||
                        (capacidadeTexto.toLowerCase().indexOf(filter) > -1) ||
                        (dataIniTexto.toLowerCase().indexOf(filter) > -1)) {
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