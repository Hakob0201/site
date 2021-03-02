<div id="languages">
	<span style="cursor: pointer;" onclick="location.href = '<?php echo get_site_url(); ?>?lang=кр '" class="<?php if(_get_lang_() == 'кр'): echo 'selectedLanguage'; endif; ?>">
		<?php the_field('kru', 15); ?>
	</span>
	<span style="cursor: pointer;" onclick="location.href = '<?php echo get_site_url(); ?>?lang=ру '" class="<?php if(_get_lang_() == 'ру'): echo 'selectedLanguage'; endif; ?>">
		<?php the_field('ru', 15); ?>
   	</span>
</div>