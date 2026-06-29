import 'bootstrap/dist/css/bootstrap.min.css';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'bootstrap';
import './stimulus_bootstrap.js';
import './styles/app.css';

import DataTable from 'datatables.net';
import 'datatables.net-bs5';

function initDataTables() {
    document.querySelectorAll('.data-table').forEach(table => {
        if (DataTable.isDataTable(table)) return;
        const column = table.dataset.orderColumn;
        const dir = table.dataset.orderDir || 'asc';
        const order = column ? [[parseInt(column), dir]] : [];
        new DataTable(table, { order });
    });
}

function destroyDataTables() {
    document.querySelectorAll('.data-table').forEach(table => {
        if (DataTable.isDataTable(table)) {
            // Get the existing instance and destroy it
            const dt = DataTable.getOrCreateInstance(table);
            dt.destroy();
        }
    });
}

// Turbo events
document.addEventListener('turbo:load', initDataTables);
document.addEventListener('turbo:before-cache', destroyDataTables);

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
