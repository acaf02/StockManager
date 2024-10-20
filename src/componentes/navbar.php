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
        background-color: #ACB2AD;
        transition: left 0.3s;
        padding-top: 60px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
    }

    /* Certifique-se de que cada item da navbar ocupe todo o espaço */
    .nav-item {
        width: 100%; /* Ocupa a largura total da navbar */
        padding: 10px 15px;
        color: black;
        text-align: left;
        cursor: pointer;
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        transition: background-color 0.3s ease; /* Transição suave para a cor de fundo */
    }

    /* O hover deve afetar o item inteiro */
    .nav-item:hover {
        background-color: #333333; /* Cor de fundo ao passar o mouse sobre o item */
    }

    /* O texto e o ícone do link */
    .nav-item a {
        text-decoration: none;
        color: black; /* Cor do texto do link */
        transition: color 0.3s ease, transform 0.3s ease; /* Transições de cor e tamanho */
        display: flex;
        align-items: center;
        width: 100%; /* O link ocupa a largura total do item */
    }

    /* O efeito hover dentro do link, ao passar o mouse */
    .nav-item a:hover {
        color: #FFFFFF; /* Cor do texto ao passar o mouse */
        transform: scale(1.1); /* Aumenta o tamanho ao passar o mouse */
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
        z-index: 1001; /* Acima da navbar */
    }

    .menu-icon a {
        color: black;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .menu-icon:hover {
        color: #FFFFFF; /* Cor ao passar o mouse sobre o ícone */
        transform: scale(1.1); /* Aumenta o tamanho do ícone ao passar o mouse */
    }
</style>

<div class="menu-icon" onclick="alterarNavbar()">
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
    function alterarNavbar() {
        const navbar = document.getElementById('navbar');
        navbar.style.left = navbar.style.left === '0px' ? '-220px' : '0px';
    }
</script>
