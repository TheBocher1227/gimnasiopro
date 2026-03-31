{{-- Controles tipo DataTables: Buscador + Mostrar X + Paginación --}}
<style>
    .table-controls-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .table-show {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: #6b7280;
    }

    .table-show select {
        padding: 6px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.82rem;
        font-family: inherit;
        color: #111827;
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    .table-show select:focus {
        border-color: #6366f1;
    }

    .table-search {
        position: relative;
    }

    .table-search input {
        padding: 8px 14px 8px 34px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: inherit;
        color: #111827;
        background: #fff;
        outline: none;
        width: 240px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .table-search input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .table-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: #9ca3af;
        pointer-events: none;
    }

    .table-controls-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .table-info {
        font-size: 0.78rem;
        color: #6b7280;
    }

    .table-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .table-pagination button {
        padding: 6px 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #374151;
        border-radius: 6px;
        font-size: 0.78rem;
        font-family: inherit;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
    }

    .table-pagination button:hover:not(:disabled) {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .table-pagination button:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .table-pagination button.active {
        background: #111827;
        color: #fff;
        border-color: #111827;
    }

    @media (max-width: 640px) {
        .table-search input {
            width: 160px;
        }

        .table-controls-top,
        .table-controls-bottom {
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = document.getElementById('dataTable');
    if (!table) return;

    var tbody = table.querySelector('tbody');
    if (!tbody) return;

    var allRows = Array.from(tbody.querySelectorAll('tr'));
    var filteredRows = allRows.slice();
    var perPage = 10;
    var currentPage = 1;
    var sortCol = -1;
    var sortDir = 'asc';

    var showSelect = document.getElementById('tcPerPage');
    var searchInput = document.getElementById('tcSearch');
    var infoEl = document.getElementById('tcInfo');
    var pagEl = document.getElementById('tcPagination');

    function getCellValue(row, col) {
        var cell = row.querySelectorAll('td')[col];
        if (!cell) return '';
        return cell.textContent.trim();
    }

    function compareValues(a, b) {
        var numA = parseFloat(a.replace(/[^0-9.\-]/g, ''));
        var numB = parseFloat(b.replace(/[^0-9.\-]/g, ''));
        if (!isNaN(numA) && !isNaN(numB)) {
            return numA - numB;
        }
        return a.localeCompare(b, 'es');
    }

    function sortRows() {
        if (sortCol < 0) return;
        filteredRows.sort(function(a, b) {
            var valA = getCellValue(a, sortCol);
            var valB = getCellValue(b, sortCol);
            var result = compareValues(valA, valB);
            return sortDir === 'asc' ? result : -result;
        });
    }

    function filterRows() {
        var q = (searchInput ? searchInput.value : '').toLowerCase().trim();
        if (!q) {
            filteredRows = allRows.slice();
        } else {
            filteredRows = allRows.filter(function(row) {
                return row.textContent.toLowerCase().indexOf(q) !== -1;
            });
        }
        sortRows();
        currentPage = 1;
        render();
    }

    function render() {
        var total = filteredRows.length;
        var totalPages = Math.ceil(total / perPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;

        var start = (currentPage - 1) * perPage;
        var end = Math.min(start + perPage, total);

        // Re-append rows in sorted order so DOM order matches
        allRows.forEach(function(r) { r.style.display = 'none'; });
        for (var i = 0; i < filteredRows.length; i++) {
            tbody.appendChild(filteredRows[i]);
            filteredRows[i].style.display = (i >= start && i < end) ? '' : 'none';
        }

        if (infoEl) {
            if (total === 0) {
                infoEl.textContent = 'Sin resultados';
            } else {
                infoEl.textContent = 'Mostrando ' + (start + 1) + ' a ' + end + ' de ' + total + ' registros';
            }
        }

        if (pagEl) {
            var html = '';
            html += '<button ' + (currentPage <= 1 ? 'disabled' : '') + ' data-page="' + (currentPage - 1) + '">Anterior</button>';

            var maxBtns = 5;
            var startBtn = Math.max(1, currentPage - 2);
            var endBtn = Math.min(totalPages, startBtn + maxBtns - 1);
            if (endBtn - startBtn < maxBtns - 1) startBtn = Math.max(1, endBtn - maxBtns + 1);

            for (var p = startBtn; p <= endBtn; p++) {
                html += '<button class="' + (p === currentPage ? 'active' : '') + '" data-page="' + p + '">' + p + '</button>';
            }

            html += '<button ' + (currentPage >= totalPages ? 'disabled' : '') + ' data-page="' + (currentPage + 1) + '">Siguiente</button>';
            pagEl.innerHTML = html;
        }
    }

    if (showSelect) {
        showSelect.addEventListener('change', function() {
            perPage = parseInt(this.value);
            currentPage = 1;
            render();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    if (pagEl) {
        pagEl.addEventListener('click', function(e) {
            var btn = e.target.closest('button');
            if (btn && !btn.disabled && btn.dataset.page) {
                currentPage = parseInt(btn.dataset.page);
                render();
            }
        });
    }

    // Sortable headers
    var headers = table.querySelectorAll('th.sortable');
    headers.forEach(function(th) {
        th.addEventListener('click', function() {
            var col = parseInt(th.dataset.col);
            headers.forEach(function(h) {
                if (h !== th) h.classList.remove('asc', 'desc');
            });

            if (sortCol === col) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortCol = col;
                sortDir = 'asc';
            }

            th.classList.remove('asc', 'desc');
            th.classList.add(sortDir);

            filterRows();
        });
    });

    render();
});
</script>
