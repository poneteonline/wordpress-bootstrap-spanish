<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

					<?php

					$use_carousel = of_get_option('showhidden_slideroptions');
      				if ($use_carousel) {

					?>

					<div id="myCarousel" class="carousel">

					    <!-- Carousel items -->
					    <div class="carousel-inner">

					    	<?php
							global $post;
							$tmp_post = $post;
							$show_posts = of_get_option('slider_options');
							$args = array( 'numberposts' => $show_posts ); // usa esto para establecer cuántas entradas quieres en el carousel
							$myposts = get_posts( $args );
							$post_num = 0;
							foreach( $myposts as $post ) :	setup_postdata($post);
								$post_num++;
								$post_thumbnail_id = get_post_thumbnail_id();
								$featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'wpbs-featured-carousel' );
							?>

						    <div class="<?php if($post_num == 1){ echo 'active'; } ?> item">
						    	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'wpbs-featured-carousel' ); ?></a>

							   	<div class="carousel-caption">

					                <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
					                <p>
					                	<?php
					                		$excerpt_length = 100; // máximo tamaño a mostrar en el resumen (en carácteres)
					                		$the_excerpt = get_the_excerpt(); 
					                		if($the_excerpt != ""){
					                			$the_excerpt = substr( $the_excerpt, 0, $excerpt_length );
					                			echo $the_excerpt . '... ';
					                	?>
					                	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="btn btn-primary">Leer más &rsaquo;</a>
					                	<?php } ?>
					                </p>

				                </div>
						    </div>

						    <?php endforeach; ?>
							<?php $post = $tmp_post; ?>

					    </div>

					    <!-- navegación del Carousel -->
					    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
					    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
				    </div>

				    <?php } // finaliza la declaración if usada en el carousel ?>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					
						<header>

							<?php 
								$post_thumbnail_id = get_post_thumbnail_id();
								$featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'wpbs-featured-home' );
								// no estoy seguro esto porque no esta funcionando aún
							?>
						
							<div class="hero-unit" style="background-image: url('<?php echo $featured_src; ?>'); background-repeat: no-repeat; background-position: 0 0;">
							
								<?php the_post_thumbnail( 'wpbs-featured-home' ); ?>

								<h1><?php the_title(); ?></h1>
								
								<?php echo get_post_meta($post->ID, 'custom_tagline' , true);?>
							
							</div>
						
						</header>
						
						<section class="row-fluid post_content">
						
							<div class="span8">
						
								<?php the_content(); ?>
								
							</div>
							
							<?php get_sidebar('sidebar2'); // barra lateral 2 ?>
													
						</section> <!-- fin de la cabecera del artículo -->
						
						<footer>
			
							<p class="clearfix"><?php the_tags('<span class="tags">' . __("Etiquetas","bonestheme") . ': ', ', ', '</span>'); ?></p>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
					
					<?php 
						// Sin comentarios en la página principal
						//comments_template();
					?>
					
					<?php endwhile; ?>	
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("No se ha encontrado", "bonestheme"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Lo sentimos, pero el recurso solicitado no se ha encontrado en este sitio.", "bonestheme"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> <!-- fin de #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>