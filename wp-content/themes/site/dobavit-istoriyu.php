<?php
/*
    Template Name: Dobavit istoriyu
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/styles1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet"
          href="https://mojoaxel.github.io/bootstrap-select-country/dist/css/bootstrap-select-country.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Covid stories</title>
    <style type="text/css">
        body {
            background: #E5E5E5 !important;
        }

        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 100% !important;
        }
        #info_div a {
            font-family: 'RBCGroteskLight' !important;
            font-style: normal;
            font-weight: 200;
            font-size: 16px;
            line-height: 19px;
            text-decoration-line: underline;
            text-transform: capitalize;
            color: #000000;
        }

        .btn.dropdown-toggle.btn-default {
            height: 57px;
        }

        .btn.dropdown-toggle.btn-default{
            width: 133px!important;
        }
        .bs-caret{
            display:none;
        }
        .dropdown-menu.open {
            width: 50% !important;
        }

        input[type="file"] {
            display: none !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }

        #history_textarea {
            height: 300px;
        }

        body {
            font-size: 14px !important;
        }

        #border {
            position: absolute;
            width: 85px !important;
            left: 17px;
            top: 72px;
            border: unset;
            border-top: 0.5px solid #000000;
            transform: rotate(
                    -90deg
            );
        }

        #right-div {
            align-items: end;
        }

        #info_span {
            text-transform: unset !important;
        }
        .phone_input{
         width: 320px!important;   
        }

        @media (min-width: 1000px) {
            .content {
                width: 1240px;
                max-width: 1240px;
                margin: auto;
            }
        }


        #footer_div1 {
            margin: unset !important;
        }


        #first-raw,
        #second-raw,
        #third-raw,
        #forth-raw {
            margin: unset !important;
        }
        #first-raw,#second-raw,#third-raw,#forth-raw{
            flex-wrap: wrap;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        form button {
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            height: 50px;
            background: #C4C4C4;
            box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
            margin: 15px 0 50px 0;
            padding: 10px 100px;
        }

        .formInput
        {
            margin-top: 20px;
        }

        form button {
            margin-left: 15px;
        }

        @media (max-width: 992px) {
            #history_textarea,
            #phone_input,
            #age_input,
            #photo_source {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
<?php get_header(); ?>

<div id="content" class="content container">
      <div class="dd">
             <div id="info_div" style="text-align: left">
                <a href="/"><?php echo mb_strtoupper(mb_substr(get_field('главная_' . _get_lang_(), 15), 0, 1)) . mb_substr(get_field('главная_' . _get_lang_(), 15), 1); ?></a>
                <span id="arrow-right" style="padding: 0 5px 0 5px;">
                        <img src="<?php echo bloginfo('template_url') . '/files/icons/obshestvennie-deyateli/arrow-right.png'; ?>"
                             alt="">
                </span>
                <a style="text-transform: none; text-decoration: none;"><?php echo mb_strtoupper(mb_substr(get_field('добавить_свою_историю_' . _get_lang_(), 15), 0, 1)) . mb_substr(get_field('добавить_свою_историю_' . _get_lang_(), 15), 1); ?></a>
           </div>

           <div id="info_span">Знаком <span class="redColor">*</span> отмечены обязательные поля для заполнения</div>
      </div>
    <form action="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php" id="add_history_form"
          enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_history_form">
        <div id="first-raw" class="" style="flex-wrap: wrap;">
            <div class="formInput">
                <label for="surname_input"><?php the_field('фамилия', 160); ?> <span class="redColor">*</span></label>
                <input type="text" class="this_on_ch" name="surname" id="surname_input">
                <span class="invalid-feedback error-surname" style="display: inline;"></span>
            </div>

            <div class="formInput">
                <label for="name_input"><?php the_field('имя', 160); ?> <span class="redColor">*</span></label>
                <input type="text" class="this_on_ch" name="name" id="name_input">
                <span class="invalid-feedback error-name" style="display: inline;"></span>
            </div>

            <div class="formInput">
                <label for="middlename_input"><?php the_field('отчество', 160); ?> </label>
                <input type="text" class="this_on_ch" name="middlename" id="middlename_input">
                <span class="invalid-feedback error-middlename" style="display: inline;"></span>
            </div>

            <div class="formInput">
                <label for="age_input"><?php the_field('возраст', 160); ?> <span class="redColor">*</span></label>
                <div id="age_div">
                    <input type="number" class="this_on_ch" name="age" id="age_input">
                    <div id="arrows">
                                <span style="" id="arrow-up">
                                    <img src="<?php the_field('img_1', 160); ?>" alt="" class="tbtn"></span>
                        <span id="arrow-down">
                                    <img src="<?php the_field('img_2', 160); ?>" alt="" class="tbtn"></span>
                    </div>
                </div>
                <span class="invalid-feedback error-age" style="display: inline;"></span>
            </div>
        </div>


        <div id="second-raw" class="">
            <div class="formInput">
                <label for="profession_input"><?php the_field('профессия', 160); ?> <span
                            class="redColor">*</span></label>
                <input type="text" class="this_on_ch" name="profession" id="profession_input">
                <span class="invalid-feedback error-profession" style="display: inline;"></span>
            </div>

            <div class="formInput">
                <label for="email_input"><?php the_field('e-mail', 160); ?> <span class="redColor">*</span></label>
                <input type="email" class="this_on_ch" name="email" id="email_input">
                <span class="invalid-feedback error-email" style="display: inline;"></span>
            </div>

            <div class="formInput" style="justify-content: flex-end">
                <select id="flag_input" class="selectpicker countrypicker" data-flag="true" data-default="KG"
                        name="flag"></select>
                <span class="invalid-feedback error-flag" style="display: inline; color: transparent;"></span>
            </div>

            <div class="formInput">
                <label for="phone_input"><?php the_field('телефон_для_связи', 160); ?> </label>
                <input type="text" class="this_on_ch" name="phone" id="phone_input">
                <span class="invalid-feedback error-phone" style="display: inline;"></span>
            </div>
        </div>

        <div id="third-raw" class="">
            <div class="formInput">
                <label for="history_textarea"><?php the_field('напишите_вашу_историю', 160); ?> <span
                            class="redColor">*</span></label>
                <textarea class="this_on_ch" name="history_text" id="history_textarea"></textarea>
                <span class="invalid-feedback error-history_text" style="display: inline;"></span>
            </div>
            <div class="formInput">
                <label for="photo_upload"><?php the_field('прикрепить_фото', 160); ?> <span
                            class="redColor">*</span></label>
                <label id="upload_photo_div" for="photo_upload">
                            <span>
                                <img src="<?php bloginfo('template_url'); ?>/files/icons/upload.png" alt=""></span>
                    <span align='center'> <?php the_field('перетащите_файл', 160); ?> <br><?php the_field('для_загрузки', 160); ?> </span>
                    <input type="file" hidden name="photo" id="photo_upload">
                </label>
                <span class="invalid-feedback error-photo" style="display: inline;"></span>

            </div>

            <div class="formInput">
                <label for="photo_description"><?php the_field('описание_фото', 160); ?> <span class="redColor">*</span></label>
                <input type="text" class="this_on_ch" name="photo_description" id="photo_description">
                <span class="invalid-feedback error-photo_description" style="display: inline;"></span>
            </div>

            <div class="formInput">
                <label for="photo_source"><?php the_field('источник_фото', 160); ?> <span
                            class="redColor">*</span></label>
                <input type="text" class="this_on_ch" name="photo_source" id="photo_source">
                <span class="invalid-feedback error-photo_source" style="display: inline;"></span>
            </div>
        </div>

<!--
        <div id="forth-raw" class="row">
        </div>
-->
       <div class="butt">
            <button><?php the_field('отправить', 160); ?> </button>
           
       </div>
    </form>
</div>


<?php get_footer(); ?>

<script src="<?php bloginfo('template_url'); ?>/scripts/dobavit-istoriyu-script.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://mojoaxel.github.io/bootstrap-select-country/dist/js/bootstrap-select-country.min.js"></script>
<script type="text/javascript">
    $('body').off('submit', '#add_history_form').on('submit', '#add_history_form', function (e) {
        e.preventDefault();
        $('.invalid-feedback').empty();
        sendUserAjax(this, $(this).attr('action'));
    })

    function sendUserAjax(formData, action)
    {
        $.ajax({
            type: 'post',
            url: action,
            data: new FormData(formData),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                if (data.status === 200)
                    location.reload();
            },
            error: function(data)
            {
                if (data.status === 200)
                    location.reload();

                if (data.status === 422)
                {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        // console.log(key+ " " +value);
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                console.log(key + " " + value);
                                console.log($(".error-"+key))
                                $(".error-"+key).html(`${value}`)
                            });
                        }
                    });
                }
            }
        })
    }

    $(document).on('change', '.creat_mod_in', function () {
        $('.error-' + $(this).attr('name')).empty()
    })
</script>
</body>
</html>





