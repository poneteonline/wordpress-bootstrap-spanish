<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

					<article id="post-not-found" class="clearfix">
						
						<header>
							
							<div class="hero-unit">

								<h1>Epic 404 - El artículo no fue encontrado</h1>
								<p>Esto es embarazoso. No podemos encontrar lo que estas buscando.</p>
															
							</div>
											
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content">
							
							<p>Lo que sea que estés buscando no ha sido encontrado, pero puedes internar buscar de nuevo o puedes utilizar el siguiente formulario de búsqueda.</p>

							<div class="row-fluid">
								<div class="span12">
									<?php get_search_form(); ?>
								</div>
							</div>
					
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
			
				</div> <!-- fin de #main -->
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>