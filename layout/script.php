<?php

// Inicializando o array de notificações se ele não existir
if (!isset($_SESSION['notificacoes'])) {
  $_SESSION['notificacoes'] = [];
}
// Verifica se o botão de limpar notificações foi clicado
if (isset($_POST['limpar_notificacoes'])) {
  // Limpa as notificações
  $_SESSION['notificacoes'] = [];
}

$contagemNotificacoes = count($_SESSION['notificacoes']);

$url = 'http://localhost/controlestoque/views/';

$head = '<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-language" content="pt-br" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="'.$url.'bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="'.$url.'dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="'.$url.'dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="'.$url.'plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="'.$url.'plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="'.$url.'plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="'.$url.'plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="'.$url.'plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="'.$url.'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

';

$header = '<header class="main-header">
    <!-- Logo -->
    <a href="../" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CB</b>Alimentos</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>


      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown notification">
          <!-- Notifications: style can be found in dropdown.less -->
          <a class="dropdown-toggle open" style="cursor: pointer;" data-toggle="modal" data-target="#globalModal">
            <i class="fa fa-bell" aria-hidden="true"></i>
            Notificações <span class="badge btn-warning">' . $contagemNotificacoes . '</span>
          </a>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="'.$url.''.$foto.'" class="user-image" alt="User Image">
              <span class="hidden-xs">'.$username.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="'.$url.''.$foto.'" class="img-circle" alt="User Image">

                <p>
                  '.$username.'
                </p>
              </li>
              
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="'.$url.'destroy.php" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>';

$aside = '<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
    

     <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">FERRAMENTAS</li>
      
      
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Clientes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="'.$url.'clientes/"><i class="fa fa-user"></i>Clientes</a></li>
            <li><a href="'.$url.'clientes/addcliente.php"><i class="fa fa-user-plus"></i>Add Cliente</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Vendas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="'.$url.'vendas/"><i class="fa fa-shopping-cart"></i>Vendas</a></li>
            <li><a href="'.$url.'vendas/addvenda.php"><i class="fa fa-cart-plus"></i>Fazer Venda</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-basket"></i>
            <span>Cestas Básicas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="'.$url.'cestabasica/"><i class="fa fa-shopping-basket"></i> Cestas</a></li>
            <li><a href="'.$url.'cestabasica/addcesta.php"><i class="fa fa-plus"></i> Add Cestas</a></li>
            <li><a href="'.$url.'categoria/"><i class="fa fa-bars"></i> Categorias</a></li>
            <li><a href="'.$url.'categoria/addcategoria.php"><i class="fa fa-plus"></i> Add Categorias</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th-large"></i> <span>Produtos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="'.$url.'produto/"><i class="fa fa-th-list"></i> Lista de Produtos</a></li>
            <li><a href="'.$url.'produto/addproduto.php"><i class="fa fa-plus"></i> Add Produtos</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Fornecedores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="'.$url.'fornecedor/"><i class="fa fa-truck"></i> Lista de Fornecedores</a></li>
            <li><a href="'.$url.'fornecedor/addfornecedor.php"><i class="fa fa-plus"></i> Add Fornecedor</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Usuários</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="'.$url.'usuarios/"><i class="fa fa-list-ul"></i> Lista de Usuários</a></li>
            <li><a href="'.$url.'usuarios/addusuarios.php"><i class="fa fa-user-plus"></i> Add Usuário</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>';

  $footer = '<!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> beta
    </div>
    <strong>CB Alimentos para a vida</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>';

$javascript = '
</div>
<!-- jQuery 2.2.3 -->
<script src="'.$url.'plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="'.$url.'bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="'.$url.'plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="'.$url.'plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="'.$url.'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="'.$url.'plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="'.$url.'plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="'.$url.'plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="'.$url.'plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="'.$url.'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="'.$url.'plugins/slimScroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="'.$url.'plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="'.$url.'dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="'.$url.'dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="'.$url.'dist/js/demo.js"></script>


</body>
</html>';

?>

<div id="globalModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Notificações de Estoque Baixo</h4>
      </div>
      <div class="modal-body">
        <?php
        if ($contagemNotificacoes > 0): ?>
            <ul class="notification-list">
              <?php foreach ($_SESSION['notificacoes'] as $notificacao): ?>
                <li>
                  <i class="fa fa-exclamation-circle notification-icon"></i>
                  <?php echo $notificacao; ?>
                </li>
              <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Sem notificações.</p>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <form method="post" action="">
            <button type="submit" name="limpar_notificacoes" class="btn btn-danger float-right">Limpar Notificações</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>

.notification-list {
    list-style-type: none; /* Remove o estilo padrão da lista */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margem */
}

.notification-list li {
    padding: 10px 0; /* Espaçamento entre itens */
    display: flex;
    align-items: center; /* Alinha ícone com o texto */
    border-bottom: 1px solid #ddd; /* Linha separadora */
}

.notification-list li:last-child {
    border-bottom: none; /* Remove linha do último item */
}

.notification-icon {
    color: #f39c12; /* Cor laranja para destaque */
    margin-right: 10px; /* Espaço entre ícone e texto */
}

.notification-list strong {
    color: #333; /* Destaca texto */
}

</style>

<script>
function mascaraValor(input) {
  let value = input.value;
  
  // Remove tudo que não for dígito
  value = value.replace(/\D/g, "");

  // Adiciona a vírgula e os pontos conforme o valor cresce
  value = (value / 100).toFixed(2) + "";
  value = value.replace(".", ",");
  value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

  // Atualiza o valor do input com a máscara de moeda
  input.value = value;
};

function validarValorFinal(input) {
    // Remove os caracteres não numéricos para fazer a comparação
    let valorNumerico = parseFloat(input.value.replace("R$ ", "").replace(/\./g, "").replace(",", "."));
    
    if (valorNumerico > 10000) {
        // Define o valor máximo como R$ 10.000,00
        input.value = "R$ 10.000,00";
        alert("O valor máximo permitido é R$ 10.000,00.");
    } else if (valorNumerico < 0) {
        // Corrige valores negativos para R$ 0,00
        input.value = "R$ 0,00";
        alert("O valor não pode ser negativo.");
    } else {
        // Aplica a máscara de valor corretamente ao valor final
        mascaraValor(input);
    }
};

function removerEspacos() {
    // Seleciona todos os inputs de texto
    var inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(function(input) {
        input.value = input.value.trim(); // Remove os espaços em branco no início e no final
    });
};

</script>
