<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adicionar <small>Fornecedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fornecedor</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Fornecedor</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="meuFormulario" role="form" action="../../App/Database/insertfornecedor.php" method="POST" onsubmit="return validarFormulario() && removerEspacos()">

              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Fornecedor *</label>
                  <input type="text" name="nomefornecedor" class="form-control" id="nomefornecedor" placeholder="Nome Fornecedor" maxlength="45" required>

                  <label for="exampleInputEmail1">Telefone *</label>
                  <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Telefone" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>
               
                  <label for="email">Email *</label>
                  <input type="email" id="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" oninput="validarFormulario()">

                  <label for="confirmar_email">Confirmar E-mail *</label>
                  <input type="email" id="confirmar_email" class="form-control" name="confirmar_email" maxlength="45" placeholder="Confirmar E-mail" required oninput="validarFormulario()">
                  <div id="errorEmail" class="error"></div>

                  <label for="numConta">Número da Conta Bancaria + Digito *</label>
                  <input type="text" name="numConta" class="form-control" id="numConta" placeholder="Núm Conta" maxlength="11" required>

                  <label for="agencia">Número da Agência *</label>
                  <input type="text" name="agencia" class="form-control" id="agencia" placeholder="Agência" maxlength="4" required>

                  <label for="banco">Número do Banco *</label>
                  <input type="text" name="banco" class="form-control" id="banco" placeholder="Núm Banco" maxlength="3" required>


                  <h4 >Endereço</h4>

                  <label for="exampleInputEmail1">Rua *</label>
                  <input type="text" name="rua" class="form-control" id="exampleInputEmail1" placeholder="Rua" maxlength="45" required>

                  <label for="exampleInputEmail1">Número *</label>
                  <input type="text" name="numero" class="form-control" id="exampleInputEmail1" placeholder="Número" maxlength="8" required>

                  <label for="exampleInputEmail1">Bairro *</label>
                  <input type="text" name="bairro" class="form-control" id="exampleInputEmail1" placeholder="Bairro" maxlength="45" required>

                  <label for="exampleInputEmail1">Cidade *</label>
                  <input type="text" name="cidade" class="form-control" id="exampleInputEmail1" placeholder="Cidade" maxlength="45" required>

                  <label for="exampleInputEmail1">Estado *</label>
                  <input type="text" name="estado" class="form-control" id="exampleInputEmail1" placeholder="Ex: SP, MG, PR" maxlength="2" required oninput="handleInput(event)">

                  <label for="exampleInputEmail1">CEP *</label>
                  <input type="text" name="cep" class="form-control" 
                  id="exampleInputEmail1" placeholder="CEP" required maxlength="9" oninput="aplicarMascaraCEP(this)">

                </div>
                
                </div>
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
                <a class="btn btn-danger" href="../../views/fornecedor">Cancelar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
</div>';

echo '</div>';
echo '</div>';
echo '</section>';
echo '</div>';
echo  $footer;
echo $javascript;
?>

<style>
        .error {
            color: red;
            font-size: 0.9em;
        }
</style>

<script>

  

    // Máscara para telefone no formato (99) 99999-9999
    function aplicarMascaraTelefone(input) {
        let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2'); // Coloca parênteses em volta dos dois primeiros dígitos
        valor = valor.replace(/(\d{5})(\d)/, '$1-$2'); // Coloca o traço depois dos cinco primeiros dígitos
        input.value = valor;
    };

    function handleInput(e) {
    var ss = e.target.selectionStart;
    var se = e.target.selectionEnd;
    e.target.value = e.target.value.toUpperCase();
    e.target.selectionStart = ss;
    e.target.selectionEnd = se;
    };

    // Máscara para CEP no formato 99999-999
    function aplicarMascaraCEP(input) {
    let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
    valor = valor.replace(/^(\d{5})(\d)/, '$1-$2'); // Coloca um traço entre o quinto e o sexto dígito
    input.value = valor;
    };

    function validarFormulario() {
            var email = document.forms["meuFormulario"]["email"].value;
            var confirmar_email = document.forms["meuFormulario"]["confirmar_email"].value;
  

            var errorEmail = document.getElementById("errorEmail");
          

            var formValido = true;

            // Validação de Email
            if (email !== confirmar_email) {
                errorEmail.textContent = "Os emails não correspondem.";
                formValido = false; // Bloqueia o envio
            } else {
                errorEmail.textContent = ""; // Limpa a mensagem de erro
            }


            botaoSubmit.disabled = !formValido;

            // Retorna se o formulário é válido ou não
            return formValido;
    };

    function inicializarValidacao() {
        var inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', validarFormulario);
        });
    };

        // Inicializa a validação quando a página é carregada
        window.onload = inicializarValidacao;

</script>