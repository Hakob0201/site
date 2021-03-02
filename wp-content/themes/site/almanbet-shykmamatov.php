<?php
    /*
    Template Name: Almanbet shykmamatov
    */
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/header.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/footer.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.11/swiper-bundle.css">
	<title>Document</title>
	<style type="text/css">
		#search_div
		{
			width: unset;
			margin-left: 28%;
		}
	</style>
</head>
<body>
	<?php get_header(); ?>
	<!-- <div id="header">
		<div id="logo_div"><span style="cursor: pointer;" onclick="location.href = '/'"><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span></div>
		<div id="search_div">
			<form action="">
			<div id="search">
				<label for="search_input" id="search_logo"><img src="<?php the_field('поиск_img', 253); ?>" alt="" ></label>
				<input type="text" name="search" id="search_input">	
				<button id="poisk"><?php the_field('поиск', 253); ?></button>
			</div>
			</form>
		</div>

		<div id="add_history"><?php the_field('добавить_свою_историю', 253); ?></div>
		<div id="menu">
			<?php the_field('меню_' . _get_lang_(), 15); ?>
			<?php include 'menu.php'; ?>
		</div>

		<div id="languages">
			<span>
				<?php the_field('кр', 253); ?>
			</span>
			<span class="selectedLanguage">
				<?php the_field('ру', 253); ?>
			</span>
		</div>
	</div> -->

	<div id="content">
		<div id="info_div">
			<a href=""><?php the_field('главная', 240); ?></a> <span class="arrowRight">
				<img src="<?php the_field('rigth1', 240); ?>" ></span><a href='' id="profession-link"><?php the_field('общественные_деятели', 240); ?><span class="arrowRight"><img src="<?php the_field('rigth2', 240); ?>" alt=""></a><span id="info-user-name-surname"><?php the_field('шыкмаматов_алманбет_насырканович', 240); ?></span>
		</div>

		<div id="person">
			<img src="<?php the_field('person1_img', 240); ?>" alt="">
			<div id="person-info">
				<span><?php the_field('шыкмаматов_алмамбет', 240); ?></span>
				<span id="profession"><?php the_field('лидер_фракции', 240); ?></span>
				<div id="border"></div>
				<span id="bio"><?php the_field('комитет', 240); ?></span>

				<?php echo do_shortcode('[Sassy_Social_Share]'); ?>
			</div>
		</div>
		<div id="photo-description"><?php the_field('описание', 240); ?></div>
		<div id="voice-message">
			<svg width="746" height="82" viewBox="0 0 746 82" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<rect width="746" height="82" fill="url(#pattern0)"/>
				<defs>
				<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
				<use xlink:href="#image0" transform="translate(-0.000797356) scale(0.000947583 0.00862069)"/>
				</pattern>
				<img src="<?php the_field('image_voise', 240); ?>" alt="">
				</defs>
				</svg></div>
	</div>

	<div id="recommendations">
		<div id="recommendations-body">
			<div id="recommendations-heading"><?php the_field('рекомендуемое', 240); ?></div>
			<!-- <img id="prev" src="<?php the_field('prev', 240); ?>" alt="">
			<img id="next" src="<?php the_field('next', 240); ?>" alt="">
			<div id="recommendations-show">
				<div class="recommendedUser">
					<img src="<?php the_field('person1', 240); ?>" alt="">
					<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов', 240); ?></div>
					<div class="recommendedUserProfession"><?php the_field('лидер_фракции', 240); ?></div>
					<a href="" class="recommendedUserProperties"><?php the_field('подробнее1', 240); ?><img style="margin-left: 9px;" src="<?php the_field('arrow-right_1', 240); ?>" alt=""></a>
				</div>

				<div class="recommendedUser">
					<img src="<?php the_field('person3', 240); ?>" alt="">
					<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_2', 240); ?></div>
					<div class="recommendedUserProfession"><?php the_field('лидер_фракции_2', 240); ?></div>
					<a href='' class="recommendedUserProperties"><?php the_field('подробнее_2', 240); ?> <img style="margin-left: 9px;" src="<?php the_field('подробнее_2_img', 240); ?>" alt=""></a>
				</div>

				<div class="recommendedUser">
					<img src="<?php the_field('person2', 240); ?>" alt="">
					<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_3', 240); ?></div>
					<div class="recommendedUserProfession"><?php the_field('лидер_фракции_3', 240); ?></div>
					<a href="" class="recommendedUserProperties">
						<?php the_field('подробнее3', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_3img', 240); ?>" alt=""></a>
				</div>

				<div class="recommendedUser">
					<img src="<?php the_field('person4', 240); ?>" alt="">
					<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_4', 240); ?></div>
					<div class="recommendedUserProfession"><?php the_field('лидер_4', 240); ?></div>
					<a href="" class="recommendedUserProperties"> <?php the_field('подробнее_4', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_4_img', 240); ?>" alt=""></a>
				</div>
			</div> -->
			<!-- Swiper -->
		  	<div class="swiper-container">
			    <div class="swiper-wrapper">
			        <div class="swiper-slide">
			        	<div class="recommendedUser">
							<img src="<?php the_field('person4', 240); ?>" alt="">
							<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_4', 240); ?></div>
							<div class="recommendedUserProfession"><?php the_field('лидер_4', 240); ?></div>
							<a href="" class="recommendedUserProperties"> <?php the_field('подробнее_4', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_4_img', 240); ?>" alt=""></a>
						</div>
					</div>
					<div class="swiper-slide">
			        	<div class="recommendedUser">
							<img src="<?php the_field('person4', 240); ?>" alt="">
							<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_4', 240); ?></div>
							<div class="recommendedUserProfession"><?php the_field('лидер_4', 240); ?></div>
							<a href="" class="recommendedUserProperties"> <?php the_field('подробнее_4', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_4_img', 240); ?>" alt=""></a>
						</div>
					</div>
					<div class="swiper-slide">
			        	<div class="recommendedUser">
							<img src="<?php the_field('person4', 240); ?>" alt="">
							<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_4', 240); ?></div>
							<div class="recommendedUserProfession"><?php the_field('лидер_4', 240); ?></div>
							<a href="" class="recommendedUserProperties"> <?php the_field('подробнее_4', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_4_img', 240); ?>" alt=""></a>
						</div>
					</div>
					<div class="swiper-slide">
			        	<div class="recommendedUser">
							<img src="<?php the_field('person4', 240); ?>" alt="">
							<div class="recommendedUserData"><?php the_field('алманбет_шыкмаматов_4', 240); ?></div>
							<div class="recommendedUserProfession"><?php the_field('лидер_4', 240); ?></div>
							<a href="" class="recommendedUserProperties"> <?php the_field('подробнее_4', 240); ?><img style="margin-left: 9px;" src="<?php the_field('подробнее_4_img', 240); ?>" alt=""></a>
						</div>
					</div>
			    </div>
			    <!-- Add Pagination -->
			    <!-- <div class="swiper-pagination"></div> -->
			    <!-- Add Arrows -->
			    <div class="swiper-button-next"></div>
			    <div class="swiper-button-prev"></div>
			</div>
		</div>
	</div>


	<div id="footer-part">
		<div id="footer">
			<div id="footer_div1">
				<span style="margin-bottom: 41px"><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span>
				<span><?php the_field('образовательное_учреждение', 281); ?></span>
			</div>

			<ul id="footer_ul1">
				<li><?php the_field('сектор_образования', 281); ?></li>
				<li><?php the_field('сектор_здравоохранения', 281); ?></li>
				<li><?php the_field('медиа-сектор', 281); ?></li>
				<li><?php the_field('общественные_деятели', 281); ?></li>
			</ul>

			<ul id="footer_ul2">
				<li><?php the_field('волонтеры_и_гражданское_общество', 281); ?></li>
				<li><?php the_field('правительство_и_штаб_по_covid-19', 281); ?></li>
				<li><?php the_field('парламент_и_президент', 281); ?></li>
				<li><?php the_field('местная_власть', 281); ?></li>
			</ul>
		</div>
	</div>

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
	        background: #fff;

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
	    .swiper-button-next
	    {
	    	width: calc(var(--swiper-navigation-size) / 10 * 27);
	    }

	    .swiper-button-prev:after, 
	    .swiper-container-rtl .swiper-button-next:after,
	    .swiper-button-next:after, 
	    .swiper-container-rtl .swiper-button-prev:after
	    {
	   		font-size: 25px;
    		color: #202020;
	    }

	    .swiper-slide
	    {
	    	margin: 80px 0 80px 0;
	    }
	</style>

	<script type="text/javascript">

		var swiper = new Swiper(".swiper-container", {
							    slidesPerView: 4,
							    spaceBetween: 30,
							    slidesPerGroup: 4,
							    loop: true,
							    loopFillGroupWithBlank: true,
							    pagination: { el: ".swiper-pagination", clickable: true },
							    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
							});


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
