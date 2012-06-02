<?php

/**
 * WooThemes Media Library-driven AJAX File Uploader Module (2010-11-05)
 *
 * Modificado levemente para ser usado en el framework de opciones.
 */

if ( is_admin() ) {
	
	// Carga css y js adicionales para la carga de imágenes en la página de opciones del framework
	$of_page= 'appearance_page_options-framework';
	add_action( "admin_print_styles-$of_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$of_page", 'optionsframework_mlu_js', 0 );	
}

/**
 * Establece una entrada personalizada para adjuntar la imagen. Esto nos permite tener
 * galerías individuales para diferentes cargadores.
 */

if ( ! function_exists( 'optionsframework_mlu_init' ) ) {
	function optionsframework_mlu_init () {
		register_post_type( 'optionsframework', array(
			'labels' => array(
				'name' => __( 'Contenedor interno del framework de opciones','optionsframework' ),
			),
			'public' => true,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'supports' => array( 'title', 'editor' ), 
			'query_var' => false,
			'can_export' => true,
			'show_in_nav_menus' => false
		) );
	}
}

/**
 * Agrega el archivo Thickbox CSS e imágenes especificas de botón y carga a la cabecera
 * en las páginas donde esta función es llamada.
 */

if ( ! function_exists( 'optionsframework_mlu_css' ) ) {

	function optionsframework_mlu_css () {
	
		$_html = '';
		$_html .= '<link rel="stylesheet" href="' . site_url() . '/' . WPINC . '/js/thickbox/thickbox.css" type="text/css" media="screen" />' . "\n";
		$_html .= '<script type="text/javascript">
		var tb_pathToImage = "' . site_url() . '/' . WPINC . '/js/thickbox/loadingAnimation.gif";
	    var tb_closeImage = "' . site_url() . '/' . WPINC . '/js/thickbox/tb-close.png";
	    </script>' . "\n";
	    
	    echo $_html;
		
	}

}

/**
 * Registre y encola (cargas) el archivo JavaScript necesario para trabajar con el
 * modulo de carga de archivos AJAX, Media Library-driven.
 */

if ( ! function_exists( 'optionsframework_mlu_js' ) ) {

	function optionsframework_mlu_js () {
	
		// Registra scripts personalizados para el cargador AJAX Librería de medios.
		wp_register_script( 'of-medialibrary-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/of-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
		wp_enqueue_script( 'of-medialibrary-uploader' );
		wp_enqueue_script( 'media-upload' );
	}

}

/**
 * Cargador de medios usando la Librería de medios de WordPress
 * 
 * Parámetros:
 * - string $_id - Una señal para identificar este campo (el nombre)
 * - string $_value - El valor de este campo, si esta presente.
 * - string $_mode - El modo de presentación del campo.
 * - string $_desc - Una descripción adicional del campo.
 * - int $_postid - Un identificador opcional de la entrada (usado en las cajas meta).
 *
 * Dependencias:
 * - optionsframework_mlu_get_silentpost()
 */

if ( ! function_exists( 'optionsframework_medialibrary_uploader' ) ) {

	function optionsframework_medialibrary_uploader( $_id, $_value, $_mode = 'full', $_desc = '', $_postid = 0, $_name = '') {
	
		$optionsframework_settings = get_option('optionsframework');
		
		// Obtiene un id único de opciones
		$option_name = $optionsframework_settings['id'];
	
		$output = '';
		$id = '';
		$class = '';
		$int = '';
		$value = '';
		$name = '';
		
		$id = strip_tags( strtolower( $_id ) );
		// Cambia para cada campo, usando una entrada "silenciosa". Si no hay una entrada presente, una será creada.
		$int = optionsframework_mlu_get_silentpost( $id );
		
		// Si un valor el proporcionado y no tenemos un valor guardado, usa el valor que ha sido proporcionado.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}
		
		if ($_name != '') {
			$name = $option_name.'['.$id.']['.$_name.']';
		}
		else {
			$name = $option_name.'['.$id.']';
		}
		
		if ( $value ) { $class = ' has-file'; }
		$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" />' . "\n";
		$output .= '<input id="upload_' . $id . '" class="upload_button button" type="button" value="' . __( 'Subir','optionsframework' ) . '" rel="' . $int . '" />' . "\n";
		
		if ( $_desc != '' ) {
			$output .= '<span class="of_metabox_desc">' . $_desc . '</span>' . "\n";
		}
		
		$output .= '<div class="screenshot" id="' . $id . '_image">' . "\n";
		
		if ( $value != '' ) { 
			$remove = '<a href="javascript:(void);" class="mlu_remove button">Eliminar</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				$output .= '<img src="' . $value . '" alt="" />'.$remove.'';
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No hay previsualización si no existe una imagen.			
				$output .= '';
			
				// Salida estándar si no es una imagen.	
				$title = __( 'Ver archivo', 'optionsframework' );
				$output .= '<div class="no_image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span>' . $remove . '</div>';
			}	
		}
		$output .= '</div>' . "\n";
		return $output;
	}	
}

