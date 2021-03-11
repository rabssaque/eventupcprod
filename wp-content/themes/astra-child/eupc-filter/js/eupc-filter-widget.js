

var filtersEvents = {}


jQuery(document).ready(function(){
  console.log('EUPC Filters Events ok')
  
})

jQuery('.woocommerce-ordering').hide()
loadFilterEvents();


jQuery('[id^="eupc-filter_"]').each(function(){
  
  if(
    jQuery(this).data('slug') === 'area_interes' || 
    jQuery(this).data('slug') === 'facultad' ||
    jQuery(this).data('slug') === 'carrera'
  ){
    jQuery(this).hide()
  }
  
  jQuery(this).change(function (){
  
    // Query
      
    if(jQuery(this).data('slug') === 'product_cat'){
      if(jQuery(this).val() !== ''){
        filtersEvents.product_cat = { 
          query: 'product_cat=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_product_cat option:selected").text()
        }
      } else{
        delete filtersEvents.product_cat
      }
    }
    if(jQuery(this).data('slug') === 'area_interes'){
      if(jQuery(this).val() !== ''){
        filtersEvents.area_interes = { 
          query: 'area_interes=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_area_interes option:selected").text()
        }
      } else{
        delete filtersEvents.area_interes
      }
    }
    if(jQuery(this).data('slug') === 'facultad'){
      if(jQuery(this).val() !== ''){
        filtersEvents.facultad = { 
          query: 'facultad=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_facultad option:selected").text()
        }
      } else{
        delete filtersEvents.facultad
      }
    }
    if(jQuery(this).data('slug') === 'carrera'){
      if(jQuery(this).val() !== ''){
        filtersEvents.carrera = { 
          query: 'carrera=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_carrera option:selected").text()
        }
      } else{
        delete filtersEvents.carrera
      }
    }
    if(jQuery(this).data('slug') === 'publico'){
      if(jQuery(this).val() !== ''){
        filtersEvents.publico = { 
          query: 'publico=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_publico option:selected").text()
        }
      } else{
        delete filtersEvents.publico
      }
    }
    if(jQuery(this).data('slug') === 'formato'){
      if(jQuery(this).val() !== ''){
        filtersEvents.formato = { 
          query: 'formato=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_formato option:selected").text()
        }
      } else{
        delete filtersEvents.formato
      }
    }
    if(jQuery(this).data('slug') === 'modalidad'){
      if(jQuery(this).val() !== ''){
        filtersEvents.modalidad = { 
          query: 'modalidad=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_modalidad option:selected").text()
        }
      } else{
        delete filtersEvents.modalidad
      }
    }
    if(jQuery(this).data('slug') === 'precio'){
      if(jQuery(this).val() !== ''){
        filtersEvents.precio = { 
          query: 'precio=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_precio option:selected").text()
        }
      } else{
        delete filtersEvents.precio
      }
    }
    if(jQuery(this).data('slug') === 'fecha'){
      if(jQuery(this).val() !== ''){
        filtersEvents.fecha = { 
          query: 'fecha=' + jQuery(this).val(),
          title: jQuery("#eupc-filter_fecha option:selected").text()
        }
      } else{
        delete filtersEvents.fecha
      }
    }
    if(jQuery(this).data('slug') === 'texto'){
      if(jQuery(this).val() !== ''){
        filtersEvents.texto = { 
          query: 'texto=' + jQuery(this).val()
        }
      } else{
        delete filtersEvents.texto
      }
    }

    

    // oculta/muestra filtros segun reglas de tipo de evento
    if(jQuery(this).data('slug') === 'product_cat'){

      if(jQuery(this).val() === 'postgrado'){

        jQuery('#eupc-filter_area_interes').show()
        hideFilter('facultad')
        hideFilter('carrera')
        
      } else if(jQuery(this).val() === 'upc-access' || jQuery(this).val() === 'innovate' ){

        jQuery('#eupc-filter_facultad').show()
        jQuery('#eupc-filter_carrera').show()
        hideFilter('area_interes')

      } else if(jQuery(this).val() === 'epe' || jQuery(this).val() === 'working-student'){

        jQuery('#eupc-filter_facultad').show()
        hideFilter('area_interes')
        hideFilter('carrera')

      } else {

        hideFilter('area_interes')
        hideFilter('facultad')
        hideFilter('carrera')

      }  
    }


    applyfilterEvents(filtersEvents)
  })
})

function hideFilter(slug){
  jQuery('#eupc-filter_'+slug).hide()
  jQuery('#eupc-filter_'+slug).val('')
  delete filtersEvents[slug]
}

function applyfilterEvents(filters, page = 0) {
  var urlQuery = ""
  var filtrosTitulos = ''
  Object.entries(filters).forEach(([key, ele]) => {
    urlQuery += ele.query +'&'
    if(ele.title){
      filtrosTitulos += ele.title + ', '
    }
    
  })
  if(Object.entries(filters).length > 0){
    urlQuery = urlQuery.slice(0 ,-1)
    if(page > 0){
      urlQuery += '&page=' + page

    }

    filtrosTitulos = filtrosTitulos.slice(0 ,-2)
    jQuery('h1.woocommerce-products-header__title').text(filtrosTitulos)

  } else{
    jQuery('h1.woocommerce-products-header__title').text('Eventos')
    if(page > 0){
      urlQuery += 'page=' + page
    }
  }
  
 
  console.log(urlQuery)

  window.history.replaceState(null, null, '?' + urlQuery);
  getEvents(urlQuery);
  // window.location.href = urlQuery
}

