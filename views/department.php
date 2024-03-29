<?php $this->view('partials/head', array('scripts' => array('clients/client_list.js'))); ?>

<?php //Initialize models needed for the table
new Machine_model;
new Reportdata_model;
new department_model;
new munkireport_model;
?>

<div class="container">

  <div class="row">

  	<div class="col-lg-12">

		  <h3><span data-i18n="department.report"></span> <span id="total-count" class='label label-primary'>…</span></h3>

		  <table class="table table-striped table-condensed table-bordered">
		    <thead>
		      <tr>
		      	<th data-i18n="department.name" data-colname='machine.computer_name'></th>
		        <th data-i18n="department.serial_number" data-colname='machine.serial_number'></th>
		        <th data-i18n="department.username" data-colname='reportdata.long_username'></th>
		        <th data-i18n="department.os" data-colname='machine.os_version'></th>
		        <th data-i18n="department.memory" data-colname='machine.physical_memory'></th>
		        <th data-i18n="department.description" data-colname='machine.machine_desc'></th>
		        <th data-i18n="department.storage_size" data-colname='diskreport.TotalSize'></th>
		        <th data-i18n="department.department" data-colname='department.department'></th>
		        <th data-i18n="munkireport.manifest.manifest" data-colname='munkireport.manifestname'></th>
		        <th data-colname='reportdata.timestamp'>Check-in</th>
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

	$(document).on('appReady', function(e, lang) {

		// Get column names from data attribute
		var columnDefs = [], //Column Definitions
            col = 0; // Column counter
		$('.table th').map(function(){
            columnDefs.push({name: $(this).data('colname'), targets: col, render: $.fn.dataTable.render.text()});
            col++;
		});
		var oTable = $('.table').dataTable( {
            ajax: {
                url: "<?php echo url('datatables/data'); ?>",
                type: "POST",
                data: function( d ){
                    // Look for 'osversion' statement
                    if(d.search.value.match(/^\d+\.\d+(\.(\d+)?)?$/)){
                        var search = d.search.value.split('.').map(function(x){return ('0'+x).slice(-2)}).join('');
                        d.search.value = search;
                    }
                    // Only search on bootvolume
                    d.where = [
                        {
                            table: 'diskreport',
                            column: 'MountPoint',
                            value: '/'
                        }
                    ];

                }
            },
            dom: mr.dt.buttonDom,
            buttons: mr.dt.buttons,
            columnDefs: columnDefs,
			createdRow: function( nRow, aData, iDataIndex ) {
				// Update name in first column to link
				var name=$('td:eq(0)', nRow).html();
				if(name == ''){name = "No Name"};
				var sn=$('td:eq(1)', nRow).html();
				var link = mr.getClientDetailLink(name, sn, '<?php echo url(); ?>/');
				$('td:eq(0)', nRow).html(link);
				
							// Format OS Version
				var osvers = mr.integerToVersion($('td:eq(3)', nRow).html());
				$('td:eq(3)', nRow).html(osvers);

                // Format filesize
                var fs=$('td:eq(6)', nRow).html();
                $('td:eq(6)', nRow).addClass('text-left').html(fileSize(fs, 0));

                // Format filesize
                var fs=$('td:eq(7)', nRow).html();
                $('td:eq(7)', nRow).addClass('text-left').html(fileSize(fs, 0));

                var mem=$('td:eq(4)', nRow).html();
                $('td:eq(4)', nRow).html(parseInt(mem) + ' GB');

				// Format date
				var checkin = parseInt($('td:eq(9)', nRow).html());
				var date = new Date(checkin * 1000);
				$('td:eq(9)', nRow).html(moment(date).fromNow());

            }
        } );
    } );
</script>

<?php $this->view('partials/foot'); ?>
