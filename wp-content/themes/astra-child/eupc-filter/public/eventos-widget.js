
if(jQuery('.eupc-widget-eventos').length > 0 ){
  getFiltersEvents(jQuery('.eupc-widget-eventos'))
}

function getFiltersEvents(elem) {
  var urlQuery = ""
  var filters = jQuery(elem).data()
  Object.entries(filters).forEach(([key, ele]) => {
    urlQuery += ele.query +'&'
  })
  if(Object.entries(filters).length > 0){
    urlQuery = urlQuery.slice(0 ,-1)

  }
  
  console.log(urlQuery)

  getEvents(elem, urlQuery);
  // window.location.href = urlQuery
}


function getEvents(elem, urlQuery){

    jQuery.ajax({
        type: "post",
        url: "https://eventos.upc.edu.pe/wp-admin/admin-ajax.php",
        data: "action=get_events&" + urlQuery,
        beforeSend: function( ) {
          jQuery(elem).fadeTo( "slow", 0.33 )
        },
        success: function(result){
          jQuery(elem).fadeTo( "slow", 1 )
          
          
          if(result !== ''){
           
            jQuery(elem).html(result)
            
          }
          else{
            jQuery(elem).html('<div class="eupc-widget-eventos_msj">No hay eventos disponibles</div>')
          }
        }
    });

}




