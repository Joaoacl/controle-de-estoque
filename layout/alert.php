<?php

if (isset($_GET['alert'])) {
	if ($_GET['alert'] == 'email_ja_existe') {
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Este email já está cadastrado!</div>';
	} elseif ($_GET['alert'] == 'cpf_ja_existe') {
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>CPF já cadastrado!</div>';
	} elseif ($_GET['alert'] == 'campos_obrigatorios') {
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Preencha todos os campos obrigatórios!</div>';
	} elseif ($_GET['alert'] == 'sucesso') {
	  echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Adicionado com sucesso!</div>';
	} elseif ($_GET['alert'] == 'update_sucesso') {
	  echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Alterado com sucesso!</div>';
	}elseif ($_GET['alert'] == 'deletado') {
	  echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Deletado com sucesso!</div>';
	}elseif ($_GET['alert'] == 'venda_realizada') {
		echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Venda realizada com sucesso!</div>';
	}elseif ($_GET['alert'] == 'estoque_insuficiente') {
		echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Erro ao realizar a venda ou estoque insuficiente.!</div>';
	}elseif ($_GET['alert'] == 'venda_cancelada') {
		echo '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Venda cancelada!</div>';
	}
  };

if(isset($_GET['alert'])){

echo '<div class="box-body">';
	switch ($_GET['alert']) {
		case '0':
			echo '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                Error...
              </div>';
			break;
			
		case '1':
			echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                Success...
              </div>';
			break;
		
		}//switch
	echo'</div>';
}