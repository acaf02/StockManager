<style>
    /* Estilos da Navbar */
    .navbar {
        background-color: #ACB2AD;
        /* Cor padrão da navbar */
        height: 60px;
        /* Ajusta a altura da navbar */
        padding: 5px 15px;
        /* Ajusta o padding interno para diminuir a altura */
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Estilo dos ícones e links dentro da navbar */
    .header-home,
    .header-icon {
        padding-left: 20px;
        font-size: 24px;
        color: black;
        cursor: pointer;
    }

    .header-home a,
    .header-icon a {
        color: black;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .header-home a:hover,
    .header-icon a:hover {
        color: #FFFFFF;
        transform: scale(1.1);
    }

    .logo {
        flex: 1;
        text-align: center;
    }

    .logo img {
        width: 120px;
        height: 45px;
    }

    .offcanvas-body {
        background-color: #006233;
        padding: 20px;
    }


    .nav-item {
        width: 100%;
        padding: 20px 30px;
        color: #fff;
        text-align: center;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        transition: background-color 0.3s ease;
        font-size: 22px;
        height: 60px;
    }

    .nav-item:hover {
        background-color: #005622;
    }

    .nav-item a {
        text-decoration: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        /* Centraliza o conteúdo do link */
        width: 100%;
    }

    .nav-item i {
        margin-right: 12px;
        /* Aumentei o espaçamento entre o ícone e o texto */
        font-size: 22px;
        /* Aumentei o tamanho do ícone */
    }
</style>

<nav class="navbar fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="logo">
            <a href="../../telas/inicio/inicio.php">
                <img src="../../assets/imagens/logoSM.png" alt="Logo">
            </a>
        </div>

        <div class="header-home table-hover">
            <a href="../../telas/inicio/inicio.php" class="hover-effect">
                <i class="fas fa-house"></i>
            </a>
        </div>

        <div class="header-icon">
            <a href="../../componentes/logout.php" class="hover-effect">
                <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 24px;"></i>
            </a>
        </div>
    </div>

    <!-- Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header" style="background-color: #006233; padding:20px;">
            <h2 class="offcanvas-title" id="offcanvasNavbarLabel" style="color: white;">Menu</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
                style="background-color: #fff;"></button>
        </div>
        <div class="offcanvas-body">
            <div class="navbar-nav w-100">
                <div class="nav-item">
                    <a href="../../telas/estoque/estoque.php">
                        <i class="fas fa-warehouse"></i> Estoque
                    </a>
                </div>
                <div class="nav-item">
                    <a href="../../telas/cadastro/cadastro.php">
                        <i class="fas fa-circle-plus"></i> Cadastrar
                    </a>
                </div>
                <div class="nav-item">
                    <a href="../../telas/relatorio/relatorios.php">
                        <i class="fas fa-chart-pie"></i> Relatórios
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>