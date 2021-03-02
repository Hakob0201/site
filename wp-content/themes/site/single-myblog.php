<?php
global $post;
?>


<!DOCTYPE html>
<html lang="en" style="margin: unset !important;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.11/swiper-bundle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
    <style type="text/css">
        #search_div {
            width: unset;
            margin-left: 28%;
        }

        .photo-description {
            color: #9F9F9F;
        }

        .gic {
            width: 72.39px;
            height: 1px;
            background: #000000;
            margin-bottom: 22px;
            /*            margin-top: 21px;*/

        }

        #profession {
            font-family: Roboto;
            font-style: normal;
            font-weight: 200;
            font-size: 16px;
            line-height: 19px;
            /* identical to box height */

            color: #9F9F9F;
            margin-bottom: 27px;
            margin-top: 17px;

        }

        #footer_ul3 {
            font-family: Roboto;
            font-style: normal;
            font-weight: 300;
            font-size: 16px;
            line-height: 30px;
            color: #FFFFFF;
            margin-left: 71px;
            margin-top: 48px;
        }

        #border {
            position: absolute;
            width: 87px !important;
            left: 17px;
            top: 73px;
            border: unset;
            border-top: 0.5px solid #000000;
            transform: rotate(
                    -90deg
            );
        }

        @media (min-width: 1000px) {
            .content {
                width: 1240px;
                max-width: 1240px;
                margin: auto;
            }
        }


        .recommendedUser {
            height: 100% !important;
            width: 100% !important;
            margin: 0 10px;
            padding: 0 10px 0 10px;
            text-align: left;
        }

        .recommendedUser > img {
    height: 220px;
    width: 255px;
    object-fit: cover;
        }

        @media (max-width: 768px) {

            #person {
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
            }

            #person-info {
                margin-left: unset;
            }
        }
        .waveplayer.wvpl-skin-play_n_wave
        {
            width: 75% !important;
        }

        #photo-description
        {
            font-style: unset !important;
        }
    </style>
	<?php wp_head(); ?>
</head>
<body>
<?php get_header(); ?>
<!-- 	<div id="header">
		<div id="logo_div">
			<span style="cursor: pointer;" onclick="location.href = '/'"><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span>
		</div>
		<div id="search_div">
			<form action="<?php echo get_site_url() . '/search-2/' ?>" metod="get">
				<div id="search">
					<label for="search_input" id="search_logo">
						<img src="<?php the_field('search_img', 15); ?>" alt="" >
					</label>
					<input type="text" name="search" id="search_input">	
					<button id="poisk"><?php the_field('поиск_' . _get_lang_(), 15); ?></button>
				</div>
			</form>
		</div>

		<div id="add_history" onclick="location.href = '<?php echo get_site_url() . '/dobavit-istoriyu/'; ?>'" style="cursor: pointer;"><?php the_field('добавить_свою_историю_' . _get_lang_(), 15); ?></div>
		<div id="menu">
			<?php the_field('меню_' . _get_lang_(), 15); ?>
			<?php include 'menu.php'; ?>
		</div>

		<?php include 'lang.php'; ?>
	</div> -->


<div class="content container">
    <div id="info_div">
        <a href="/"
           style="text-transform: none;color: #606060; font-family: Roboto !important;"><?php echo mb_strtoupper(mb_substr(get_field('главная_' . _get_lang_(), 15), 0, 1)) . mb_substr(get_field('главная_' . _get_lang_(), 15), 1); ?></a>
        <span class="arrowRight">
				<img src="<?php echo bloginfo('template_url') . '/files/icons/obshestvennie-deyateli/arrow-right.png'; ?>">
        </span>
        <a href='<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_the_category()[0]->name); ?>'
           id="profession-link" style="text-transform: none;color: #606060;font-family: Roboto !important;">
			<?php print_r(mb_strtoupper(mb_substr(get_field('category_name_' . _get_lang_(), 'category_' . get_the_category()[0]->term_id), 0, 1)) . mb_substr(get_field('category_name_' . _get_lang_(), 'category_' . get_the_category()[0]->term_id), 1)); ?>
        </a>
		<?php if (!empty(get_field('name_' . _get_lang_(), $post->ID))): echo '<span class="arrowRight"><img src=' . get_site_url() . '/wp-content/themes/site/files/icons/obshestvennie-deyateli/arrow-right.png alt=></span>'; endif; ?>
        <span id="info-user-name-surname"
              style="text-transform: none; text-decoration: none;    font-size: 17px;"><?php echo mb_strtoupper(mb_substr(get_field('name_' . _get_lang_(), $post->ID), 0, 1)) . mb_substr(get_field('name_' . _get_lang_(), $post->ID), 1); ?></span>
    </div>



    <div id="person">
        <div>
            <img src="<?php the_field('photo', $post->ID); ?>" alt="">

        </div>
        <div id="person-info">
            <span><?php echo mb_strtoupper(mb_substr(get_field('name_' . _get_lang_(), $post->ID), 0, 1)) . mb_substr(get_field('name_' . _get_lang_(), $post->ID), 1); ?></span>
            <span id="profession"><?php echo mb_strtoupper(mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $post->ID), 0, 1)) . mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $post->ID), 1); ?><?php echo mb_strtoupper(mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $post->ID), 0, 1)) . mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $post->ID), 1); ?></span>
            <div class="gic"></div>
            <div class="text_hide">
				<?php echo get_field('description_' . _get_lang_(), $post->ID); ?>
            </div>
            <div id="bio" class="text_show" style="display: none;">
				<?php echo substr(get_field('description_' . _get_lang_(), $post->ID), 0, 400); ?>
            </div>
            <!--             <a style="cursor: pointer; font-size: 22px; " class="all_text_show">...</a> -->
            <div style="margin-top: 0; margin-bottom: 10px;">
				<?php the_field('поделиться_' . _get_lang_(), 15); ?>
				<?php echo do_shortcode('[Sassy_Social_Share]'); ?>
            </div>
        </div>

    </div>
    <div id="photo-description"><?php the_field('описание_' . _get_lang_(), 15); ?><?php the_content(); ?></div>
