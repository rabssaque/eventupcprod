
var $thisTab;
jQuery('.tab-titulos li').on('click', function(){
    $thisTab = jQuery(this).attr('data-tab')
    jQuery('.tab-cuerpo > div').hide()
    jQuery('#'+ $thisTab).show()
    jQuery('.tab-titulos li').removeClass('active-tab-form')
    jQuery(this).addClass('active-tab-form')
})
// var $ = jQuery;



jQuery('.sliders-general').each(function (key, item) {
        var id = jQuery(this).attr('id')
        var sliderId = "#" + id
        // var appenArrowsClassName = "#" + id + 'slider__arrows';
        // console.log(item)
        var $prev = jQuery(item).siblings('.prev');
        var $next = jQuery(item).siblings('.next');

jQuery(sliderId).slick({
      autoplay: true,
      autoplaySpeed: 3500,
      dots: true,
      infinite: true,
      prevArrow: $prev,
      nextArrow: $next,
      arrows: true,
      appenArrows: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
    })

    if(jQuery('li.product_cat-institucional').length == 2){
      jQuery('li.product_cat-institucional').addClass('grilla-w-50')
    }
  })

  var btn = jQuery('.search-button'),
  val_length;
  jQuery('.search-c input').keyup(function () {
    val_length = jQuery(this).val().length;
    if ( val_length > 0 ) {
      btn.addClass('typed');
    } else {
      btn.removeClass('typed');
    }
  });
  btn.click(function () {
    if ( val_length > 0 ) {
      jQuery('.search-c input').val('').trigger('keyup').focus();
    }
  });


  jQuery('.modal-toggle').on('click', function(event) {
    event.preventDefault();
    // jQuery('.eupc-ele_imagen').attr('src', jQuery(this).data('ele_imagen'))
    jQuery('.eupc-ele_imagen').css('background-image', 'url("' + jQuery(this).data('ele_imagen') + '")')
    jQuery('.eupc-ele_titulo').text(jQuery(this).data('ele_titulo'))
    jQuery('.eupc-ele_modalidad').text(jQuery(this).data('ele_modalidad'))
    jQuery('.eupc-ele_fecha').text(jQuery(this).data('ele_fecha'))
    jQuery('.eupc-ele_expositor').text(jQuery(this).data('ele_expositor'))
    jQuery('.eupc-share').attr('href', jQuery(this).data('ele_link'))
    jQuery('.modal').toggleClass('is-visible');
    jQuery('body').toggleClass('hide-scroll');
  });


  jQuery(window).scroll(function(){
    if (jQuery(this).scrollTop() > 120) {
          jQuery('.site-header').addClass('fixed-header');
      } else {
          jQuery('.site-header').removeClass('fixed-header');
      }
  });

  // Redes
  jQuery('.eupc-share').click(function() {
    var linkRed = jQuery(this).data('red')
    var linkEvento = jQuery(this).attr('href')
    var finalLink = ''
    switch(linkRed){
      case 'fb':
        finalLink = "https://www.facebook.com/sharer/sharer.php?u=" + linkEvento
        break
      case 'ln':
        finalLink = "https://www.linkedin.com/sharing/share-offsite/?url=" + linkEvento
        break
      case 'tw':
        finalLink = "https://twitter.com/intent/tweet?text=" + linkEvento
        break
      case 'wp':
        finalLink = "whatsapp://send?text=" + linkEvento
        break
      
      default:

    }

    window.open(finalLink, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=600,height=450")
    
    return false
  })