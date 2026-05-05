<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('table.data-table').each(function () {
            let customConfig = $(this).data('config') || {};
            
            $(this).DataTable(Object.assign({
                pageLength: 10,
                responsive: true
            }, customConfig));
        });
    });
</script>
