<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/icone_fatecSR.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../ds2mf/assets/css/reset.css">
    <link rel="stylesheet" href="../../ds2mf/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../ds2mf/assets/css/styleCadastro.css">
    <link rel="stylesheet" href="../../ds2mf/assets/css/stylePassword.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">

    <title>Login - Sistema de Mapeamento de salas</title>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <img src="../../ds2mf/assets/img/logo_fatecSR.png" alt="Logo da Fatec" style="max-width: 200px; margin-bottom: 20px;">
        </div>
        <div class="panel-body">
            <form autocomplete="off" id="login">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="Usuario" id="txtUsuario" name="txtUsuario" type="text" autofocus required>

                        <div class="form-group">
                            <input class="form-control" placeholder="Senha" id="txtSenha" name="txtSenha" type="password" required>
                            <div class="input-group-append">
                                <i id="togglePassword" class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="btnEntrar" class="btn btn-block btnAcao" onclick="validaLogin()">Entrar</button>
                </fieldset>
            </form>
        </div>
    </div>


</body>
</html>


    <script src="../../ds2mf/assets/js/jquery-3.6.0.min.js"></script>
    <script src="../../ds2mf/assets/js/bootstrap.min.js"></script>
    <script src="../../ds2mf/assets/js/sweetalert2.all.min.js"></script>
    <script>
    //Criando a função que irá mandar os dados para verificar no controller e model
    async function validaLogin() {
        event.preventDefault();
        try {
            //pegando as informações dos forms acima
            const usuario = document.getElementById('txtUsuario').value;
            const senha = document.getElementById('txtSenha').value;
            //não entendi exatamente, pesquisar mais tarde essa função
            const base_url = function(url='') {
                return "<?= base_url()?>"+url
            }
            //criando o JSON com os dados e mandando para validação
            const response = await fetch('Usuario/logar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    usuario: usuario,
                    senha: senha
                })
            });

            // resposta em JSON
            const result = await response.json();

            if (result.codigo == 1) {
                //relembrando que a saida de código 1 foi padronizada para indicar sucesso na função, então aqui é caso tenha dado tudo certo na validção
                Swal.fire('Sucesso!', result.msg, 'success');

                window.location.href = base_url("Funcoes/indexPagina")
            } else {
                //caso o código nao seja 1, indica que ocorreu algum erro e aqui montamos a mensagem para mostrar qual foi
                const mensagensDeErro = result.erros.map(erro => {
                    return `<p><strong>[${erro.campo ?? erro.codigo}]</strong> ${erro.msg} </p>`;
                }).join('');
                //chamando o Swal.Fire mas utilizando a propriedade 'html'
                Swal.fire({
                    title: 'Houve(ram) erro(s) de validação:',
                    html: mensagensDeErro, //por causa dessa propriedade, vai poder exibir as tags <strong> e <p>
                    icon: 'error',
                    confirmButtonText: 'Fechar'
                })
            }
        } catch(error) {
            console.error('Errou', error)
        }
    }
</script>
