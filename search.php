<?php

/**

 * Template name: Search

*/

    global $post;

    $pages;

	if (!isset($_GET['search'])) 
	{
	    wp_redirect(get_site_url());
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style type="text/css">
        #search_div {
            width: unset;
            margin-left: 28%;
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
        @media (max-width: 768px) {
            .person{
                -ms-flex: 0 0 55% !important;
                flex: 0 0 55% !important;
                max-width: 55% !important;
            }
            .row
            {
                justify-content: center;
            }
        }
	</style>
</head>
<body>
	<?php get_header(); ?>
<!-- 	<div id="header">
		<div id="logo_div">
			<span><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span>
		</div>
		<div id="search_div">
			<form action="<?php echo get_site_url() . '/search-2/' ?>" metod="get">
				<div id="search">
					<label for="search_input" id="search_logo"><img src="<?php the_field('search_img', 15); ?>" alt="" ></label>
					<input type="text" name="search" id="search_input">	
					<button id="poisk"><?php the_field('поиск_' . _get_lang_(), 15); ?></button>
				</div>
			</form>
		</div>

		<div id="add_history"><?php the_field('добавить_свою_историю_' . _get_lang_(), 15); ?></div>
		<div id="menu">
			<?php the_field('меню_' . _get_lang_(), 15); ?>
			<?php include 'menu.php'; ?>
		</div>
		<?php include 'lang.php'; ?>
	</div> -->

	<div class="container text-center">
		<div id="info_div" style="text-align: left">
			<a href="/" style="color: #606060;font-family: Roboto !important;"><?php echo mb_strtoupper(mb_substr(get_field('главная_' . _get_lang_(), 15), 0, 1)) . mb_substr(get_field('главная_' . _get_lang_(), 15), 1); ?></a>
			<span id="arrow-right">
				<img src="<?php echo bloginfo('template_url') . '/files/icons/obshestvennie-deyateli/arrow-right.png'; ?>" alt="">
			</span>
			<a style="text-transform: none; text-decoration: none;     font-size: 17px;"><?php echo $_GET['search']; ?></a>
		</div>

		<div id="people">
			<?php if(count(search_page($_GET['search'])) > 0): ?>
                <div class="row">
					<?php foreach (search_page($_GET['search']) as $key => $value): ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 person">
                            <img src="<?php the_field('photo', $value['ID']); ?>" alt="">
                            <div class="personData">
                                <span class="nameSurname"><?php echo mb_strtoupper(mb_substr(get_field('name_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('name_' . _get_lang_(), $value['ID']), 1); ?></span>
                                <div class="profession"><?php echo mb_strtoupper(mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('profession_Лидер_фракции_' . _get_lang_(), $value['ID']), 1); ?><?php echo ' ' . mb_strtoupper(mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $value['ID']), 0, 1)) . mb_substr(get_field('парламентская_фракция_ата-мекен_' . _get_lang_(), $value['ID']), 1); ?></div>
                            </div>
                            <a href="<?php echo get_permalink($value['ID']); ?>">
								<?php the_field('подробнее_' . _get_lang_(), 15); ?>
                                <img src="<?php echo bloginfo('template_url') . '/files/icons/obshestvennie-deyateli/arrow-right.png'; ?>"
                                     alt="">
                            </a>
                        </div>

					<?php endforeach; ?>
                </div>
			<?php else: ?>
					<div class="row" style="display: flex; justify-content: center; height: 120px">
						<div class="person">
							Поиск не дал результатов
						</div>
					</div>

			<?php endif; ?>


		</div>
	</div>

	<?php get_footer(); ?>
	<script>
		$("#menu").click(function(e){
			e.stopPropagation()
			$("#hidden-menu").toggleClass('hiddenMenu');
		})

		$("#hidden-menu").click(function(e){
			e.stopPropagation();
		})

		$('body').click(function(){
			$("#hidden-menu").addClass('hiddenMenu');
		})
	</script>
</body>
</html>