function loadFilterEvents(){
  const filterParams = new URLSearchParams(location.search);
  var filtrosTitulos = ''

  if(filterParams.get('product_cat') !== null){
    jQuery("#eupc-filter_product_cat").val(filterParams.get('product_cat'))
    filtersEvents.product_cat = { 
      query: 'product_cat=' + filterParams.get('product_cat'),
      title: jQuery("#eupc-filter_product_cat option:selected").text()
    }

    if(
      filterParams.get('product_cat') === 'pregrado' ||
      filterParams.get('product_cat') === 'epe' ||
      filterParams.get('product_cat') === 'postgrado'
      ){
      jQuery("#eupc-filter_product_cat").attr('disabled', 'disabled')
      jQuery(".menu-item").hide()
      switch(filterParams.get('product_cat')){
        case 'pregrado':
          jQuery(".menu-pregrado").show()
          break
        case 'epe':
          jQuery(".menu-epe").show()
          break
        case 'postgrado':
          jQuery(".menu-postgrado").show()
          break
        default:
      }
    }

  }
  if(filterParams.get('area_interes') !== null){
    jQuery("#eupc-filter_area_interes").val(filterParams.get('area_interes'))
    filtersEvents.area_interes = { 
      query: 'area_interes=' + filterParams.get('area_interes'),
      title: jQuery("#eupc-filter_area_interes option:selected").text()
    }
  }
  if(filterParams.get('facultad') !== null){
    jQuery("#eupc-filter_facultad").val(filterParams.get('facultad'))
    filtersEvents.facultad = { 
      query: 'facultad=' + filterParams.get('facultad'),
      title: jQuery("#eupc-filter_facultad option:selected").text()
    }
  }
  if(filterParams.get('carrera') !== null){
    jQuery("#eupc-filter_carrera").val(filterParams.get('carrera'))
    filtersEvents.carrera = { 
      query: 'carrera=' + filterParams.get('carrera'),
      title: jQuery("#eupc-filter_carrera option:selected").text()
    }
  }
  if(filterParams.get('publico') !== null){
    jQuery("#eupc-filter_publico").val(filterParams.get('publico'))
    filtersEvents.publico = { 
      query: 'publico=' + filterParams.get('publico'),
      title: jQuery("#eupc-filter_publico option:selected").text()
    }
    
  }
  if(filterParams.get('formato') !== null){
    jQuery("#eupc-filter_formato").val(filterParams.get('formato'))
    filtersEvents.formato = { 
      query: 'formato=' + filterParams.get('formato'),
      title: jQuery("#eupc-filter_formato option:selected").text()
    }
  
  }
  if(filterParams.get('modalidad') !== null){
    jQuery("#eupc-filter_modalidad").val(filterParams.get('modalidad'))
    filtersEvents.modalidad = { 
      query: 'modalidad=' + filterParams.get('modalidad'),
      title: jQuery("#eupc-filter_modalidad option:selected").text()
    }
  }
  if(filterParams.get('precio') !== null){
    jQuery("#eupc-filter_precio").val(filterParams.get('precio'))
    filtersEvents.precio = { 
      query: 'precio=' + filterParams.get('precio'),
      title: jQuery("#eupc-filter_precio option:selected").text()
    }
  }
  if(filterParams.get('fecha') !== null){
    jQuery("#eupc-filter_fecha").val(filterParams.get('fecha'))
    filtersEvents.precio = { 
      query: 'fecha=' + filterParams.get('fecha'),
      title: jQuery("#eupc-filter_fecha option:selected").text()
    }
  }
  if(filterParams.get('texto') !== null){
    jQuery("#eupc-filter_text").val(filterParams.get('texto'))
    filtersEvents.texto = { 
      query: 'texto=' + filterParams.get('texto')
    }
  }

  Object.entries(filtersEvents).forEach(([key, ele]) => {
    if(ele.title){
      filtrosTitulos += ele.title + ', '
    }
  })

  if(filtrosTitulos.length>0){
    filtrosTitulos = filtrosTitulos.slice(0 ,-2)
    jQuery('h1.woocommerce-products-header__title').text(filtrosTitulos)
  }

  var foundCount = jQuery('ul.products li').length
  jQuery('#main p.woocommerce-result-count').text('Resultados: '+ foundCount +' evento(s)')
  
}

function activePagination(){
  jQuery('.woocommerce-pagination ul li a').click(function (){
    var pageParam = jQuery(this).attr('href').slice(1)
    
    applyfilterEvents(filtersEvents, pageParam)

    return false
  })

}


function getEvents(urlQuery){

    jQuery.ajax({
        type: "post",
        url: ajax_var_filter.url,
        data: "action=" + ajax_var_filter.action + "&nonce=" + ajax_var_filter.nonce + "&" + urlQuery,
        beforeSend: function( ) {
          jQuery('#main ul.products').fadeTo( "slow", 0.33 )
          jQuery('#main .woocommerce-pagination').fadeTo( "slow", 0.33 )
          jQuery('#main p.woocommerce-info').fadeTo( "slow", 0.33 )
          jQuery('#main p.woocommerce-result-count').fadeTo( "slow", 0.33 )

        },
        success: function(result){
          jQuery('#main p.woocommerce-info').remove()
          jQuery('#main ul.products').remove()
          jQuery('#main p.woocommerce-result-count').remove()
          jQuery('#main .woocommerce-pagination').remove()
          
          if(result.length > 0){
           
            jQuery('#main > div').append(result)
            activePagination()
            
          }
          else{
            jQuery('#main ul.products').remove()
            jQuery('#main p.woocommerce-info').remove()
            
            jQuery('#main > div header').after('<p class="woocommerce-info">No se encontraron productos que concuerden con la selección.</p>')
            jQuery('#main p.woocommerce-result-count').remove()
          }
        }
    });

}





