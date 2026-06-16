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

    <title>Sala</title>
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
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abreSala">Sala de Aula</a></li>
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abreProfessor">Docente</a></li>
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abreTurma">Turma</a></li>
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abrePeriodo">Periodo</a></li>
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abreMapa">Reservas</a></li>
                        <li class="nav-item"><a class="nav-link" href="../funcoes/abreRelatorio">Relatorio</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="secao4" id="cadastroSala">
            <div id="btnCadastroModal" style="display:flex; gap:10px; align-items:center;">
                <input type="text" id="inputPesquisa" class="form-control" placeholder="Pesquisar" onkeyup="filtrarTabela()">
                <button class="btn btn-outline-primary btnAcao modalBtn" id="botaoModal" type="button" data-toggle="modal" data-target="#cadastroSalaModal">
                    Cadastrar nova Sala</button>
            </div>
            <div class="modal fade" id="cadastroSalaModal" tabindex="-1" role="dialog" aria-labelledby="cadastroSalaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cadastroSalaModalLabel">Cadastrar Nova Sala</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formCadastroSala" method="post" class="modal-content">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="codigo" class="col-form-label">Número</label>
                                        <input type="number" id="codigo" name="codigo" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="andar" class="col-form-label">Andar</label>
                                        <select name="andar" id="andar" class="form-control" required>
                                            <option value="selecione">Selecione</option>
                                            <option value="9">Térreo</option>
                                            <option value="1">Primeiro</option>
                                            <option value="2">Segundo</option>
                                            <option value="3">Terceiro</option>
                                            <option value="4">Quarto</option>
                                            <option value="5">Quinto</option>
                                            <option value="6">Sexto</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="capacidade" class="col-form-label">Capacidade</label>
                                        <input type="number" id="capacidade" name="capacidade" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" id="descricao" name="descricao" class="form-control" required>
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
                            <h5 class="modal-title" id="editModalLabel">Editar Sala</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formEditSala" method="post">
                            <div class="modal-body">
                                <input type="hidden" id="editId" name="editId">
                                <div class="form-group">
                                    <label for="editDescricao">Descrição</label>
                                    <input type="text" id="editDescricao" name="descricao" class="form-control" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="editAndar">Andar</label>
                                        <select name="andar" id="editAndar" class="form-control" required>
                                            <option value="selecione">Selecione</option>
                                            <option value="9">Térreo</option>
                                            <option value="1">Primeiro</option>
                                            <option value="2">Segundo</option>
                                            <option value="3">Terceiro</option>
                                            <option value="4">Quarto</option>
                                            <option value="5">Quinto</option>
                                            <option value="6">Sexto</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="editCapacidade" class="col-form-label">Capacidade</label>
                                        <input type="number" id="editCapacidade" name="editCapacidade" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btnAcao" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btnAcao" onclick="editarSala();">Salvar</button>
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
                            <th>Sala</th>
                            <th>Descrição</th>
                            <th>Andar</th>
                            <th>Capacidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="conteudo-sala">
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
        function openEditModal(button){
            //Linha do botão clicado
            const row = button.closest('tr');
            //pegaos dados da linha
            const codigo = row.cells[0].innerText; //Pega o codigo da sala na celula 0 da linha -- lembrando que na programação o 0 é a primeira posição em listas, por isso é celular 0
            const descricao = row.cells[1].innerText; //Pega a descrição da sala na celula 1 da linha 
            const andar = row.cells[2].innerText; //Pega o andar da sala na celula 2 da linha 
            const capacidade = row.cells[3].innerText; //Pega a capacidade da sala na celula 3 da linha 
            //Preenche o modal com os dados coletados da sala
            document.getElementById('editId').value = codigo;
            document.getElementById('editDescricao').value = descricao;
            document.getElementById('editAndar').value = andar;
            document.getElementById('editCapacidade').value = capacidade;

            //abre o modal
            $('#editModal').modal('show');
        }

        async function carregarDados() {
            try {

                const response = await fetch('../Sala/consultar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: '',
                        descricao: '',
                        andar: '',
                        capacidade: ''
                    })
                });
                const result = await response.json();

                const conteudoAcesso = document.getElementById('conteudo-sala');
                //Limpa a tabela com os dados antigos para inserir dados novos
                conteudoAcesso.innerHTML = '';
                //verificando se à, pelo menos, 1 registro para tentar usar o foreach
                if (!result.sucesso || !result.dados || result.dados.length === 0) {
                    conteudoAcesso.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado.</td></tr>';
                    return;
                }
                //preencher com os dados recebidos
                result.dados.forEach(item => {
                    conteudoAcesso.innerHTML += `<tr class="alert alert-warning">
                    <td>${item.codigo}</td>
                    <td>${item.descricao}</td>
                    <td>${item.andar}</td>
                    <td>${item.capacidade}</td>
                    <td>
                        <div class="row">
                            <button class="btn btn-warning btnAcao" onclick="openEditModal(this)">
                                <i class="fas fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btnAcao btnAcaoExcluir" onclick="deletarSala(${item.codigo})">
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
            const codigo = document.getElementById('codigo').value;
            const descricao = document.getElementById('descricao').value;
            const andar = document.getElementById('andar').value;
            const capacidade = document.getElementById('capacidade').value;
            if (andar === 'Primeiro') andar = 1;
            if (andar === 'Segundo') andar = 2;
            if (andar === 'Terceiro') andar = 3;
            if (andar === 'Quarto') andar = 4;
            if (andar === 'Quinto') andar = 5;
            if (andar === 'Sexto') andar = 6;
            if (andar === 'Térreo') andar = 9;

            try {
                const response = await fetch('../Sala/inserir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo: codigo,
                        descricao: descricao,
                        andar: andar,
                        capacidade: capacidade
                    })
                });
                const result = await response.json();

                if (result.sucesso == true) {
                    //fecha o modal
                    $('#cadsatroSalaModal').modal('hide');

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
                console.error('Erro ao cadastrar a sala: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        $(document).ready(function(){
            carregarDados();
            $('#cadastroSalaModal').on('show.bs.modal', function(){
                $('#formCadastroSala')[0].reset();
            });
        });

        async function editarSala(){
            event.preventDefault();
            try{
            const codigo = document.getElementById('editId').value;
            const descricao = document.getElementById('editDescricao').value;
            const andar = document.getElementById('editAndar').value;
            const capacidade = document.getElementById('editCapacidade').value;
            
            const response = await fetch('../Sala/Alterar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    codigo: codigo,
                    descricao: descricao,
                    andar: andar,
                    capacidade: capacidade
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
                $('#cadastroSalaModal').modal('hide');
                carregarDados(); //atualizar a tabela
            }catch (error) {
                console.error('Erro ao editar a sala: ', error);
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição.', 'error');
            }
        }

        async function deletarSala(codigo){
            Swal.fire({
                title: 'Ateção',
                text: 'Tem certeza que deseja excluir essa sala?',
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
            }).then(async function(res){
                if (res.isConfirmed) {
                    const config = {
                        method: 'post',
                        body: JSON.stringify({
                            codigo: codigo
                        })
                    };
                    const request = await fetch('../Sala/desativar', config);
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

        function filtrarTabela(){
            const input = document.getElementById("inputPesquisa");
            const filter = input.value.toLowerCase();
            const tabela = document.getElementById("conteudo-sala");
            const linhas = tabela.getElementsByTagName("tr");

            for (let i = 0; i < linhas.length; i++){
                const salaTexto = colSala.textContent || colSala.innerText;
                const descricaoText = colDescricao.textContet || colDescricao.innerText;

                //verifica se o filtro corresponde ao numero de sala ou à descrição
                if (salaTexto.toLowerCase().indexOf(filter) > -1 || descricaoTexto.toLowerCase().indexOf(filter) > -1){
                    linhas[i].style.display = "";
                }else{
                    linhas[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>