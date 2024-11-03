<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        overflow: hidden;
    }

    .navbar {
        position: fixed;
        left: -220px;
        top: 0;
        height: 100%;
        width: 150px;
        background-color: #006233; 
        transition: left 0.3s;
        padding-top: 60px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .nav-item {
        width: 100%;
        padding: 10px 15px;
        color: #fff;
        text-align: left;
        cursor: pointer;
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-item:hover {
        background-color: #005622;
    }

    .nav-item a {
        text-decoration: none;
        color: #fff;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .nav-item i {
        margin-right: 8px;
    }

    .menu-icon {
        position: fixed;
        top: 18px;
        left: 20px;
        font-size: 24px;
        color: black;

        cursor: pointer;
        z-index: 1001;
        transition: color 0.3s ease;
    }

    .menu-icon:hover {
        color: white;
    }

    .menu-icon.active {
        color: #ffffff; 
    }

    .menu-icon a {
        text-decoration: none;
        color: inherit;
    }
</style>

<div class="menu-icon" id="menuIcon" onclick="toggleNavbar()">
    <i class="fas fa-bars"></i>
</div>

<div class="navbar" id="navbar">
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

<script>
    // Alternar visibilidade da navbar
    function toggleNavbar() {
        const navbar = document.getElementById('navbar');
        const menuIcon = document.getElementById('menuIcon');

        // Abrir ou fechar a navbar
        if (navbar.style.left === '0px') {
            navbar.style.left = '-220px';
            menuIcon.classList.remove('active');
        } else {
            navbar.style.left = '0px';
            menuIcon.classList.add('active');
        }
    }

    // Fechar a navbar ao clicar fora dela
    document.addEventListener('click', function(event) {
        const navbar = document.getElementById('navbar');
        const menuIcon = document.getElementById('menuIcon');
        const isClickInsideNavbar = navbar.contains(event.target);
        const isClickOnIcon = menuIcon.contains(event.target);

        // Fechar navbar se o clique não for dentro dela ou no ícone
        if (!isClickInsideNavbar && !isClickOnIcon && navbar.style.left === '0px') {
            navbar.style.left = '-220px';
            menuIcon.classList.remove('active');
        }
    });
</script>