</div>
</div>
</div>

<div id="recommendations">
    <div id="recommendations-body" class="content container">
        <div id="recommendations-heading"><?php the_field('рекомендуемое_' . _get_lang_(), 15); ?></div>
        <!-- Swiper -->
        <div class="swiper-container" style="margin-top: -50px;">
            <div class="swiper-wrapper">
				<?php $nb = 0;
				foreach (_get_fields_(_get_post_()) as $key => $value): ?>
					<?php if ($nb < 4): ?>
                        <div class="swiper-slide ">
                            <div class="recommendedUser">
                                <img src="<?php the_field('photo', $value['ID']); ?>">
                                <div class="recommendedUserData"><?php echo mb_strtoupper(mb_substr(get_field('name_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('name_' . _get_lang_(), $value['ID']), 1); ?></div>
                                <div class="recommendedUserProfession"><?php echo mb_strtoupper(mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $value['ID']), 1); ?><?php echo ' ' . mb_strtoupper(mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $value['ID']), 1); ?></div>
                                <a href="<?php echo get_permalink($value['ID']); ?>"
                                   class="recommendedUserProperties"><?php the_field('подробнее_' . _get_lang_(), 15); ?>
                                    <img style="margin-left: 9px;"
                                         src="<?php echo bloginfo('template_url') . '/files/icons/obshestvennie-deyateli/arrow-right.png'; ?>"
                                         alt=""></a>
                            </div>
                        </div>
					<?php endif; ?>
					<?php $nb++; endforeach; ?>
            </div>
            <!-- Add Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
            <!-- Add Arrows -->
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<?php get_footer(); ?>

<!-- Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.11/swiper-bundle.js"></script>
<style>

    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: transparent;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-button-prev,
    .swiper-button-next {
        /*width: calc(var(--swiper-navigation-size) / 10 * 27);*/
        border: unset !important;
    }

    .swiper-button-prev {
        position: absolute;
        left: -30px;
    }

    .swiper-button-next {
        position: absolute;
        right: -30px;
    }

    .swiper-button-prev:after,
    .swiper-container-rtl .swiper-button-next:after,
    .swiper-button-next:after,
    .swiper-container-rtl .swiper-button-prev:after {
        font-size: 25px;
        color: #202020;
    }

    .swiper-slide {
        margin: 80px 0 80px 0;
    }
</style>

<script type="text/javascript">

    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 4,
        spaceBetween: 10,
        loop: true,
        pagination: {el: ".swiper-pagination", clickable: true},
        navigation: {nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev"},
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            380: {
                slidesPerView: 1,
            },
            500: {
                slidesPerView: 1,
            },
            800: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
            1400: {
                slidesPerView: 5,
            },
        }
    });


    $("#menu").click(function (e) {
        e.stopPropagation()
        $("#hidden-menu").toggleClass('hiddenMenu');
    })

    $("#hidden-menu").click(function (e) {
        e.stopPropagation();
    })

    $('body').click(function () {
        $("#hidden-menu").addClass('hiddenMenu');
    })

    $(document).on('click', '.all_text_show', function () {
        $(this).addClass('all_text_hide')
        $(this).removeClass('all_text_show')
        $(this).parent().find('.text_show').css('display', 'none');
        $(this).parent().find('.text_hide').css('display', 'block');
    });
    $(document).on('click', '.all_text_hide', function () {
        $(this).addClass('all_text_show')
        $(this).removeClass('all_text_hide')
        $(this).parent().find('.text_hide').css('display', 'none');
        $(this).parent().find('.text_show').css('display', 'block');
    });

</script>
<script src="http://www.covidstories.kg/wp-content/plugins/sassy-social-share/public/js/sassy-social-share-public.js"></script>
<script type="text/javascript"
        src="http://www.covidstories.kg/wp-content/plugins/waveplayer/assets/js/waveplayer.min.js"
        id="waveplayer-js"></script>
<?php wp_footer(); ?>
</body>
</html>
    
