<!-- 
<?php
    /*
    Template Name:Obshestvennie deyateli
    */
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/header.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/footer.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<div id="header">
		<div id="logo_div"><span><img src="<?php bloginfo('template_url'); ?>/files/icons/logo.png" style="width: 200px;"></span></div>
		<div id="search_div">
			<form action="">
			<div id="search">
				<label for="search_input" id="search_logo"><img src="<?php the_field('search_img', 427); ?>" alt="" ></label>
				<input type="text" name="search" id="search_input">	
				<button id="poisk"><?php the_field('поиск', 427); ?></button>
			</div>
			</form>
		</div>

		<div id="add_history"><?php the_field('добавить_свою_историю', 427); ?></div>
		<div id="menu"><?php the_field('меню', 427); ?>
			<ul id="hidden-menu" class="hiddenMenu">
				<a href="<?php echo get_site_url() . '/cat?cat=сектор_образования'; ?>"><?php the_field('сектор_образования',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=сектор_здравоохранения'; ?>"><?php the_field('сектор_здравоохранения',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=медиа_сектор'; ?>"><?php the_field('медиа-сектор',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=общественные_деятели'; ?>"><?php the_field('общественные_деятели',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=волонтеры_и_гражданское_общество'; ?>"><?php the_field('волонтеры_и_гражданское_общество',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=правительство_и_штаб_по_covid-19'; ?>"><?php the_field('правительство_и_штаб_по_covid-19',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=парламент_и_президент'; ?>"><?php the_field('парламент_и_президент',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=местная_власть'; ?>"><?php the_field('местная_власть',441); ?> </a>
				<a href="<?php echo get_site_url() . '/cat?cat=дополнительные_материалы'; ?>"><?php the_field('дополнительные_материалы',441); ?> </a>
			</ul>
		</div>

		<div id="languages">
			<span>
				<?php the_field('кр', 427); ?>
			</span>
			<span class="selectedLanguage">
				<?php the_field('ру', 427); ?>
			</span>
		</div>
	</div>

	<div id="content">
		<div id="info_div">
			<a href=""><?php the_field('главная', 501); ?></a> <span id="arrow-right">
				<img src="<?php the_field('arrow-right', 501); ?>" alt=""></span><?php the_field('общественные_деятели', 501); ?>
		</div>

		<div id="people">
			<div id="row1">
				<div class="person">
					<img src="<?php the_field('photo1', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name1', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider1', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее1', 501); ?> 
					 <img src="<?php the_field('подробнее_img1', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo2', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name2', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider2', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее2', 501); ?>
					  <img src="<?php the_field('подробнее_img2', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo3', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name3', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider3', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее3', 501); ?> 
					 <img src="<?php the_field('подробнее_img3', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo4', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name4', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider4', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее4', 501); ?> 
					 <img src="<?php the_field('подробнее_img4', 501); ?>" alt=""></a>
				</div>
			</div>

			<div id="row2">
				<div class="person">
					<img src="<?php the_field('photo5', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name5', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider5', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее5', 501); ?>  
					<img src="<?php the_field('подробнее_img5', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo6', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name6', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider6', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее6', 501); ?>  <img src="<?php the_field('подробнее_img6', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo7', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name7', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider7', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее7', 501); ?>  
					<img src="<?php the_field('подробнее_img7', 501); ?>" alt=""></a>
				</div>

				<div class="person">
					<img src="<?php the_field('photo8', 501); ?>" alt="">
					<div class="personData">
						<span class="nameSurname"><?php the_field('photo_name8', 501); ?></span>
						<div class="profession"><?php the_field('photo_lider8', 501); ?></div>
					</div>
					<a href=""><?php the_field('подробнее8', 501); ?> 
					<img src="<?php the_field('подробнее_img8', 501); ?>" alt=""></a>
				</div>
			</div>
		</div>
	</div>

	<div id="footer-part">
		<div id="footer">
			<div id="footer_div1">
				<span style="margin-bottom: 41px"><?php the_field('лого', 454); ?></span>
				<span><?php the_field('образовательное_учреждение', 454); ?></span>
			</div>

			<ul id="footer_ul1">
				<li><?php the_field('сектор_образования', 454); ?></li>
				<li><?php the_field('сектор_здравоохранения', 454); ?></li>
				<li><?php the_field('медиа-сектор', 454); ?></li>
				<li><?php the_field('общественные_деятели', 454); ?></li>
			</ul>

			<ul id="footer_ul2">
				<li><?php the_field('волонтеры_и_гражданское_общество', 454); ?></li>
				<li><?php the_field('правительство_и_штаб_по_covid-19', 454); ?></li>
				<li><?php the_field('парламент_и_президент', 454); ?></li>
				<li><?php the_field('местная_власть', 454); ?></li>
			</ul>
		</div>
	</div>
</body>
</html>

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
</script> -->