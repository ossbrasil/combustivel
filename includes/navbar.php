
<?php
include("./includes/head.php");
include("./includes/session.php");
include("./includes/imports.php") ;

?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" target="_blank">
            <a href="menu.php" class="navbar-logo">
            <img src="./imagens/logo.png" width="50" alt=""  class="d-inline-block align-middle mr-2 ">
        </a>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <!-- Left -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
              <a class="nav-link waves-effect"  href="menu.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <?php
                 if ($_SESSION['acesso'] == 1) { echo '
           
            <li class="nav-item">
            <a class="nav-link" href="cadastro.php" style="font-size: 1rem;">  Clientes</a>
          </a>
          </li>';} ?>
            <?php
                 if ($_SESSION['acesso'] <= 2) { echo '
           
            <li class="nav-item">
            <a class="nav-link" href="utilitarios.php" style="font-size: 1rem;">  Utilitários</a>
          </a>
          </li>';} ?>
            <?php
                 if ($_SESSION['acesso'] <= 2) { echo '
           
            <li class="nav-item">
            <a class="nav-link" href="cadastro_empresa.php" style="font-size: 1rem;">  Empresas</a>
          </a>
          </li>';} ?>
            <?php
                 if ($_SESSION['acesso'] <= 2 ) { echo '
            <li class="nav-item">
              <a class="nav-link" href="cadastro_funcionarios.php" style="font-size: 1rem;">  Funcionários</a>
            </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro_veiculos.php" style="font-size: 1rem;">  Veículos</a>
            </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro_combs.php" style="font-size: 1rem;">  Combustivel</a>
            </a>
            </li>';} ?>
        
            <li class="nav-item">
              <a class="nav-link" href="abs.php" style="font-size: 1rem;"> Abastecimento</a>
            </a>
            </li>
            </li>
            </li>
           
          </ul>

          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
              
          <!-- <li class="nav-item">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" style="font-size: 1rem;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user mr-1"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Perfil</a>
                    <a class="dropdown-item" href="#">Configurações</a>
                </div>
            </li>
            </li>  -->
          <li class="nav-item">
                <a class="nav-link" href="#" style="float: right;" onclick="acessPage('./includes/logout.php')"><i class="fas fa-sign-out-alt mr-1"></i>Sair</a>
            
            </li>
            
            
          </ul>

        </div>

      </div>
    </nav>
    <!-- Navbar -->

    <!-- Sidebar -->
    
    <!-- Sidebar -->




<!-- 
<link rel="stylesheet" type="./sass/padroes.css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" /> 
<nav class="navbar navbar-expand-lg navbar-light font-weight-normal " style="box-shadow: 2px 2px 4px #d3d3d3;font-size:22px; border-bottom: 2px solid #d3d3d3;">
    <div>
        <a href="#" class="navbar-logo">
            <img src="./imagens/logo.png" width="100" alt="" class="d-inline-block align-middle mr-2 ">
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarNavDropdown" style="font-family: sans-serif;font-size: 1rem;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link"  href="menu.php" style="font-family: sans-serif;font-size: 1rem;">Home <span class="sr-only">(current)</span></a>
            </li>
            
          

         
            <li class="nav-item">
                <a class="nav-link" href="cadastro_veiculos.php" style="font-size: 1rem;"> Cadastro de Veículos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" style="font-size: 1rem;">Agendamento</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" style="font-size: 1rem;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" style="float: right;" onclick="location.replace('login.php');"><i class="fas fa-sign-out-alt mr-1"></i>Sair</a>
            </li>
        </ul>

    </div>
</nav> -->

<?php include("./includes/imports.php") ?>