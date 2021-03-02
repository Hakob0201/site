<div id="header">
	<div id="logo_div">
		<img src="<?php the_field('logoimg', 15); ?>">
        <?php include 'menu.php'; ?>
	</div>
	<div id="border"></div>
	<div id="adding-button" onclick="location.href = '<?php echo get_site_url() . '/dobavit-istoriyu'; ?>'">
		<img src="<?php the_field('imgplus', 15); ?>">
        <span class="d_store"><?php the_field('добавить_свою_историю_' . _get_lang_(), 15); ?></span>
	</div>
	<div id="right-div">
        <?php include 'lang.php'; ?>
		<div id="search">
			<div id="search_div">
				<form action="<?php echo get_site_url() . '/search-2/' ?>" metod="get">
					<div id="hidden-search" class="hiddenSearch">
						<label for="search_input" id="search_logo">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="18px" height="18px" viewBox="0 0 612.01 612.01" style="enable-background:new 0 0 612.01 612.01;" xml:space="preserve">
                                <g>
                                    <g id="_x34__4_">
                                        <g>
                                            <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0     C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586     l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8     c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407     S377.82,467.8,257.493,467.8z"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
						</label>
						<input type="text" name="search" id="search_input">
						<button id="poisk"><?php echo mb_strtoupper(mb_substr(get_field('поиск_' . _get_lang_(), 15), 0, 1)) . mb_substr(get_field('поиск_' . _get_lang_(), 15), 1); ?></button>
					</div>
				</form>
			</div>
		</div>
		<span>
            <img src="<?php the_field('search_img', 15); ?>" ; id="open-hidden-search">
        </span>
	</div>
</div>

<div id="myOverlay" class="overlay">
	<span class="closebtn" onclick="closeSearch()" title="Close Overlay">x</span>
	<div class="overlay-content">
		<form action="<?php echo get_site_url() . '/search-2/' ?>" method="get">
			<input type="text" placeholder="<?php the_field('поиск_' . _get_lang_(), 15); ?>.." name="search">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
	</div>
</div>
<style type="text/css">
    #adding-button {
        cursor: pointer;
    }

    .tableColumn img {
        width: 310px;
    }

    .tableColumnSpan {
        padding: 10px;
    }


/*     #border {
    position: absolute;
    width: 60px !important;
    height: 40px !important;
    left: 50px !important;
    top: 20px !important;
    border: unset !important;
    border-top: 0.1px solid #000000 !important;
    transform: rotate( 
-90deg
 ) !important;
    max-height: 1088px;
    } */

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
        margin-bottom: 15px;
    }

    #navigation {
        align-items: center;
        height: 95px;
        height: 50%;
        width: 100%;
        display: flex;
        justify-content: center;
        position: unset;
        margin: unset;
        padding-bottom: 25px;
        box-sizing: border-box;
    }

    #header-under-data-description {
        margin-top: 50px;
    }

    #header-under-fon {
        background-repeat: no-repeat !important;
        background-size: cover !important;
    }

    #header {
        border: unset;
    }

    #header-under {
        width: 100% !important;
        padding-top: 120px !important;
    }

    #navigation-button {
        position: relative;
        top: 25px;
    }

    .tableColumnDiv:hover {
        background: #00000030;
        transition-duration: 0.5s;
    }

    @font-face {
        font-family: 'RBCGrotesk';
        src: url('files/fonts/RBCGrotesk-Light.woff');
    }


    @font-face {
        font-family: 'Akzidenz-Grotesk Pro';
        src: url('files/fonts/Grotesk-pro.woff');
    }

    @font-face {
        font-family: 'Roboto';
        src: url('files/fonts/Roboto.woff');
    }
    @font-face {
        font-family: 'Merriweather';
        src: url('files/fonts/Merriweather-Bold.ttf');
    }
    @font-face {
        font-family: 'Merriweather';
        src: url('files/fonts/Merriweather-Italic.ttf');
    }
    @font-face {
        font-family: 'Merriweather';
        src: url('files/fonts/Merriweather-Regular.ttf');
    }
    

    * {
        margin: 0;
        padding: 0;
        font-family: 'Roboto', san-serif;
    }

    #header {
        position: relative;
        height: 81px;
        max-width: 1240px;
        margin: auto;
        border-bottom: 0.5px solid #000000;
        display: flex;
        align-items: center;
    }

    #header > * {
        height: 0;
        display: flex;
        align-items: center;
    }


    #logo_div {
        position: relative;
    }

    #logo_div img {
        cursor: pointer;
        margin-top: 16px;
    }


    .hiddenMenu {
        display: none !important;
    }

    #hidden-menu a {
        text-decoration: none;
        color: black;
    }

    #hidden-menu a:not(:first-child) {
        margin-top: 15px;
    }

    #adding-button {
        margin-left: 63px;
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 11px;
        line-height: 13px;
        text-transform: capitalize;
        color: #000000;
        margin-top: 13px;
    }

    #adding-button > img {
        margin-right: 6px;
    }

    #right-div {
        display: flex;
        position: absolute;
        right: 0;
    }

    #right-div span {
        cursor: pointer;
    }

    #languages {
        display: flex;
        margin-right: 37px;
        position: unset !important;
    }

    #languages > * {
        height: 39px;
        width: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #search {
        position: unset !important;
        display: flex;
    }

    #search_div {
        margin-left: unset !important;
        position: relative;
    }

    #search > span {
        margin-top: 5px;
    }

    #search_div form {
        width: 100%;
    }

    #search_input {
        height: 39px;
        width: 264px;
        border-radius: 50px;
        border: 0.5px solid #938C8C;
        outline: none;
        box-sizing: border-box;
        padding: 0px 63px 0px 45px;
    }
	
    #hidden-search {
        position: relative;
        margin-right: 37px;
    }

    .hiddenSearch {
        display: none;
    }

    #hidden-search > * {
        background-color: inherit
    }

    #hidden-search label {
        position: absolute;
        margin-top: -2px;
        height: 95%;
        width: 20px;
        box-sizing: border-box;
        cursor: pointer;
        right: 1px;
        padding-right: 20px;
        padding-top: 10px;
    }

    #search button {
        position: absolute;
        width: 55px;
        right: 2px;
        top: 1px;
        height: 95%;
        border: none;
        outline: none;
        cursor: pointer;
        box-shadow: none;
        border-bottom-right-radius: 12px;
        border-top-right-radius: 12px;
    }

    #search_logo {
        box-sizing: border-box;
        position: absolute;
        left: 0px;
        top: 10px;
        padding-left: 18px;
        margin: 1px;
        top: 0;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .selectedLanguage {
        background: #4F4C4C;
        color: white;
    }


</style>

