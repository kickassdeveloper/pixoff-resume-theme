<?php
	global $section;
?>
<section id="<?= sanitize_title($section['title']); ?>" label="<?= $section['title']; ?>" class="section-contact full-height bg-<?= $section['colors']['background']; ?> text-<?= $section['colors']['text']; ?> fill-<?= $section['colors']['icons']; ?>">
	<div class="container full-height">
		<div class="row full-height align-items-center">
			<div class="col-12 py-6">
				<div class="row align-items-top">
					<div class="col-12">
						<?php the_section_image($section['image']); ?>

						<h3 class="display-4"><?= $section['title']; ?></h1>
					</div>
					<div class="col-12 col-lg">
						<?php if ( $section['content'] ) : ?>
							<hr class="hr-<?= $section['colors']['text']; ?> my-4">
							<div class="pxo-page-content">
								<?= $section['content']; ?>
							</div><!-- .pxo-page-content -->
						<?php endif; ?>

						<?php foreach($section['grids'] as $index=>$grid) : ?>
							<?php if ( isset($grid['title']) && $grid['title'] != '' ) : ?>
								<h4 class="display-5 mt-4"><?= $grid['title']; ?></h1>
							<?php endif; ?>

							<div class="row">
								<?php
									$cols = array(
										'third' => 'col-12 col-md-6 col-lg-4',
										'half' => 'col-12 col-md-6',
										'full' => 'col-12'
									);

									foreach($grid['items'] as $index=>$local_item) :
									global $item;
									$item = $local_item;
								?>
									<div class="<?= $cols[$grid['layout']] ?>">
										<?php get_template_part( 'template-parts/items/item', 'post' ); ?>
									</div>
								<?php endforeach; $local_item = null; ?>
							</div>
						<?php endforeach; $grid = null; ?>
					</div>

					<?php if ( $section['contact_form'] ) : ?>
						<div class="col-12 col-lg d-print-none">
							<?php the_contact_form($section['contact_form']); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
