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

    // const tableSpoNew = document.getElementById('spoNew');
    // const dataTableSpoNew = new simpleDatatables.DataTable(tableSpoNew);

    // dataTableSpoNew.on('draw', function() {
    //     const totalRows = dataTableSpoNew.rows().count();
    //     const footer = tableSpoNew.querySelector('tfoot tr');
    //     footer.innerHTML = `<th colspan="4">Total Rows: ${totalRows}</th>`;
    // });

    const datatableSpoNew = document.getElementById('datatableSpoNew');
    if (datatableSpoNew) {
        const spoTable = new simpleDatatables.DataTable(datatableSpoNew);

        spoTable.on('draw', function() {
            const totalRows = spoTable.rows().count();
            const footer = datatableSpoNew.querySelector('tfoot tr');
            footer.innerHTML = `<th colspan="5">Total Rows: ${totalRows}</th>`;
        });
    }

    const datatableSpoClose = document.getElementById('datatableSpoClose');
    if (datatableSpoClose) {
        const spoTable = new simpleDatatables.DataTable(datatableSpoClose);

        // spoTable.on('draw', function() {
        //     const totalRows = dataTable.rows().count();
        //     const footer = table.querySelector('tfoot tr');
        //     footer.innerHTML = `<th colspan="2">Total Rows: ${totalRows}</th>`;
        // });
    }
});
