<style>
    #filterPanel {
        display: none;
        position: absolute;
        right: 30px;
        top: 50px;
        width: 200px;
        background: #f0f0f0;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .form-check {
        margin: 10px 0;
        display: flex;
        align-items: center;
    }

    .form-check label {
        margin-left: 8px;
        font-size: 14px;
    }

    .filter-icon {
        font-size: 24px;
        position: relative;
        cursor: pointer;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: inline-block;
    }

    .filter-icon.active {
        background-color: white;
        color: black;
    }
</style>

<div id="filterPanel">
    <div class="form-check">
        <input type="checkbox" id="alertaMedia" class="form-check-input" onchange="applyFilters()">
        <label for="alertaMedia">
            <i class="fas fa-exclamation-triangle" style="color: orange;"></i> Alerta quantidade Média
        </label>
    </div>
    <div class="form-check">
        <input type="checkbox" id="alertaBaixa" class="form-check-input" onchange="applyFilters()">
        <label for="alertaBaixa">
            <i class="fas fa-exclamation-triangle" style="color: red;"></i> Alerta quantidade Baixa
        </label>
    </div>
</div>

<script>
    function abrirFilterPanel() {
        const filterPanel = document.getElementById("filterPanel");
        const filterIcon = document.getElementById("filterIcon");

        if (filterPanel.style.display === "none" || filterPanel.style.display === "") {
            filterPanel.style.display = "block";
            filterIcon.classList.add('active');
        } else {
            filterPanel.style.display = "none";
            filterIcon.classList.remove('active');
        }
    }

    document.addEventListener('click', function (event) {
        const filterPanel = document.getElementById('filterPanel');
        const filterIcon = document.getElementById('filterIcon');

        const isClickInsideFiltro = filterPanel.contains(event.target);
        const isClickOnIcon = filterIcon.contains(event.target);

        if (!isClickInsideFiltro && !isClickOnIcon) {
            filterPanel.style.display = "none";
            filterIcon.classList.remove('active');
        }
    });

    document.getElementById("alertaMedia").addEventListener("change", function () {
        if (this.checked) {
            document.getElementById("alertaBaixa").checked = false;
        }
    });

    document.getElementById("alertaBaixa").addEventListener("change", function () {
        if (this.checked) {
            document.getElementById("alertaMedia").checked = false;
        }
    });

    function applyFilters() {
        const alertaMedia = document.getElementById("alertaMedia").checked;
        const alertaBaixa = document.getElementById("alertaBaixa").checked;

        if (alertaBaixa) {
            sortLowQuantity();
        } else if (alertaMedia) {
            // Pode adicionar uma função de ordenação específica para quantidade média, se necessário
            // Por enquanto, o exemplo só trata de 'quantidade baixa'
            sortLowQuantity(); 
        } else {
            resetTableOrder();
        }
    }

    function sortLowQuantity() {
    const table = document.querySelector("table tbody");
    const rows = Array.from(table.querySelectorAll("tr"));

    const lowQuantityRows = rows.filter(row => {
        const quantity = parseInt(row.cells[2].innerText);
        const minQuantity = parseInt(row.getAttribute("data-min-quantity"));
        return quantity < minQuantity;
    });

    const otherRows = rows.filter(row => {
        const quantity = parseInt(row.cells[2].innerText);
        const minQuantity = parseInt(row.getAttribute("data-min-quantity"));
        return quantity >= minQuantity;
    });

    lowQuantityRows.sort((rowA, rowB) => parseInt(rowA.cells[2].innerText) - parseInt(rowB.cells[2].innerText));

    table.innerHTML = "";
    lowQuantityRows.forEach(row => table.appendChild(row));
    otherRows.forEach(row => table.appendChild(row));
}


    function resetTableOrder() {
        const table = document.getElementById("inventario");
        const rows = Array.from(table.querySelectorAll("tbody tr"));

        // Aqui, reorganize as linhas na ordem original (se necessário)
        rows.sort((rowA, rowB) => {
            return parseInt(rowA.dataset.originalIndex) - parseInt(rowB.dataset.originalIndex);
        });

        const tbody = table.querySelector("tbody");
        tbody.innerHTML = "";

        rows.forEach(row => tbody.appendChild(row));
    }
</script>
