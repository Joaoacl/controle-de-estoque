<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/produto.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adicionar <small>Usuário</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Usuário</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Usuário</h3>
            </div>
            <!-- /.box-header -->
';

        $erros = $_SESSION['erros'] ?? [];
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['erros'], $_SESSION['form_data']);

        $label_email = "";
        $label_cpf = "";
        if (isset($erros['email'])):  
          $label_email = "error";
        endif;

        if (isset($erros['cpf'])):  
          $label_cpf = "error";
        endif;

if($perm == 1){

echo '



            <!-- form start -->
            <form id="formCriaUsuario" name="formCriaUsuario" role="form" enctype="multipart/form-data" action="../../App/Database/insertuser.php" method="POST" onsubmit="return removerEspacos() && validarFormulario()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Usuário *</label>
                  <input type="text" name="nomeusuario" class="form-control" id="nomeusuario" placeholder="Nome do Usuário" maxlength="45" value="' .htmlspecialchars($formData['nomeusuario'] ?? '').'" required>
          

                <label class="'.$label_cpf.'" for="exampleInputEmail1">CPF *</label>
                <input type="text" name="cpf" class="form-control" placeholder="CPF" maxlength="14" oninput="aplicarMascaraCPF(this)" required value="' .htmlspecialchars($formData['cpf'] ?? '').'" required>
                ';
                if (isset($erros['cpf'])): 
                    echo'<div class="error">';
                    echo $erros['cpf'];
                    echo'</div>';
                endif;
              
                echo'</br>
                <label for="exampleInputEmail1">Salário *</label>
                <input type="text" name="salario"  class="form-control" id="exampleInputEmail1" placeholder="R$" oninput="mascaraValor(this)" value="' .htmlspecialchars($formData['salario'] ?? '').'" required>
                

                
                <label for="exampleInputEmail1">Cargo *</label>
                <input type="text" name="cargo" class="form-control" id="exampleInputEmail1" placeholder="Cargo" maxlength="45" value="' .htmlspecialchars($formData['cargo'] ?? '').'" required>
                
               
                

                <label class="'.$label_email .'" for="email">Email *</label>
                <input type="text" name="email" class="form-control" placeholder="E-mail" maxlength="45" value="' .htmlspecialchars($formData['email'] ?? '').'" required oninput="validarFormulario()" >
                ';
                if (isset($erros['email'])): 
                    echo'<div class="error">';
                    echo $erros['email'];
                    echo'</div>';
                endif;
              
                echo'
                

                <label for="confirmar_email">Confirmar E-mail *</label>
                <input type="email" id="confirmar_email" class="form-control" name="confirmar_email" maxlength="45" placeholder="Confirmar E-mail" value="' .htmlspecialchars($formData['confirmar_email'] ?? '').'" required oninput="validarFormulario()">
                <div id="errorEmail" class="error"></div>

                
                <label for="exampleInputEmail1">Senha *</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" maxlength="45" value="' .htmlspecialchars($formData['senha'] ?? '').'" required oninput="validarFormulario()">
                

                <label for="confirmar_senha">Confirmar Senha *</label>
                <input type="password" id="confirmar_senha" class="form-control" name="confirmar_senha" placeholder="Confirmar Senha"  maxlength="45" value="' .htmlspecialchars($formData['confirmar_senha'] ?? '').'" required oninput="validarFormulario()">
                <div id="errorSenha" class="error"></div>
                
                <label for="exampleInputEmail1">Telefone *</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone" maxlength="15" oninput="aplicarMascaraTelefone(this)" value="' .htmlspecialchars($formData['telefone'] ?? '').'" required>

                <label for="exampleInputEmail1">Permissão *</label>
                <select class="form-control" name="permissao" type="permissao" value="' .htmlspecialchars($formData['permissao'] ?? '').'" required>
                <option value="">Escolha a Permissão do Usuário</option>
                <option value="1" '.((isset($formData['permissao']) && $formData['permissao'] == 1) ? 'selected' : '').'>Administrador</option>
                <option value="2" '.((isset($formData['permissao']) && $formData['permissao'] == 2) ? 'selected' : '').'>Vendedor</option>
                </select>

                <label for="exampleInputEmail1">Imagem</label>
                <input id="arquivo" name="arquivo" type="file" class="form-control input-md" placeholder="Imagem">

                </div>

                <div class="form-group">
                <h4 >Endereço</h4>

                  <label for="exampleInputEmail1">Rua *</label>
                  <input type="text" name="rua" class="form-control" id="exampleInputEmail1" placeholder="Rua" value="' .htmlspecialchars($formData['rua'] ?? '').'" required maxlength="45">

                  <label for="exampleInputEmail1">Número *</label>
                  <input type="text" name="numero" class="form-control" id="exampleInputEmail1" placeholder="Número" value="' .htmlspecialchars($formData['numero'] ?? '').'" required maxlength="8">

                  <label for="exampleInputEmail1">Bairro *</label>
                  <input type="text" name="bairro" class="form-control" id="exampleInputEmail1" placeholder="Bairro" value="' .htmlspecialchars($formData['bairro'] ?? '').'" required maxlength="45">

                  <label for="exampleInputEmail1">Cidade *</label>
                  <input type="text" name="cidade" class="form-control" id="exampleInputEmail1" placeholder="Cidade" value="' .htmlspecialchars($formData['cidade'] ?? '').'" required maxlength="45">

                  <label for="exampleInputEmail1">Estado *</label>
                  <input type="text" name="estado" class="form-control" id="exampleInputEmail1" placeholder="Ex: SP, MG, PR" value="' .htmlspecialchars($formData['estado'] ?? '').'" required maxlength="2" oninput="handleInput(event)">

                  <label for="exampleInputEmail1">CEP *</label>
                  <input type="text" name="cep" class="form-control" 
                  id="exampleInputEmail1" placeholder="CEP" value="' .htmlspecialchars($formData['cep'] ?? '').'" required maxlength="9" oninput="aplicarMascaraCEP(this)">
                </div>
               
            </div>


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" id="botaoSubmit" name="upload" class="btn btn-primary" value="Cadastrar" disabled>Cadastrar</button>
                <a class="btn btn-danger" href="../../views/usuarios">Cancelar</a>
              </div>
            </form>
';}else{
  echo'Você não possui acesso!';
}
echo'

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

    // Máscara para CPF no formato 999.999.999-99
    function aplicarMascaraCPF(input) {
        let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca um ponto após os três primeiros dígitos
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca outro ponto após o terceiro dígito
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca um traço antes dos dois últimos dígitos
        input.value = valor;
    };

    // Campo de senha sem máscara, mas transformado em password (esconde os caracteres)
    function esconderSenha(input) {
        input.type = 'password';
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
            var email = document.forms["formCriaUsuario"]["email"].value;
            var confirmar_email = document.forms["formCriaUsuario"]["confirmar_email"].value;
            var senha = document.forms["formCriaUsuario"]["senha"].value;
            var confirmar_senha = document.forms["formCriaUsuario"]["confirmar_senha"].value;

            var errorEmail = document.getElementById("errorEmail");
            var errorSenha = document.getElementById("errorSenha");

            var formValido = true;

            // Validação de Email
            if (email !== confirmar_email) {
                errorEmail.textContent = "Os emails não correspondem.";
                formValido = false; // Bloqueia o envio
            } else {
                errorEmail.textContent = ""; // Limpa a mensagem de erro
            }

            // Validação de Senha
            if (senha !== confirmar_senha) {
                errorSenha.textContent = "As senhas não correspondem.";
                formValido = false; // Bloqueia o envio
            } else {
                errorSenha.textContent = ""; // Limpa a mensagem de erro
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

