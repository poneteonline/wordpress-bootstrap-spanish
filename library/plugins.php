<?php

/*
Plugins y funcionalidades extras de Bones
Autor: Eddie Machado
URL: http://themble.com/bones/

Este archivo contiene características extras no 100% estables pero listas para ser incluidas
en el núcleo. Siéntete libre de editar cualquier parte e incluso ayudarnos a mejorar y
optimiza el código!

SI QUIERES ENVIAR UNA REPARACION O CORRECCION, UNETE A NOSOTROS EN GITHUB:
https://github.com/eddiemachado/bones/issues

SI QUIERES DESHABILITAR ESTE ARCHIVO,  ELIMINA SU LLAMADO EN EL ARCHIVO FUNCTIONS.PHP

*/


/* 
Integración social
Esta es una colección de fragmentos que he editado o rehusado
de los plugins sociales. No hay necesidad de usar un plugin cuando 
puede replicarlo en unas pocas lineas, así que aquí vamos.
Para mas información, o para mas cosas de open graph, verifica:
http://yoast.com/facebook-open-graph-protocol/
*/

	
// añadiendo el rel=me gracias a yoast	
function yoast_allow_rel() {
	global $allowedtags;
	$allowedtags['a']['rel'] = array ();
}
add_action( 'wp_loaded', 'yoast_allow_rel' );

// añadiendo enlaces para facebook, twitter y google+ al perfil del usuario
function bones_add_user_fields( $contactmethods ) {
	// Añadir Facebook
	$contactmethods['user_fb'] = 'Facebook';
	// Añadir Twitter
	$contactmethods['user_tw'] = 'Twitter';
	// Añadir Google+
	$contactmethods['google_profile'] = 'URL del perfil de Google';
	// Guardar 'Em
	return $contactmethods;
}
add_filter('user_contactmethods','bones_add_user_fields',10,1);


?>