/**
 * Usa entradas "silenciosas" en la base de datos para almacenar las relaciones entre imágenes.
 * Esto además facilita la posibilidad de coleccionar galerías de, por ejemplo, imágenes de logos.
 * 
 * Retorna: $_postid.
 * 
 * Si no hay entradas "silenciosas" presentes, una será creada con el tipo "optionsframework"
 * y el nombre (post_name) "of-$_token".
 * 
 * Ejemplo de uso:
 * optionsframework_mlu_get_silentpost ( 'of_logo' );
 */

if ( ! function_exists( 'optionsframework_mlu_get_silentpost' ) ) {

	function optionsframework_mlu_get_silentpost ( $_token ) {
	
		global $wpdb;
		$_id = 0;
	
		// Verifica en una lista blanca si la señal es valida.
		// $_whitelist = array( 'of_logo', 'of_custom_favicon', 'of_ad_top_image' );
		// Descontamina la señal.
		
		$_token = strtolower( str_replace( ' ', '_', $_token ) );
		
		// if ( in_array( $_token, $_whitelist ) ) {
		if ( $_token ) {
			
			// Le dice a la función que buscar en una entrada.
			
			$_args = array( 'post_type' => 'optionsframework', 'post_name' => 'of-' . $_token, 'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed' );
			
			// Busca en la base de datos una entrada "silenciosa" que cumpla los criterios de búsqueda.
			$query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';
			foreach ( $_args as $k => $v ) {
				$query .= ' AND ' . $k . ' = "' . $v . '"';
			} // Fin del loop FOREACH
			
			$query .= ' LIMIT 1';
			$_posts = $wpdb->get_row( $query );
			
			// Si tenemos una entrada, la recorre y obtiene su ID.
			if ( count( $_posts ) ) {
				$_id = $_posts->ID;
			} else {
			
				// Si no hay una entrada presente, inserta una.
				// Prepara alguna información adicional para acompañar la creación de la entrada.
				$_words = explode( '_', $_token );
				$_title = join( ' ', $_words );
				$_title = ucwords( $_title );
				$_post_data = array( 'post_title' => $_title );
				$_post_data = array_merge( $_post_data, $_args );
				$_id = wp_insert_post( $_post_data );
			}	
		}
		return $_id;
	}
}

/**
 * Ejecuta código dentro de la ventana emergente Librería de medios.
 */

if ( ! function_exists( 'optionsframework_mlu_insidepopup' ) ) {

	function optionsframework_mlu_insidepopup () {
	
		if ( isset( $_REQUEST['is_optionsframework'] ) && $_REQUEST['is_optionsframework'] == 'yes' ) {
		
			add_action( 'admin_head', 'optionsframework_mlu_js_popup' );
			add_filter( 'media_upload_tabs', 'optionsframework_mlu_modify_tabs' );
		}
	}
}

if ( ! function_exists( 'optionsframework_mlu_js_popup' ) ) {

	function optionsframework_mlu_js_popup () {

		$_of_title = $_REQUEST['of_title'];
		if ( ! $_of_title ) { $_of_title = 'file'; } // Fin de la declaración IF
?>
	<script type="text/javascript">
	<!--
	jQuery(function($) {
		
		jQuery.noConflict();
		
		// Cambia el título de cada pestaña para usar un título personalizado en lugar de "Archivo multimedia".
		$( 'h3.media-title' ).each ( function () {
			var current_title = $( this ).html();
			//var new_title = current_title.replace( 'archivo multimedia', '<?php echo $_of_title; ?>' );
			var new_title = current_title.replace( 'archivo multimedia', '<?php echo $_of_title; ?>' );
			$( this ).html( new_title );
		
		} );
		
		// Cambia el texto del botón "Insertar en la entrada" por el texto "Usar este archivo".
		$( '.savesend input.button[value*="Insert into Post"], .media-item #go_button' ).attr( 'value', 'Usar este archivo' );
		
		// Esconde la caja de ajustes "Insertar galería" en la pestaña "Galería".
		$( 'div#gallery-settings' ).hide();
		
		// Preserva el parámetro "is_optionsframework" en el botón de confirmación "eliminar".
		$( '.savesend a.del-link' ).click ( function () {
		
			var continueButton = $( this ).next( '.del-attachment' ).children( 'a.button[id*="del"]' );
			var continueHref = continueButton.attr( 'href' );
			continueHref = continueHref + '&is_optionsframework=yes';
			continueButton.attr( 'href', continueHref );
		
		} );
		
	});
	-->
	</script>
<?php
	}
}

/**
 * Ventana emergente ejecutada dentro de la Librería de medios para modificar el título de la pestaña "Galería".
 */

if ( ! function_exists( 'optionsframework_mlu_modify_tabs' ) ) {

	function optionsframework_mlu_modify_tabs ( $tabs ) {
		$tabs['gallery'] = str_replace( __( 'Galería', 'optionsframework' ), __( 'Recientemente subida', 'optionsframework' ), $tabs['gallery'] );
		return $tabs;
	}
}