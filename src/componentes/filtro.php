<style>
    .btn.filtro {
        background-color: #006233;
        color: white;
        padding: 5px;
        font-size:18px;
    }

    .btn.filtro:hover {
    background-color: #004d28; 
    color: #FFFFFF;
}
</style>

<!-- Dropdown com ícone -->
<div class="dropdown" style="display: inline-block;">
    <button class="btn filtro btn-secondary dropdown-toggle mx-2" type="button" id="dropdownMenuButton"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-sliders filter-icon mx-2"></i>
    </button>
    <!-- Itens do dropdown -->
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle" style="color: orange;"></i> Alerta quantidade Média</a></li>
        <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle" style="color: red;"></i> Alerta quantidade Baixa</a></li>
    </ul>
</div>