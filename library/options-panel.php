<?php

if ( !function_exists( 'optionsframework_init' ) ) {

/*-----------------------------------------------------------------------------------*/
/* Tema de opciones del marco de desarrollo
/*-----------------------------------------------------------------------------------*/

/* Establece la ruta del archivo basado en si el Tema de opciones del marco de desarrollo es un tema principal o un tema hijo */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
}

require_once (get_template_directory() . '/admin/options-framework.php');

}

/* 
 * Esto es un ejemplo de como añadir scripts personalizados al panel de opciones.
 * Esto muestra/oculta la opción an cuando una casilla de verificación es marcada.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#showhidden_gradient').click(function() {
  		jQuery('#section-top_nav_bottom_gradient_color').fadeToggle(400);
	});
	
	if (jQuery('#showhidden_gradient:checked').val() !== undefined) {
		jQuery('#section-top_nav_bottom_gradient_color').show();
	}
	
	jQuery('#showhidden_themes').click(function() {
			jQuery('#section-wpbs_theme').fadeToggle(400);
	});
	
	if (jQuery('#showhidden_themes:checked').val() !== undefined) {
		jQuery('#section-wpbs_theme').show();
	}
	
	jQuery('#showhidden_slideroptions').click(function() {
		jQuery('#section-slider_options').fadeToggle(400);
	});

	if (jQuery('#showhidden_slideroptions:checked').val() !== undefined) {
		jQuery('#section-slider_options').show();
	}

});
</script>

<?php
}

/* 
 * Apaga el panel de opciones predeterminado de Twenty Eleven
 */
 
add_action('after_setup_theme','remove_twentyeleven_options', 100);

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}