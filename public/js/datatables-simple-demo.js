window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    const tableNominalKertas = document.getElementById('tableNominalKertas');
    if (tableNominalKertas) {
        new simpleDatatables.DataTable(tableNominalKertas);
    }

    const tableNominalKoin = document.getElementById('tableNominalKoin');
    if (tableNominalKoin) {
        new simpleDatatables.DataTable(tableNominalKoin);
    }
});
