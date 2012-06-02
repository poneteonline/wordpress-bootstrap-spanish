<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						<header>
							
							<div class="page-header"><h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1></div>
						
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
					
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
			
							<?php the_tags('<p class="tags"><span class="tags-title">' . __("Etiquetas","bonestheme") . ':</span> ', ', ', '</p>'); ?>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
					
					<?php comments_template(); ?>
					
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