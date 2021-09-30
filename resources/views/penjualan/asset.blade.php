<script>
    var getTotalQty = function () {
        var totalBarang = 0;
        $('#penjualan-barang [type=number]:not([disabled])').each(function() {
            totalBarang += Number($(this).val());
        });

        $('#total-barang').text(totalBarang);
    };

    $(document).ready(function () {
        // trigger calc
        getTotalQty();
        $(document).on('change blur','#penjualan-barang [type=number]', function () {
            getTotalQty();
        });
        // trigger btn remove
        $(document).on('click','#penjualan-barang .btn-remove', function () {
            if(confirm('Are you sure remove this row?')) {
                $(this).closest('tr').remove();
            }
            getTotalQty();
        });
        // trigger btn add
        $(document).on('click','#btn-add', function () {
            var $tableSel = $(this).closest('table');
            var rowCloned = $tableSel.find("tfoot#row-to-clone").clone();
            rowCloned.find("[disabled]").removeAttr("disabled");
            $tableSel.find('tbody').append(rowCloned.html());
            getTotalQty();
        });
    });
</script>
