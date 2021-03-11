(function( $ ) {
	'use strict';

	console.log('Admin Register JS ready.')

	jQuery(document).ready(function(){
		jQuery('#eupc-export_subscriptions').click(function() {
			$.ajax({
				type: "post",
				url: ajax_var.url,
				data: {
					action: "eupc_export_subscription_csv",
					nonce: ajax_var.nonce
				},
				success: function(result){
					download_csv_file(result, "subscriptions.csv")
					$(this).attr("disabled", false)
				},
				beforeSend: function(){
					$(this).attr("disabled", true)
				}
			});
		}) // Btn #eupc-export_subscriptions

		jQuery('#eupc-export_registers').click(function() {
			var event_id = jQuery(this).data('event_id')
			$.ajax({
				type: "post",
				url: ajax_var.url,
				data: {
					action: "eupc_export_registers_csv",
					nonce: ajax_var.nonce,
					event_id: event_id
				},
				success: function(result){
					download_csv_file(result, "evento-"+ event_id +"_registro.csv")
					$(this).attr("disabled", false)
				},
				beforeSend: function(){
					$(this).attr("disabled", true)
				}
			});
		}) // Btn #eupc-export_registers
	})

	function download_csv_file(string_csv, name = "exported_data") {  
     
    var hiddenElement = document.createElement('a');  
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(string_csv);  
    hiddenElement.target = '_blank';  
      
    //provide the name for the CSV file to be downloaded  
    hiddenElement.download = name;  
    hiddenElement.click();  
}  

	

})( jQuery );