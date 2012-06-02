<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					
						<header>
						
							<div class="hero-unit">
							
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