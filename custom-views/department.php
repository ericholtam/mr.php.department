<?php $this->view('partials/head', array('scripts' => array('clients/client_list.js'))); ?>

<?php //Initialize models needed for the table
new Machine_model;
new Reportdata_model;
new department_model;
?>

<div class="container">

  <div class="row">

        <div class="col-lg-12">

            <h3><span data-i18n="listing.department.title">Department report</span> <span id="total-count" class='label label-primary'>…</span></h3>

            <table class="table table-striped table-condensed table-bordered">
            <thead>
              <tr>
                <th data-i18n="listing.computername" data-colname='machine.computer_name'></th>
                <th data-i18n="serial" data-colname='machine.serial_number'></th>
                <th data-i18n="listing.username" data-colname='reportdata.long_username'></th>
                <th data-i18n="listing.department.status" data-colname='department.status'>Status</th>
                <th data-i18n="listing.department.department" data-colname='department.department'>Department</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="dataTables_empty">Loading data from server</td>
                </tr>
            </tbody>
            </table>
    </div> <!-- /span 12 -->
  </div> <!-- /row -->
</div>  <!-- /container -->

<script type="text/javascript">

$(document).on('appUpdate', function(e){

    var oTable = $('.table').DataTable();
    oTable.ajax.reload();
    return;

});


$(document).on('appReady', function() {

    // Get modifiers from data attribute
    var columnDefs = [],
        col = 0; // Column counter
    $('.table th').map(function(){
          columnDefs.push({name: $(this).data('colname'), targets: col});
          col++;
    });

    oTable = $('.table').dataTable( {
        ajax: {
            url: "<?=url('datatables/data')?>",
            type: "POST"
        },
        columnDefs: columnDefs,
        createdRow: function( nRow, aData, iDataIndex ) {
            // Update name in first column to link
            var name=$('td:eq(0)', nRow).html();
            if(name == ''){name = "No Name"};
            var sn=$('td:eq(1)', nRow).html();
            var link = get_client_detail_link(name, sn, '<?=url()?>/', '#tab_summary');
            $('td:eq(0)', nRow).html(link);

            // Translate bool. todo function for any bool we find
            var status=$('td:eq(7)', nRow).html();
            status = status == 1 ? 'Yes' :
            (status === '0' ? 'No' : '')
            $('td:eq(7)', nRow).html(status)

        }
    });
});
</script>


<?php $this->view('partials/foot'); ?>