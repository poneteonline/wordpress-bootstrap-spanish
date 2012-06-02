				<div id="sidebar2" class="fluid-sidebar sidebar span4" role="complementary">
				
					<?php if ( is_active_sidebar( 'sidebar2' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar2' ); ?>

					<?php else : ?>

						<!-- Este contenido se muestra en caso de que no hayan widgets definidos en el backend. -->
						
						<div class="alert-message">
						
							<p><?php _e("Por favor active algunos Widgets","bonestheme"); ?>.</p>
						
						</div>

					<?php endif; ?>

				</div>