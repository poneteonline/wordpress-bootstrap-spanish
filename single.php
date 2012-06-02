<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						<header>
						
							<?php the_post_thumbnail( 'wpbs-featured' ); ?>
							
							<div class="page-header"><h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1></div>
							
							<p class="meta"><?php _e("Publicado", "bonestheme"); ?> <time datetime="<?php echo the_time('F-j-Y'); ?>" pubdate><?php the_date(); ?></time> <?php _e("por", "bonestheme"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("archivado en", "bonestheme"); ?> <?php the_category(', '); ?>.</p>
						
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
							
							<?php wp_link_pages(); ?>
					
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
			
							<?php the_tags('<p class="tags"><span class="tags-title">' . __("Etiquetas","bonestheme") . ':</span> ', ' ', '</p>'); ?>
							
							<?php 
							// mostrar el botón de editar solo si el usuario posee permisos para editar entradas
							if( $user_level > 0 ) { 
							?>
							<a href="<?php echo get_edit_post_link(); ?>" class="btn btn-success edit-post"><i class="icon-pencil icon-white"></i> <?php _e("Editar entrada","bonestheme"); ?></a>
							<?php } ?>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
					
					<?php comments_template('',true); ?>
					
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
    
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>