<?php

// Add scripts to astra_footer_before()
add_action( 'astra_footer_before', 'add_share_before_header' );
function add_share_before_header() { ?>
    
    <section class="c-redes-info">
        <div class="fondo-onda">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/fondo-curva.svg" style="width:100%" class="f-deskt" alt="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/fondo2.svg" class="w-100 mobile" alt="">
        </div>
		<div class="container-fluid">
			<div class="row" style="position:relative">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="c-box-altavoz">
                                <div id="big-circle" class="circle big">
                                    <div>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/megafono-upc.png" >
                                    </div>
                                    <div class="circle one animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/linkedin-9.svg' class="img-fluid "></div>
                                    <div class="circle two animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/instagram-5.svg'></div>
                                    <div class="circle three animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/twitter-9.svg'></div>
                                    <div class="circle four animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/whatsapp-9.svg'></div>
                                    <div class="circle five animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/fb.svg'></div>
                                    <div class="circle six animation-redes"><img src='<?php echo get_stylesheet_directory_uri(); ?>/imgs/youtube-9.svg'></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <div class="c-text-dredes">
                                <h3 class="mb-1">SE PARTE DE LA CONVERSACIÓN EN LAS REDES <br> SOCIALES CON EL HASHTAG</h3>
                                <h2 class="mb-3">#EVENTOSUPC</h2>

                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </section>
    <section style="background:white" class="s-subscribete">
        <div class="container mt-1 mb-1">
                <div class="row center-vertical">
                    <div class="col-md-5">
                        <h2 class="m-0">SUSCRÍBETE</h2>
                        <h3 class="mb-1">ACCEDE A LOS MEJORES EVENTOS DE UPC</h3>
                    </div>
                    <div class="col-md-7">
                        <form id="form-subscribe">
                            <div class="input-subscribe">
                                <div><input type="email" name="email" placeholder="Correo@mail.com"></div>
                                <button >SUSCRIBIRME</button>
                            </div>
                        </form>        
                    </div>
                </div>
        </div>
    </section>
    <div class="modal">
        <!-- <div class="modal-overlay modal-toggle"></div> -->
        <div class="modal-wrapper modal-transition">
            <div>
                <a href="#" class="modal-close modal-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="19.559" height="19.559" viewBox="0 0 19.559 19.559"><defs><style>.a{fill:#797979;fill-rule:evenodd;}</style></defs><path class="a" d="M24.559,6.956,22.6,5l-7.824,7.824L6.956,5,5,6.956l7.824,7.824L5,22.6l1.956,1.956,7.824-7.824L22.6,24.559,24.559,22.6l-7.824-7.824Z" transform="translate(-5 -5)"/></svg></a>
            </div>
            <div class="layout-share-modal">
                <div class="embed-responsive">
					<figure>
						<h4>Comparte este evento con amigos y colegas</h4>
						<!-- <img class="eupc-ele_imagen img-fluid" src=""> -->
                        <div class="eupc-ele_imagen"></div>
						<h3 class="eupc-ele_titulo mt-1"></h3>
						<ul class="mt-1 mb-1">
						<li> <strong> Modalidad:</strong> <span class="eupc-ele_modalidad"></span></li>
						<li> <strong> Fecha:</strong> <span class="eupc-ele_fecha"></span></li>
						<!-- <li> <strong> Expositor:</strong> <span class="eupc-ele_expositor"></span></li> -->
						</ul>
					</figure>
					<div class="text-center redes-sociales mt-2">
						<a class="eupc-share" data-red="fb" href="#" id="share-face" target="_blank"><img src="https://res.cloudinary.com/upcbinary/image/upload/v1594050123/landings/short-course/icon-redes/icon-fb_mrhh35.svg" alt="fb"></a>
						<a class="eupc-share" data-red="ln" href="#" id="share-ln" target="_blank"><img src="https://res.cloudinary.com/upcbinary/image/upload/v1594050121/landings/short-course/icon-redes/icon-linkedin_majb9x.svg" alt="linke"></a>
                        <a class="eupc-share" data-red="tw" href="#" id="share-twitter" target="_blank"><img src="https://res.cloudinary.com/upcbinary/image/upload/v1594050119/landings/short-course/icon-redes/icon-twitter_jkehsl.svg" alt="twitter"></a>
						<a class="eupc-share" data-red="wp" href="#" id="share-whatsap" target="_blank"><img src="https://res.cloudinary.com/upcbinary/image/upload/v1594050117/landings/short-course/icon-redes/icon-whatsapp_n63fa5.svg" alt="whatsap"></a>
					</div>
				</div>
            </div>
        </div>
    </div>
    <section class="before-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mt-2">
                    <img src="https://res.cloudinary.com/upcbinary/image/upload/v1581547397/institucional/imagenes/logo-wasc-gris_edq7a8.png" alt="wasc">
                </div>
                <div class="col-md-6 mt-2">
                    <p class="parrafo2-tamaño">Prolongación Primavera 2390, Monterrico, Santiago de Surco
                        <br>Informes: 313-3333 - 610-5030 | Servicio al alumno 630-3333 | Fax: 313-3334
                        <br>
                        <a href="servicios/contacto-para-alumnos-upc/" target="_blank" class="a-dirección">Contacto</a>
                        |
                        <a href="https://www.upc.edu.pe/html/politica-y-terminos/0/politica-privacidad.htm" target="_blank" class="a-dirección">Política
                        de Privacidad</a> |
                        <a href="https://www.upc.edu.pe/html/politica-y-terminos/0/terminos-condiciones.htm" target="_blank" class="a-dirección">Términos
                        y Condiciones</a>
                    </p>
                </div>
                <div class="col-md-3 mt-2">
                    <div class="center-vertival">
                        <a href="https://www.facebook.com/upcedu" target="_blank" class="bg-iconos fb-icono cursor-pointer"></a>
                        <a href="https://www.youtube.com/user/UPCedupe" target="_blank" class="bg-iconos yt-icono cursor-pointer ml-2"></a>
                        <a href="https://twitter.com/upcedu" target="_blank" class="bg-iconos tw-icono cursor-pointer ml-2"></a>
                        <a href="https://plus.google.com/u/0/b/104625492165602926447/104625492165602926447/posts" target="_blank" class="bg-iconos gm-icono cursor-pointer ml-2"></a>
                    </div>
                </div>
            </div>
        </div>

    </section>


<?php }