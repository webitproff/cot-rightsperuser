$(function() {
	// Auto-complete for username
	$('input.user').autocomplete('index.php?r=autocomplete', {minChars: 3});
	// Load options via AJAX when code is changed
	$('select.code').change(function() {
		var id = ($(this).attr('id').split('_'))[1];
		$.ajax({
			url: "index.php?r=rightsperuser&code=" + $(this).val(),
			success: function(data) {
				var options = $('select#opt_'+id);
				var optHtml = '';
				for (var i = 0; i < data.length; i++) {
					optHtml += '<option>' + data[i] + '</option>';
				}
				options.html(optHtml);
			}
		});
	});
});