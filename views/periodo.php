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

    <title>Periodo</title>
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
        <section class="secao4" id="cadastroPeriodo">
            <div id="btnCadastroModal">
                <input type="text" id="inputPesquisa" class="form-control" placeholder="Pesquisar" onkeyup="filtrarTabela()">
                <button class="btn btn-outline-primary btnAcao modalBtn" id="botaoModal" type="button" data-toggle="modal" data-target="#cadastroPeriodoModal">
                    Cadastrar novo Periodo</button>
            </div>
            <div class="modal fade" id="cadastroPeriodoModal" tabindex="-1" role="dialog" aria-labelledby="cadastroPeriodoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cadastroPeriodoModalLabel">Cadastrar Novo Periodo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formCadastroPeriodo" method="post" class="modal-content">
                            <div class="modal-body">
                                <div class="form-group row">
                                        <label for="descricao" class="col-form-label">Descição</label>
                                        <input type="text" id="descricao" name="descricao" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaIni" class="col-form-label">Horario Inicial</label>
                                        <input type="time" id="horaIni" name="horaIni" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaFim" class="col-form-label">Horario Final</label>
                                        <input type="time" id="horaFim" name="horaFim" class="form-control" required>
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
                            <h5 class="modal-title" id="editModalLabel">Editar Periodo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formEditPeriodo" method="post">
                            <div class="modal-body">
                                <input type="hidden" id="editId" name="editId">
                                <div class="form-group">
                                    <label for="editDescricao">Descricao</label>
                                    <input type="text" id="editDescricao" name="editDescricao" class="form-control" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="editHoraIni">Hora Inicial</label>
                                        <input type="time" name="editHoraIni" id="editHoraIni" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="editHoraFim">Hora Final</label>
                                        <input type="time" name="editHoraFim" id="editHoraFim" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btnAcao" onclick="editarPeriodo();">Salvar</button>
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
                            <th>Codigo</th>
                            <th>Descricao</th>
                            <th>Horario Inicial</th>
                            <th>Horario Final</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="conteudo-periodo">
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
        async function cadastro() {
            event.preventDefault();

            try {
                const descricao = document.getElementById('descricao').value;
                const horaIni = document.getElementById('horaIni').value;
                const horaFim = document.getElementById('horaFim').value;

                const response = await fetch('../Horario/inserir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        descricao: descricao,
                        horaInicial: horaIni,
                        horaFinal: horaFim
                    })
                });
                const result = await response.json();
                console.log('Dados: ', result)
                if (result.sucesso) {
                    $('#cadastroPeriodoModal').modal('hide');
                    Swal.fire('Sucesso!', result.msg, 'success');
                    carregarDados();
                } else {
                    const mensagemDeErro = result.erros.map(erro => {
                        return `<p><strong>[${erro.campo ?? erro.codigo}]</strong> ${erro.msg}</p>`;
                    }).join('');

                    Swal.fire({
                        title: 'Houve(ram) erro(s) de validação: ',
                        html: mensagemDeErro,
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    });
                }

            } catch (error) {
                console.error('Erro ao cadastrar Periodo: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição. ', 'error');
            }
        }

        async function carregarDados() {
            try {
                const response = await fetch('../Horario/consultar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: '',
                        descricao: '',
                        horaInicial: '',
                        horaFinal: ''
                    })
                });
                const result = await response.json();
                const conteudoAcesso = document.getElementById('conteudo-periodo');

                conteudoAcesso.innerHTML = '';

                if (!result.sucesso || !result.dados || result.dados.length === 0) {
                    conteudoAcesso.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado.</td></tr>';
                    return;
                }

                result.dados.forEach(item => {

                    conteudoAcesso.innerHTML += `
            <tr class="alert alert-warning">
                <td>${item.codigo}</td>
                <td>${item.descricao}</td>
                <td>${item.hora_ini}</td>
                <td>${item.hora_fim}</td>
                <td>
                    <div class="row">
                    <button class="btn btn-warning btnAcao" onclick="openEditModal(this)">
                        <i class="fas fa-pencil"></i>
                    </button>
                    <button class="btn btn-danger btnAcao btnAcaoExcluir" onclick="deletarPeriodo(${item.codigo})">
                        <i class="fas fa-trash"></i>
                    </button>
                    </div>
                </td>
            </tr>
            `;
                });

            } catch (error) {
                console.error('Erro ao carregar os dados: ', error);
            }
        }

        $(document).ready(function() {
            carregarDados();

            $('#cadastroPeriodoModal').on('show.bs.modal', function() {
                $('#formCadastroPeriodo')[0].reset();
            });
        });


        function openEditModal(button) {
            const row = button.closest('tr');

            const codigo = row.cells[0].innerText;
            const descricao = row.cells[1].innerText;
            const horaIni = row.cells[2].innerText;
            const horaFim = row.cells[3].innerText;

            document.getElementById('editId').value = codigo;
            document.getElementById('editDescricao').value = descricao;
            document.getElementById('editHoraIni').value = horaIni;
            document.getElementById('editHoraFim').value = horaFim;

            $('#editModal').modal('show');
        }

        async function editarPeriodo() {
            event.preventDefault();
            try {
                const codigo = document.getElementById('editId').value;
                const descricao = document.getElementById('editDescricao').value;
                const horaIni = document.getElementById('editHoraIni').value;
                const horaFim = document.getElementById('editHoraFim').value;

                const response = await fetch('../Horario/alterar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: codigo,
                        descricao: descricao,
                        horaInicial: horaIni.slice(0,5),
                        horaFinal: horaFim.slice(0,5)
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
                $('#cadastroPeriodoModal').modal('hide');
                carregarDados(); //atualizar a tabela
            } catch (error) {
                console.error('Erro ao editar a sala: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }


        async function deletarPeriodo(codigo) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Tem certeza que deseja remover esse periodo?',
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    html: 'my-swal-text',
                    confirmButton: 'btn btn-danger btnAcao my-swal-button',
                    cancelButton: 'btn btn-secondary btnAcao my-swal-button'
                },
                buttonsStyling: false,
            }).then(async function(res) {
                if (res.isConfirmed) {
                    const config = {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            codigo: codigo
                        })
                    };
                    const request = await fetch('../Horario/desativar', config);
                    const response = await request.json();

                    Swal.fire({
                        title: 'Atenção!',
                        text: response.msg,
                        icon: response.sucesso ? 'success' : 'error',
                        customClass: {
                            popup: 'my-swal-popup',
                            title: 'my-swal-title',
                            html: 'my-swal-text',
                            confirmButton: 'btn btn-primary btnAcao'
                        },
                        buttonsStyling: false
                    });
                    carregarDados();
                }
            });
        }


        function filtrarTabela() {
            const input = document.getElementById('inputPesquisa');
            const filter = input.value.toLowerCase();
            const tabela = document.getElementById('conteudo-periodo');
            const linhas = tabela.getElementsByTagName('tr');

            for (let i = 0; i < linhas.length; i++) {
                const colDescricao = linhas[i].getElementsByTagName("td")[1];
                const colHoraIni = linhas[i].getElementsByTagName("td")[2];
                const colHoraFim = linhas[i].getElementsByTagName("td")[3];

                if (colDescricao) {
                    const descricaoTexto = colDescricao.textContent || colDescricao.innerText;
                    const hrIniTexto = colHoraIni.textContent || colHoraIni.innerText;
                    const hrFimTexto = colHoraFim.textContent || colHoraFim.innerText;

                    if ((descricaoTexto.toLowerCase().indexOf(filter) > -1) || (hrIniTexto.toLocaleLowerCase().indexOf(filter) > -1) ||
                        (hrFimTexto.toLowerCase().indexOf(filter) > -1)) {
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