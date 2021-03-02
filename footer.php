<div id="footer-part">
	<div id="footer" class="container text-center">
		<ul id="footer_div1" class="col-lg-3 col-md-6 col-sm-12">
			<!-- // <span style="margin-bottom: 41px; text-align: left;"><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span> -->
			<span>© 2020-2021 Все права защищены</span>
			<!-- <span><?php the_field('все_права_защищены_' . _get_lang_(), 10); ?></span> -->
		</ul>

        <?php if (_get_lang_() == 'ру'): ?>
            <ul id="footer_ul1" class="col-lg-3 col-md-6 col-sm-12">
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=сектор_образования'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('сектор_образования_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('сектор_образования_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=сектор_здравоохранения'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('сектор_здравоохранения_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('сектор_здравоохранения_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=медиа-сектор'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('медиа-сектор_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('медиа-сектор_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=общественные_деятели'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('общественные_деятели_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('общественные_деятели_' . _get_lang_(), 137), 1); ?></li>
            </ul>

            <ul id="footer_ul2" class="col-lg-4 col-md-6 col-sm-12">
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=волонтеры_и_гражданское_общество'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('волонтеры_и_гражданское_общество_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('волонтеры_и_гражданское_общество_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=правительство_и_штаб_по_covid-19'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('правительство_и_штаб_по_covid-19_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('правительство_и_штаб_по_covid-19_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=парламент_и_президент'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('парламент_и_президент_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('парламент_и_президент_' . _get_lang_(), 137), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=местная_власть'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('местная_власть_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('местная_власть_' . _get_lang_(), 137), 1); ?></li>
            </ul>

            <ul id="footer_ul3" class="col-lg-2 col-md-6 col-sm-12">
                <li style="cursor: pointer;width: 250px;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=дополнительные_материалы'; ?>'"><?php echo mb_strtoupper(mb_substr(get_field('дополнительные_материалы_' . _get_lang_(), 137), 0, 1)) . mb_substr(get_field('дополнительные_материалы_' . _get_lang_(), 137), 1); ?></li>
            </ul>

        <?php else: ?>

            <ul id="footer_ul1" class="col-lg-3 col-md-6 col-sm-12">
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('1img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('1img_text', 331), 0, 1)) . mb_substr(get_field('1img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('2img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('2img_text', 331), 0, 1)) . mb_substr(get_field('2img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('3img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('3img_text', 331), 0, 1)) . mb_substr(get_field('3img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('4img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('4img_text', 331), 0, 1)) . mb_substr(get_field('4img_text', 331), 1); ?></li>
            </ul>

            <ul id="footer_ul2" class="col-lg-4 col-md-6 col-sm-12">
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('5img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('5img_text', 331), 0, 1)) . mb_substr(get_field('5img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('6img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('6img_text', 331), 0, 1)) . mb_substr(get_field('6img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('7img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('7img_text', 331), 0, 1)) . mb_substr(get_field('7img_text', 331), 1); ?></li>
                <li style="cursor: pointer;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('8img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('8img_text', 331), 0, 1)) . mb_substr(get_field('8img_text', 331), 1); ?></li>
            </ul>

            <ul id="footer_ul3" class="col-lg-2 col-md-6 col-sm-12">
                <li style="cursor: pointer;width: 250px;"
                    onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('9img_text', 331)); ?>'"><?php echo mb_strtoupper(mb_substr(get_field('9img_text', 331), 0, 1)) . mb_substr(get_field('9img_text', 331), 1); ?></li>
            </ul>
        <?php endif; ?>
	</div>
</div>

<script type="text/javascript">

    $("#navigation-button").click(function () {
        $('html, body').animate({
            scrollTop: $("#content").offset().top
        }, 700);
    });

    $("#open-hidden-search").click(function () {
        if ($(window).width() < 795)
            document.getElementById("myOverlay").style.display = "block";
        else
            $("#hidden-search").toggleClass('hiddenSearch');

    })

    $("#logo_div img, #hidden-menu").hover(function(){
        $("#hidden-menu").toggleClass('hiddenMenu');
    }, function(){
        $("#hidden-menu").toggleClass('hiddenMenu');
    })

    $("#hidden-menu").click(function (e) {
        e.stopPropagation();
    })

    $('body').click(function () {
        $("#hidden-menu").addClass('hiddenMenu');
    })

    function setCharAt(str, index, chr) {
        if (index > str.length - 1) return str;
        return str.substring(0, index) + chr + str.substring(index + 1);
    }

    $("#next").click(function () {
        let photos = $('.embassyPhoto')
        for (let i = 0; i < photos.length; i++) {
            var index = photos[i].src[photos[i].src.length - 5]
            index++
            if (index + 1 > 5) {
                index = 1
            }
            photos[i].src = photos[i].src.substring(0, photos[i].src.length - 5) + index + photos[i].src.substring(photos[i].src.length - 5 + 1);
        }
    })

    $("#prev").click(function () {
        let photos = $('.embassyPhoto')
        for (let i = 0; i < photos.length; i++) {
            var index = photos[i].src[photos[i].src.length - 5]
            index--
            if (index - 1 < 0) {
                index = 4
            }
            photos[i].src = photos[i].src.substring(0, photos[i].src.length - 5) + index + photos[i].src.substring(photos[i].src.length - 5 + 1);
        }
    })

    // Close the full screen search box
    function closeSearch() {
        document.getElementById("myOverlay").style.display = "none";
    }
</script>