<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/fornecedor.class.php';

echo $head;
echo $header;
echo $aside;

echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar <small>Fornecedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Editar Fornecedor</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
';
        
        if(isset($_GET['id'])){
            $idfornecedor = $_GET['id'];
            $resp = $fornecedor->editFornecedor($idfornecedor);

echo'
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Fornecedor</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form name="meuFormulario" role="form" action="../../App/Database/insertfornecedor.php" method="POST" onsubmit="return validarFormulario() && removerEspacos()">
              <div class="box-body">
                <div class="form-group">
                 <label for="username">ID Fornecedor</label>
                  <input type="text" name="idcliente" class="form-control" id="username" placeholder="ID" value="' . $resp['Fornecedor']['idfornecedor'] . '" maxlength="45" disabled>

                  <label for="nomefornecedor">Nome do Fornecedor *</label>
                  <input type="text" name="nomefornecedor" class="form-control" id="nomefornecedor" placeholder="Nome" value="' . $resp['Fornecedor']['nome'] . '" maxlength="45" required>

                  <label for="telefone">Telefone *</label>
                  <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Telefone" value="' . $resp['Fornecedor']['telefone'] . '" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>

                  <label for="email">Email *</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="' . $resp['Fornecedor']['email'] . '" maxlength="45" required>

                  <label for="numConta">Número Conta Bancária + Digito *</label>
                  <input type="text" name="numConta" class="form-control" id="numConta" placeholder="Número Conta Bancária" value="' . $resp['Fornecedor']['numConta'] . '" maxlength="11" required>

                  <label for="agencia">Número Agência *</label>
                  <input type="text" name="agencia" class="form-control" id="agencia" placeholder="Número Agência" value="' . $resp['Fornecedor']['agencia'] . '" maxlength="4" required>

                   <label for="banco">Número do Banco *</label>
                  <input type="text" name="banco" class="form-control" id="banco" placeholder="Número Conta Bancária" value="' . $resp['Fornecedor']['banco'] . '" maxlength="3" required>
    
                  <label for="ativo">Status do Fornecedor *</label>
                  <select name="ativo" class="form-control" id="ativo">
                    <option value="1" ' . ($resp['Fornecedor']['ativo'] == 1 ? 'selected' : '') . '>Ativo</option>
                    <option value="0" ' . ($resp['Fornecedor']['ativo'] == 0 ? 'selected' : '') . '>Inativo</option>
                  </select>

                 
                </div>

                <div class="form-group">

      <h4 >Endereço</h4>

      <!-- Campos de endereço -->
     <div class="form-group">
      <label for="rua">Rua *</label>
      <input type="text" name="rua" class="form-control" id="rua" placeholder="Rua" value="'.$resp['Endereco']['rua'].'" maxlength="45" required>

      <label for="numero">Número *</label>
      <input type="text" name="numero" class="form-control" id="numero" placeholder="Número" value="'.$resp['Endereco']['numero'].'" maxlength="8" required>

      <label for="bairro">Bairro *</label>
      <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Bairro" value="'.$resp['Endereco']['bairro'].'" maxlength="45" required>

      <label for="cidade">Cidade *</label>
      <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Cidade" value="'.$resp['Endereco']['cidade'].'" maxlength="45" required>

      <label for="estado">Estado *</label>
      <input type="text" name="estado" class="form-control" id="estado" placeholder="Estado" value="'.$resp['Endereco']['estado'].'" maxlength="2" oninput="handleInput(event)" required>

      <label for="cep">CEP *</label>
      <input type="text" name="cep" class="form-control" id="cep" placeholder="CEP" value="'.$resp['Endereco']['cep'].'" maxlength="9" oninput="aplicarMascaraCEP(this)" required>
    </div>
                
                <input type="hidden" name="idUsuario" value="' . $idUsuario . '">
                <input type="hidden" name="idfornecedor" value="'.$idfornecedor.'">
                </div>

              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Alterar</button>
                <a class="btn btn-danger" href="../../views/fornecedor">Cancelar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
</div>';
        }//if
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

    // Máscara para CPF no formato 999.999.999-99
    function aplicarMascaraCPF(input) {
        let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca um ponto após os três primeiros dígitos
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca outro ponto após o terceiro dígito
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca um traço antes dos dois últimos dígitos
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