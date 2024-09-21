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

if($perm == 1){

echo '



            <!-- form start -->
            <form role="form" enctype="multipart/form-data" action="../../App/Database/insertuser.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Usuário</label>
                  <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Nome do Usuário" maxlength="45" required>
                

                
                <label for="exampleInputEmail1">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" maxlength="14" oninput="aplicarMascaraCPF(this)" required>
              

                
                <label for="exampleInputEmail1">Salário</label>
                <input type="text" name="salario"  class="form-control" id="exampleInputEmail1" placeholder="R$" oninput="mascaraValor(this)" required>
                

                
                <label for="exampleInputEmail1">Cargo</label>
                <input type="text" name="cargo" class="form-control" id="exampleInputEmail1" placeholder="Cargo" maxlength="45" required>
                

               
                <label for="exampleInputEmail1">Email</label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" maxlength="45" required>
               

                
                <label for="exampleInputEmail1">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" maxlength="45" required>
                

                
                <label for="exampleInputEmail1">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone" maxlength="15" oninput="aplicarMascaraTelefone(this)">

                <label for="exampleInputEmail1">Permissão</label>
                <select class="form-control" name="permissao" type="permissao" required>
                <option value="1">Administrador</option>
                <option value="2">Vendedor</option>
                </select>

                <label for="exampleInputEmail1">Imagem</label>
                <input id="arquivo" name="arquivo" type="file" class="form-control input-md" placeholder="Imagem">

                </div>

                <div class="form-group">
                <h4 >Endereço</h4>

                  <label for="exampleInputEmail1">Rua</label>
                  <input type="text" name="rua" class="form-control" id="exampleInputEmail1" placeholder="Rua" required maxlength="45">

                  <label for="exampleInputEmail1">Número</label>
                  <input type="text" name="numero" class="form-control" id="exampleInputEmail1" placeholder="Número" required maxlength="8">

                  <label for="exampleInputEmail1">Bairro</label>
                  <input type="text" name="bairro" class="form-control" id="exampleInputEmail1" placeholder="Bairro" required maxlength="45">

                  <label for="exampleInputEmail1">Cidade</label>
                  <input type="text" name="cidade" class="form-control" id="exampleInputEmail1" placeholder="Cidade" required maxlength="45">

                  <label for="exampleInputEmail1">Estado</label>
                  <input type="text" name="estado" class="form-control" id="exampleInputEmail1" placeholder="Ex: SP, MG, PR" required maxlength="2">

                  <label for="exampleInputEmail1">CEP</label>
                  <input type="text" name="cep" class="form-control" 
                  id="exampleInputEmail1" placeholder="CEP" required maxlength="9" oninput="aplicarMascaraCEP(this)">
                </div>
               
            </div>


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
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

<script>
    // Máscara para telefone no formato (99) 99999-9999
    function aplicarMascaraTelefone(input) {
        let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2'); // Coloca parênteses em volta dos dois primeiros dígitos
        valor = valor.replace(/(\d{5})(\d)/, '$1-$2'); // Coloca o traço depois dos cinco primeiros dígitos
        input.value = valor;
    }

    // Máscara para CPF no formato 999.999.999-99
    function aplicarMascaraCPF(input) {
        let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca um ponto após os três primeiros dígitos
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca outro ponto após o terceiro dígito
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca um traço antes dos dois últimos dígitos
        input.value = valor;
    }

    // Campo de senha sem máscara, mas transformado em password (esconde os caracteres)
    function esconderSenha(input) {
        input.type = 'password';
    }

    // Máscara para CEP no formato 99999-999
    function aplicarMascaraCEP(input) {
    let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
    valor = valor.replace(/^(\d{5})(\d)/, '$1-$2'); // Coloca um traço entre o quinto e o sexto dígito
    input.value = valor;
    }
</script>

