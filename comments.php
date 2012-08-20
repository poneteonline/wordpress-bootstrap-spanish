<?php
/*
La página de comentarios para Bones
*/

// No borres estas líneas
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Por favor no cargue esta página directamente. Gracias!');

  if ( post_password_required() ) { ?>
  	<div class="alert alert-info"><?php _e("Esta entrada está protegida. Introduce la contraseña para ver los comentarios.","bonestheme"); ?></div>
  <?php
    return;
  }
?>

<!-- Puedes comenzar a editar desde aquí. -->

<?php if ( have_comments() ) : ?>
	<?php if ( ! empty($comments_by_type['comment']) ) : ?>
	<h3 id="comments"><?php comments_number('<span>' . __("No hay","bonestheme") . '</span> ' . __("Respuestas","bonestheme") . '', '<span>' . __("Una","bonestheme") . '</span> ' . __("Respuesta","bonestheme") . '', '<span>%</span> ' . __("Respuestas","bonestheme") );?> <?php _e("a","bonestheme"); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link( __("Entradas antiguas","bonestheme") ) ?></li>
	  		<li><?php next_comments_link( __("Entradas recientes","bonestheme") ) ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=bones_comments'); ?>
	</ol>
	
	<?php endif; ?>
	
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 id="pings">Trackbacks/Pingbacks</h3>
		
		<ol class="pinglist">
			<?php wp_list_comments('type=pings&callback=list_pings'); ?>
		</ol>
	<?php endif; ?>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link( __("Entradas antiguas","bonestheme") ) ?></li>
	  		<li><?php next_comments_link( __("Entradas recientes","bonestheme") ) ?></li>
		</ul>
	</nav>
  
	<?php else : // Esto se muestra si no existen comentarios hasta el momento ?>

	<?php if ( comments_open() ) : ?>
    	<!-- Si los comentarios están cerrados, pero no hay comentarios publicados. -->

	<?php else : // los comentarios están cerrados 
	?>
	
	<?php
		$suppress_comments_message = of_get_option('suppress_comments_message');

		if (is_page() && $suppress_comments_message) :
	?>
			
		<?php else : ?>
		
			<!-- Si los comentarios están cerrados. -->
			<p class="alert alert-info"><?php _e("Los comentarios están cerrados","bonestheme"); ?>.</p>
			
		<?php endif; ?>

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h3 id="comment-form-title"><?php comment_form_title( __("Deja un comentario","bonestheme"), __("Responder a","bonestheme") . ' %s' ); ?></h3>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link( __("Cancelar","bonestheme") ); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="help">
  		<p><?php _e("Disculpa, debes","bonestheme"); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("logged in","bonestheme"); ?></a> <?php _e("para escribir un comentario","bonestheme"); ?>.</p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e("Conectado como","bonestheme"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Salir de esta cuenta","bonestheme"); ?>"><?php _e("Salir","bonestheme"); ?> &raquo;</a></p>

	<?php else : ?>
	
	<ul id="comment-form-elements" class="clearfix">
		
		<li>
			<div class="control-group">
			  <label for="author"><?php _e("Nombre","bonestheme"); ?> <?php if ($req) echo "(requerido)"; ?></label>
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-user"></i></span><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Tu nombre","bonestheme"); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			  </div>
		  	</div>
		</li>
		
		<li>
			<div class="control-group">
			  <label for="email"><?php _e("Correo","bonestheme"); ?> <?php if ($req) echo "(requerido)"; ?></label>
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-envelope"></i></span><input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("Correo","bonestheme"); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			  	<span class="help-inline">(<?php _e("no será publicado","bonestheme"); ?>)</span>
			  </div>
		  	</div>
		</li>
		
		<li>
			<div class="control-group">
			  <label for="url"><?php _e("Sitio web","bonestheme"); ?></label>
			  <div class="input-prepend">
			  <span class="add-on"><i class="icon-home"></i></span><input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e("Tu sitio web","bonestheme"); ?>" tabindex="3" />
			  </div>
		  	</div>
		</li>
		
	</ul>

	<?php endif; ?>
	
	<div class="clearfix">
		<div class="input">
			<textarea name="comment" id="comment" placeholder="<?php _e("Escribe aquí tu comentario...","bonestheme"); ?>" tabindex="4"></textarea>
		</div>
	</div>
	
	<div class="form-actions">
	  <input class="btn btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Enviar comentario","bonestheme"); ?>" />
	  <?php comment_id_fields(); ?>
	</div>
	
	<?php 
		//comment_form();
		do_action('comment_form()', $post->ID); 
	
	?>
	
	</form>
	
	<?php endif; // si se requiere registro y no se ha iniciado sesión ?>
</section>

<?php endif; // si eliminas esto el cielo caerá sobre tu cabeza ?>