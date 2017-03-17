	<div class="col-lg-4 col-md-6">
	<div class="panel panel-default" id="department-widget">
		<div class="panel-heading" data-container="body" >
			<h3 class="panel-title"><i class="fa fa-building"></i> <span data-i18n="department.widgettitle"></span></h3>
		</div>
		<div class="list-group scroll-box"></div>
	</div><!-- /panel -->
</div><!-- /col -->

<script>
$(document).on('appUpdate', function(e, lang) {
	
	var box = $('#department-widget div.scroll-box');
	
	$.getJSON( appUrl + '/module/department/get_department', function( data ) {
		
		box.empty();
		if(data.length){
			$.each(data, function(i,d){
				var badge = '<span class="badge pull-right">'+d.count+'</span>';
                box.append('<a href="'+appUrl+'/show/listing/department/department/#'+d.department+'" class="list-group-item">'+d.department+badge+'</a>')
			});
		}
		else{
			box.append('<span class="list-group-item">'+i18n.t('department.nodepartment')+'</span>');
		}
	});
});	
</script>

