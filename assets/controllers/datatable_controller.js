import { Controller } from '@hotwired/stimulus';
import DataTable from 'datatables.net';
import 'datatables.net-bs5';

/**
 * @property {HTMLTableElement} tableTarget
 * @property {boolean}          hasTableTarget
 * @property {number}           orderColumnValue
 * @property {string}           orderDirValue
 */
export default class extends Controller {

    /** @type {import('datatables.net').Api | null} */
    dt = null;

    static targets = ['table'];

    static values = {
        orderColumn: { type: Number, default: -1 },
        orderDir:    { type: String, default: 'asc' },
    };

    connect() {
        if (!this.hasTableTarget || DataTable.isDataTable(this.tableTarget)) return;

        const order = this.orderColumnValue >= 0
            ? [[this.orderColumnValue, this.orderDirValue]]
            : [];

        this.dt = new DataTable(this.tableTarget, { order });
    }

    disconnect() {
        this.dt?.destroy();
        this.dt = null;
    }
}
