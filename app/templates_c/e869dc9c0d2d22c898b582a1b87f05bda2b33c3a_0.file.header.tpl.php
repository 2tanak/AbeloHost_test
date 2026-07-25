<?php
/* Smarty version 4.5.7, created on 2026-07-25 13:08:30
  from '/var/www/app/app/templates/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6a64b54e142637_12590307',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e869dc9c0d2d22c898b582a1b87f05bda2b33c3a' => 
    array (
      0 => '/var/www/app/app/templates/header.tpl',
      1 => 1784984907,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a64b54e142637_12590307 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbeloHost Video Platform</title>
    <!-- Подключаем скомпилированный из SCSS файл стилей -->
    <link rel="stylesheet" href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'auto_version' ][ 0 ], array( $_smarty_tpl->tpl_vars['themeCss']->value ));?>
">
</head>
<body>
<header>
    <section id="navigate">
		
		<div class="navigate">
				<input class="side-menu" type="checkbox" id="side-menu" />
				<label class="hamb" for="side-menu"><span class="hamb-line"></span></label>

				<nav class="nav">
					<ul>
						<li class='href_hover'><a href="/">Главная</a></li>
					</ul>
				</nav>
			</div>
		
	</section>
</header>
<?php }
}
