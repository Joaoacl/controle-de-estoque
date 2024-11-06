<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/cliente.class.php';
require_once '../../App/Models/config.class.php';

$maxDesconto = $config->getMaxDesconto();

echo $head;
echo $header;
echo $aside;

echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar <small>Usuário</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Editar Usuário</li>
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
            $idcliente = $_GET['id'];
            $resp = $clientes->editCliente($idcliente);

echo'
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Usuário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form name="meuFormulario" role="form" action="../../App/Database/insertcli.php" method="POST" onsubmit="return validarFormulario() && removerEspacos()">
              <div class="box-body">
                <div class="form-group">
                 <label for="username">ID Cliente</label>
                  <input type="text" name="idcliente" class="form-control" id="username" placeholder="ID" value="' . $resp['Cliente']['idcliente'] . '" maxlength="45" disabled>

                  <label for="username">Nome do Cliente *</label>
                  <input type="text" name="nomecliente" class="form-control" id="username" placeholder="Nome" value="' . $resp['Cliente']['nome'] . '" maxlength="45" required>

                  <label for="cpf">CPF *</label>
                  <input type="text" name="cpf" class="form-control" id="cpf" placeholder="CPF" value="' . $resp['Cliente']['cpf'] . '" maxlength="14" oninput="aplicarMascaraCPF(this)" required>
                
                  <label for="email">Desconto (%)</label>
                  <input type="number" name="desconto" class="form-control" id="desconto" placeholder="Percentual de desconto" value="' . $resp['Cliente']['desconto'] . '" min="0" max="'.$maxDesconto.'">

                  <label for="email">Email *</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="' . $resp['Cliente']['email'] . '" maxlength="45" required>
          

                  <label for="telefone">Telefone *</label>
                  <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Telefone" value="' . $resp['Cliente']['telefone'] . '" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>

            
                  <label for="ativo">Status do Usuário *</label>
                  <select name="ativo" class="form-control" id="ativo">
                    <option value="1" ' . ($resp['Cliente']['ativo'] == 1 ? 'selected' : '') . '>Ativo</option>
                    <option value="0" ' . ($resp['Cliente']['ativo'] == 0 ? 'selected' : '') . '>Inativo</option>
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
                <input type="hidden" name="idcliente" value="'.$idcliente.'">
                </div>

              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Alterar</button>
                <a class="btn btn-danger" href="../../views/clientes">Cancelar</a>
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