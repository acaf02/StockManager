<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            overflow: hidden; /* Evita a rolagem quando a navbar está fechada */
        }

        .navbar {
            position: fixed;
            left: -220px; /* Começa fora da tela */
            top: 0;
            height: 100%;
            width: 150px;
            background-color: #ACB2AD; /* Cor da navbar */
            transition: left 0.3s;
            padding-top: 60px;
            z-index: 1000; /* Fica acima de outros elementos */
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Alinha os itens ao topo */
            align-items: flex-start;
        }

        .nav-item {
            padding-left: 10px;
            padding: 5px 15px; /* Padding menor entre os itens */
            color: black;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center; /* Centraliza ícones e texto verticalmente */
            margin-bottom: 5px; /* Pequena margem entre os itens */
        }

        .nav-item i {
            margin-right: 8px; /* Espaçamento entre ícone e texto */
        }

        .nav-item a {
            text-decoration: none;
        }

        .menu-icon {
            position: fixed;
            top: 18px;
            left: 20px;
            font-size: 24px;
            color: black;
            cursor: pointer;
            z-index: 1001; /* Acima da navbar */
        }

    </style>

    <div class="menu-icon" onclick="toggleNavbar()">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="navbar" id="navbar">
        <div class="nav-item">
        <a href="../../telas/estoque/estoque.php" style="color: black;">
            <i class="fas fa-warehouse"></i> Estoque
            </a>
        </div>
        <div class="nav-item">
        <a href="../../telas/cadastro/cadastro.php" style="color: black;">
            <i class="fas fa-circle-plus"></i> Cadastrar
            </a>
        </div>
        <div class="nav-item">
        <a href="../../telas/relatorio/relatorios.php" style="color: black;">
            <i class="fas fa-chart-pie"></i> Relatórios
            </a>
        </div>
    </div>

    <script>
        function toggleNavbar() {
            const navbar = document.getElementById('navbar');
            navbar.style.left = navbar.style.left === '0px' ? '-220px' : '0px'; // Ajuste para esconder completamente
        }
    </script>

