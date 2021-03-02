<?php if (_get_lang_() == 'ру'): ?>
	<ul id="hidden-menu" class="hiddenMenu">
		<a href="<?php echo get_site_url() . '/cat?cat=сектор_образования'; ?>"><?php the_field('сектор_образования_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=сектор_здравоохранения'; ?>"><?php the_field('сектор_здравоохранения_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=медиа-сектор'; ?>"><?php the_field('медиа-сектор_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=общественные_деятели'; ?>"><?php the_field('общественные_деятели_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=волонтеры_и_гражданское_общество'; ?>"><?php the_field('волонтеры_и_гражданское_общество_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=правительство_и_штаб_по_covid-19'; ?>"><?php the_field('правительство_и_штаб_по_covid-19_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=парламент_и_президент'; ?>"><?php the_field('парламент_и_президент_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=местная_власть'; ?>"><?php the_field('местная_власть_' . _get_lang_(), 137); ?> </a>
		<a href="<?php echo get_site_url() . '/cat?cat=дополнительные_материалы'; ?>"><?php the_field('дополнительные_материалы_' . _get_lang_(), 137); ?> </a>
	</ul>
<?php else: ?>
    <ul id="hidden-menu" class="hiddenMenu">
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('1img_text', 331)); ?>"><?php echo get_field('1img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('2img_text', 331)); ?>"><?php echo get_field('2img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('3img_text', 331)); ?>"><?php echo get_field('3img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('4img_text', 331)); ?>"><?php echo get_field('4img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('5img_text', 331)); ?>"><?php echo get_field('5img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('6img_text', 331)); ?>"><?php echo get_field('6img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('7img_text', 331)); ?>"><?php echo get_field('7img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('8img_text', 331)); ?>"><?php echo get_field('8img_text', 331); ?></a>
        <a href="<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('9img_text', 331)); ?>"><?php echo get_field('9img_text', 331); ?></a>
    </ul>
<?php endif; ?>
