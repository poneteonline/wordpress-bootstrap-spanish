<?php

/* Texto */

add_filter( 'of_sanitize_text', 'sanitize_text_field' );

/* Area de texto */

function of_sanitize_textarea($input) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags);
	return $output;
}

add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );

/* Información */

add_filter( 'of_sanitize_info', 'of_sanitize_allowedposttags' );

/* Selección */

add_filter( 'of_sanitize_select', 'of_sanitize_enum', 10, 2);

/* Radio */

add_filter( 'of_sanitize_radio', 'of_sanitize_enum', 10, 2);

/* Imágenes */

add_filter( 'of_sanitize_images', 'of_sanitize_enum', 10, 2);

/* Casilla de verificación */

function of_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = "1";
	} else {
		$output = "0";
	}
	return $output;
}
add_filter( 'of_sanitize_checkbox', 'of_sanitize_checkbox' );

/* Lista de selección múltiple */

function of_sanitize_multicheck( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = "0";
		}
		foreach( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = "1"; 
			}
		}
	}
	return $output;
}
add_filter( 'of_sanitize_multicheck', 'of_sanitize_multicheck', 10, 2 );

/* Selección de color */

add_filter( 'of_sanitize_color', 'of_sanitize_hex' );

/* Cargador */

function of_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype($input);
	if ( $filetype["ext"] ) {
		$output = $input;
	}
	return $output;
}
add_filter( 'of_sanitize_upload', 'of_sanitize_upload' );

/* Etiquetas permitidas */

function of_sanitize_allowedtags($input) {
	global $allowedtags;
	$output = wpautop(wp_kses( $input, $allowedtags));
	return $output;
}

add_filter( 'of_sanitize_info', 'of_sanitize_allowedtags' );

/* Etiquetas de artículo permitidas */

function of_sanitize_allowedposttags($input) {
	global $allowedposttags;
	$output = wpautop(wp_kses( $input, $allowedposttags));
	return $output;
}

add_filter( 'of_sanitize_info', 'of_sanitize_allowedposttags' );


/* Verificar que el valor de la clave enviada es válido */

function of_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}

/* Fondo */

function of_sanitize_background( $input ) {
	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	$output['color'] = apply_filters( 'of_sanitize_hex', $input['color'] );
	$output['image'] = apply_filters( 'of_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'of_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'of_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'of_background_attachment', $input['attachment'] );

	return $output;
}
add_filter( 'of_sanitize_background', 'of_sanitize_background' );

function of_sanitize_background_repeat( $value ) {
	$recognized = of_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'of_default_background_repeat', current( $recognized ) );
}
add_filter( 'of_background_repeat', 'of_sanitize_background_repeat' );

function of_sanitize_background_position( $value ) {
	$recognized = of_recognized_background_position();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'of_default_background_position', current( $recognized ) );
}
add_filter( 'of_background_position', 'of_sanitize_background_position' );

function of_sanitize_background_attachment( $value ) {
	$recognized = of_recognized_background_attachment();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'of_default_background_attachment', current( $recognized ) );
}
add_filter( 'of_background_attachment', 'of_sanitize_background_attachment' );


/* Tipografía */

