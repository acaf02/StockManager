<div class="header">
    <div class="header-home table-hover">
        <a href="../../telas/inicio/inicio.php" class="hover-effect">
            <i class="fas fa-house"></i>
        </a>
    </div>
    <div class="logo">
        <a href="../../telas/inicio/inicio.php" class="hover-effect">
            <img src="../../assets/imagens/logoSM.png" style="width: 120px; height: 45px;" alt="Logo">
        </a>
    </div>
    <div class="header-icon">
        <a href="../../componentes/logout.php" class="hover-effect">
            <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 24px;"></i>
        </a>
    </div>
</div>


<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ACB2AD;
        padding: 10px 20px;
    }

    .logo {
        flex: 1;
        text-align: center;
    }

    .header-icon {
        font-size: 30px;
        color: #black;
        cursor: pointer;
    }

    .header-home {
        padding-top: 4px;
        padding-left: 40px;
        font-size: 22px;
    }

    .header a {
        color: black;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .header a:hover {
        color: #FFFFFF;
        transform: scale(1.1);
    }
</style>