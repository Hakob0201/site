<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/glavnaya.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.11/swiper-bundle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Glavnaya</title>
    <style type="text/css">
        #adding-button {
            cursor: pointer;
        }
		.slid2{
			width: 126px!important;
			height: 95px!important;
		}
        .tableColumn {
            cursor: pointer;
            display: flex;
            justify-content: center;
            /*align-items: center;*/
            padding: 0;
            max-width:234px!important;
            max-height:300px!important;
        }


        .tableColumn img {
            width: 100%;
        }

        .tableColumnSpan {
            padding: 10px;
            padding-bottom:5px;
        }

			#border {
                position: absolute;
                width: 79px !important;
                left: 19px;
                top: 67px;
                border: unset;
                border-top: 0.5px solid #000000;
                transform: rotate(
                        -90deg
                );
			}

        .arrow {
            opacity: 0.5;
            display: none;
            position: absolute;
            fill: #fff;
            width: 34px;
            height: 34px;
            margin: auto;
            border: 2px solid white;
            vertical-align: 0px;
            border-radius: 100%;
            margin-left: -25px;
            animation: arrowMovements 1000ms infinite alternate ease-in-out;
            cursor: pointer;
            -webkit-backface-visibility: hidden;
            top: -42px;
        }

        @keyframes arrowMovements {
            0% {
                transform: translateY(0px);
            }

            100% {
                transform: translateY(-8px);
            }
        }

        #round {
            box-sizing: border-box;
            height: 15px !important;
            width: 15px !important;
            border-radius: 50%;
            background: #EB8559;
            display: block !important;
            margin-left: 5px !important;
            margin-bottom: -5px !important;
        }

        #header-under-data-description {
            margin-top: 17px!important;
        }

        #header-under-fon {
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }

        #header {
        <?php if(!empty(get_field('baskground_img', 102))): echo 'border: unset !important'; else: echo 'border-bottom: 0.5px solid #000000 !important;'; endif; ?>
        }

        #header-under {
            width: 100% !important;
        <?php !empty(get_field('baskground_img', 102)) ? 'background: url('. get_field('baskground_img', 102).')' : 'background: #00000040;'; ?> 
            padding-top: 56px !important;
        }

        .tableColumnDiv:hover {
            background: #00000030;
            transition-duration: 0.5s;
        }
		.slider2>.owl-nav{
			display: block!important;		
		}
		.slider2{
			margin-top:35px;
			margin-bottom: 30px;
		}
		.slider2>.owl-nav>.owl-prev{
			position: absolute!important;
			left: 25px!important;
			top: 22%!important;
			font-size: 34px!important;
		}
		.slider2>.owl-nav>.owl-next{
			position: absolute!important;
			right: 25px!important;
			top: 22%!important;
			font-size: 34px!important;
		}
		.slider2{
			position: relative;
		}
        .row {
            justify-content: center;
        }

        .tableColumn {
            margin-top: 1.5rem !important;
            margin-left: 1.5rem !important;
        }

        #header-under-data-p
        {
        font-family: 'RBCGrotesk';
        }


        #header-under {
            width: 100% !important;
        <?php !empty(get_field('baskground_img', 102)) ? 'background: url('. get_field('baskground_img', 102).')' : 'background: #00000040;'; ?> 
            padding-top: unset!important;
        }
		
        element.style {
        }
        #header > * {
            height: 0;
            display: flex;
            align-items: center;
        }

        #header-under-data-p1
        {
	        font-size: 47px !important;
        }


    </style>
</head>
<body>
<?php get_header(); ?>
<div id="header-under-fon"
     style="<?php if (!empty(get_field('baskground_img', 102))): echo 'background: url(' . get_field('baskground_img', 102) . ')'; endif; ?>">
    <div id="header-under1"
         style="<?php if (!empty(get_field('baskground_img', 102))): echo 'background: #00000030'; else: echo 'color: #000'; endif; ?>">
        <div id="header-under-data">
            <p id="header-under-data-p1"
               style="<?php if (empty(get_field('baskground_img', 102))): echo 'color: #000'; endif; ?>">
                <?php the_field('голоса_кыргызстанце_' . _get_lang_(), 102); ?>
            </p>
            <p id="header-under-data-description"
               style="<?php if (empty(get_field('baskground_img', 102))): echo 'color: #000'; endif; ?>">
                <?php the_field('голоса_кыргызстанце_text_' . _get_lang_(), 102); ?>
            </p>
        </div>

        <div id="navigation">


            <div id="navigation-button">
                <!-- white bttn -->
                <!-- <img src="<?php the_field('стрелка', 102); ?>" alt="">  -->
                <div class="arrow"
                     style="display: block; <?php if (empty(get_field('baskground_img', 102))): echo 'border-color: #000'; endif; ?>">
                    <svg x="0px" y="0px" viewBox="0 0 500 500"
                         style="<?php if (empty(get_field('baskground_img', 102))): echo 'fill: #000'; endif; ?>">
                        <path d="M111,187.4c-7.6,6.6-7.6,17.3,0,23.9l116.2,101.2c7.6,6.6,19.8,6.6,27.4,0l116.2-101.2 c3.8-3.3,5.7-7.6,5.7-11.9c0-4.3-1.9-8.6-5.7-11.9c-7.6-6.6-19.8-6.6-27.4,0l-102.5,89.3l-102.5-89.3 C130.8,180.9,118.6,180.9,111,187.4z"></path>
                    </svg>
                </div>
                <!-- black bttn -->
                <!-- <img src="/files/icons/bashky-bet/navigation.png" alt=""> -->
            </div>
        </div>
    </div>