function of_sanitize_typography( $input ) {
	$output = wp_parse_args( $input, array(
		'size'  => '',
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	$output['size']  = apply_filters( 'of_font_size', $output['size'] );
	$output['face']  = apply_filters( 'of_font_face', $output['face'] );
	$output['style'] = apply_filters( 'of_font_style', $output['style'] );
	$output['color'] = apply_filters( 'of_color', $output['color'] );

	return $output;
}
add_filter( 'of_sanitize_typography', 'of_sanitize_typography' );

function of_sanitize_wpbs_typography( $input ) {
	$output = wp_parse_args( $input, array(
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	$output['face']  = apply_filters( 'of_font_face', $output['face'] );
	$output['style'] = apply_filters( 'of_font_style', $output['style'] );
	$output['color'] = apply_filters( 'of_color', $output['color'] );

	return $output;
}
add_filter( 'of_sanitize_wpbs_typography', 'of_sanitize_wpbs_typography' );


function of_sanitize_font_size( $value ) {
	$recognized = of_recognized_font_sizes();
	$value = preg_replace('/px/','', $value);
	if ( in_array( (int) $value, $recognized ) ) {
		return (int) $value;
	}
	return (int) apply_filters( 'of_default_font_size', $recognized );
}
add_filter( 'of_font_face', 'of_sanitize_font_face' );


function of_sanitize_font_style( $value ) {
	$recognized = of_recognized_font_styles();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'of_default_font_style', current( $recognized ) );
}
add_filter( 'of_font_style', 'of_sanitize_font_style' );


function of_sanitize_font_face( $value ) {
	$recognized = of_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'of_default_font_face', current( $recognized ) );
}
add_filter( 'of_font_face', 'of_sanitize_font_face' );

/**
 * Obtener las configuraciones reconocidas de repetición de fondo
 *
 * @return   array
 *
 */
function of_recognized_background_repeat() {
	$default = array(
		'no-repeat' => 'Sin repetir',
		'repeat-x'  => 'Repetir horizontalmente',
		'repeat-y'  => 'Repetir verticalmente',
		'repeat'    => 'Repetir todo',
		);
	return apply_filters( 'of_recognized_background_repeat', $default );
}

/**
 * Obtener las configuraciones reconocidas de posición del fondo
 *
 * @return   array
 *
 */
function of_recognized_background_position() {
	$default = array(
		'top left'      => 'Superior izquierda',
		'top center'    => 'Superior centrado',
		'top right'     => 'Superior derecha',
		'center left'   => 'Centrado a la izquierda',
		'center center' => 'Centrado vertical y horizontal',
		'center right'  => 'Centrado a la derecha',
		'bottom left'   => 'Inferior izquierda',
		'bottom center' => 'Inferior centrado',
		'bottom right'  => 'Inferior a la derecha'
		);
	return apply_filters( 'of_recognized_background_position', $default );
}

/**
 * Obtener las configuraciones reconocidas de background-attachment
 *
 * @return   array
 *
 */
function of_recognized_background_attachment() {
	$default = array(
		'scroll' => 'Desplazamiento normal',
		'fixed'  => 'Fijo en un lugar'
		);
	return apply_filters( 'of_recognized_background_attachment', $default );
}

/**
 * Limpiar un color representado en notación Hexadecimal.
 *
 * @param    string    Color en notación hexadecimal. # puede o no ser antecedido por la cadena de texto
 * @param    string    El valor que esta función debe retornar si no puede ser reconocido como un color
 * @return   string
 *
 */
 
function of_sanitize_hex( $hex, $default = '' ) {
	if ( of_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Obtener los tamaños de fuente reconocidos.
 *
 * Retorna un arreglo indexado de todos los tamaños de fuente reconocidos.
 * Los valores son enteros y representan un rango de tamaños de menor a mayor.
 *
 * @return   array
 */
 
function of_recognized_font_sizes() {
	$sizes = range( 9, 71 );
	$sizes = apply_filters( 'of_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );
	return $sizes;
}

/**
 * Obtener los tipos de fuente reconocidos.
 *
 * Obtener los tipos de fuente reconocidos.
 * Las claves son para almacenar en la base de datos.
 *
 * @return   array
 *
 */
function of_recognized_font_faces() {
	$default = array(
		'"Helvetica Neue",Helvetica,Arial,sans-serif'   => 'Default',
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'trebuchet' => 'Trebuchet',
		'georgia'   => 'Georgia',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'palatino'  => 'Palatino',
		'helvetica' => 'Helvetica*'
		);
	return apply_filters( 'of_recognized_font_faces', $default );
}

/**
 * Obtener los estilos de fuente reconocidos.
 *
 * Retorna un arreglo de todos los estilos de fuente conocidos.
 * Se intenta almacenar las claves en la base de datos
 * mientras los valores están listos para ser mostrados en html.
 *
 * @return   array
 *
 */
function of_recognized_font_styles() {
	$default = array(
		'normal'      => 'Normal',
		'italic'      => 'Italic',
		'bold'        => 'Bold',
		'bold italic' => 'Bold Italic'
		);
	return apply_filters( 'of_recognized_font_styles', $default );
}

/**
 * Es la cadena de texto dada, un color en formato hexadecimal?
 *
 * @param    string    Color en formato hexadecimal. "#" puede o no estar antepuesto a la cadena de texto.
 * @return   bool
 *
 */
 
function of_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Destapa prefijos reconocidos */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}