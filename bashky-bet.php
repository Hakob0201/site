
<?php
    /*
    Template Name: Bashky bet
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles4.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/footer.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Document</title>
</head>
<body>
	<?php get_header(); ?>
	<!-- <div id="header">
		<div id="logo_div">
			<img src="<?php the_field('logoimg', 15); ?>" alt="">
			<?php include 'menu.php'; ?>
		</div>
		<div id="border"></div>
		<div id="adding-button"><img src="<?php the_field('imgplus', 15); ?>" alt=""><?php the_field('добавить_свою_историю_' . _get_lang_(), 15); ?></div>
		<div id="right-div">
			<?php include 'lang.php'; ?>
			<div id="search">
				<div id="search_div">
					<form action="<?php echo get_site_url() . '/search-2/' ?>" metod="get">
						<div id="hidden-search" class="hiddenSearch">
							<label for="search_input" id="search_logo">
							<img src="<?php the_field('search_img', 15); ?>" alt="" ></label>
							<input type="text" name="search" id="search_input">
							<button id="poisk"><?php the_field('поиск_' . _get_lang_(), 15); ?></button>
						</div>
					</form>
				</div>
			</div>
			<span><img src="<?php the_field('search_img', 15); ?>" alt=""></span>
		</div>
	</div> -->

	<div id="header-under">
		<div id="header-under-data">
			<p><?php the_field('пандемия',396); ?></p>
			<p id="header-under-data-description"><?php the_field('пандемия_text',396); ?></p>
		</div>

		<div id="navigation">
			<div id="round">
				
			</div>

			<div id="navigation-button">
				<img src="<?php the_field('slaq_img',396); ?>" alt="">
			</div>
		</div>
	</div>

	<div id="content">
		<div id="content-body">
			<div id="row1">
				<div class="tableColumn">
					<img src="<?php the_field('1img',396); ?>" alt="">
					<div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('1img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('2img',396); ?>" alt="">
					<div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('2img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('3img',396); ?>" alt="">
					<div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('3img_text',396); ?>
							<span></span>
					    </span>
				    </div>
				</div>
			</div>
			<div id="row2">
				<div class="tableColumn">
					<img src="<?php the_field('4img',396); ?>" alt="">
					<div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('4img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('5img',396); ?>" alt="">
					<div class="tableColumnDiv">
						<span class="tableColumnSpan">
						<?php the_field('5img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('6img',396); ?>" alt="">
					<div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('6img_text',396); ?>
							<span></span>
					    </span>
				    </div>
				</div>
			</div>
			<div id="row3">
				<div class="tableColumn">
					<img src="<?php the_field('7img',396); ?>" alt="">
					<div class="tableColumnHigh">
						<span class="tableColumnSpan">
							<?php the_field('7img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('8img',396); ?>" alt="">
					<div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('8img_text',396); ?>
							<span></span>
						</span>
					</div>
				</div>

				<div class="tableColumn">
					<img src="<?php the_field('9img',396); ?>" alt="">
					<div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('9img_text',396); ?>
							<span></span>
					    </span>
				    </div>
				</div>
			</div>
		</div>
	</div>


	<?php get_footer(); ?>
	<script>
		$("#navigation-button").click(function() {
		    $('html, body').animate({
		        scrollTop: $("#content").offset().top
		    }, 700);
		});

		$("#open-hidden-search").click(function(){
			$("#hidden-search").toggleClass('hiddenSearch');

		})

		$("#logo_div img").click(function(e){
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