</div>

<div id="content">
    <?php if (_get_lang_() == 'ру'): ?>
        <div class="container text-center pb-5" style="background: #DDDADA;">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=сектор_образования'; ?>'">
                    <img src="<?php the_field('сектор_образования_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('сектор_образования_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=сектор_здравоохранения'; ?>'">
                    <img src="<?php the_field('сектор_здравоохранения_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('сектор_здравоохранения_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=медиа-сектор'; ?>'">
                    <img src="<?php the_field('медиа-сектор_img', 102); ?>">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('медиа-сектор_' . _get_lang_(), 137); ?>
						    <span></span>
					    </span>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=общественные_деятели'; ?>'">
                    <img src="<?php the_field('общественные_деятели_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('общественные_деятели_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=волонтеры_и_гражданское_общество'; ?>'">
                    <img src="<?php the_field('волонтеры_и_гражданское_общество_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('волонтеры_и_гражданское_общество_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=правительство_и_штаб_по_covid-19'; ?>'">
                    <img src="<?php the_field('правительство_и_штаб_по_covid-19_img', 102); ?>">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						  	<?php the_field('правительство_и_штаб_по_covid-19_' . _get_lang_(), 137); ?>
						    <span></span>
					    </span>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=парламент_и_президент'; ?>'">
                    <img src="<?php the_field('парламент_и_президент_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('парламент_и_президент_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=местная_власть'; ?>'">
                    <img src="<?php the_field('местная_власть_img', 102); ?>">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('местная_власть_' . _get_lang_(), 137); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=дополнительные_материалы'; ?>'">
                    <img src=" <?php the_field('дополнительные_материалы_img', 102); ?>">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						   	<?php the_field('дополнительные_материалы_' . _get_lang_(), 137); ?>
						    <span></span>
					    </span>
                    </div>
                </div>

            </div>
        </div>

    <?php else: ?>

        <div class="container text-center pb-5" style="background: #DDDADA;">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('1img_text', 331)); ?>'">
                    <img src="<?php print get_field('1img1', 331)['url']; ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('1img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('2img_text', 331)); ?>'">
                    <img src="<?php the_field('2img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('2img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('3img_text', 331)); ?>'">
                    <img src="<?php the_field('3img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('3img_text', 331); ?>
							<span></span>
					    </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('4img_text', 331)); ?>'">
                    <img src="<?php the_field('4img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('4img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('5img_text', 331)); ?>'">
                    <img src="<?php the_field('5img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
						<?php the_field('5img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('6img_text', 331)); ?>'">
                    <img src="<?php the_field('6img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('6img_text', 331); ?>
							<span></span>
					    </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('7img_text', 331)); ?>'">
                    <img src="<?php the_field('7img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('7img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('8img_text', 331)); ?>'">
                    <img src="<?php the_field('8img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
						<span class="tableColumnSpan">
							<?php the_field('8img_text', 331); ?>
							<span></span>
						</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 tableColumn" style="cursor: pointer;"
                     onclick="location.href = '<?php echo get_site_url() . '/cat?cat=' . str_replace(' ', '_', get_field('9img_text', 331)); ?>'">
                    <img src="<?php the_field('9img', 331); ?>" alt="">
                    <div class="tableColumnDiv">
					    <span class="tableColumnSpan">
						    <?php the_field('9img_text', 331); ?>
							<span></span>
					    </span>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<!-- Swiper -->
        <div class="owl-carousel owl-theme slider2">  
			<div class="item slid2 container">
				<img src="<?php the_field('university1', 102); ?>" alt="">
        	</div>
			<div class="item slid2 container">
				<img src="<?php the_field('british', 102); ?>" alt="">
        	</div>
			<div class="item slid2 container">
				<img src="<?php the_field('university', 102); ?>" alt="">
        	</div>
			<div class="item slid2 container">
				<img src="<?php the_field('british1', 102); ?>" alt="">
        	</div>
	</div>
<?php get_footer(); ?>


<!-- Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.11/swiper-bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
<style>

    .swiper-container {
        width: 1260px;
        height: 147px;
    }

    .swiper-slide {
        text-align: center;
        font-size: 16px;
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
    .swiper-slide{
        width: 140px!important;
        margin-right: 140px!important;
    }
    .swiper-button-prev,
    .swiper-button-next {
        /*width: calc(var(--swiper-navigation-size) / 10 * 27);*/
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
$('.slider2').owlCarousel({
    loop:true,
    margin:10,
 navigationText: ["<img src='<?php get_field('prev',102)?>'>","<img src='<?php get_field('next',102)?>'>"],    
responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})


</script>

</body>
</html>





