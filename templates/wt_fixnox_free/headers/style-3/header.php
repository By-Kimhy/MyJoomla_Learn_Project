<?php

/**
 * Transparent Header
 */

defined ('_JEXEC') or die('Restricted Access');

use HelixUltimate\Framework\Platform\Helper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;

$doc                  = Factory::getDocument();
$data                 = $displayData;
$attrs_sticky[]       = '';

$navbar_search = $data->params->get( 'search_position' );

$feature_folder_path = JPATH_THEMES . '/' . $data->template->template . '/features';

$attrs_sticky[] = '';

$mobile_breakpoint_options = $data->params->get('mobile_breakpoint_options', 'm');
$toolbar_visibility     = $data->params->get( 'toolbar_visibility' );

include_once $feature_folder_path . '/contact.php';
include_once $feature_folder_path . '/cookie.php';
include_once $feature_folder_path . '/logo.php';
include_once $feature_folder_path . '/menu.php';
include_once $feature_folder_path . '/mobile.php';
include_once $feature_folder_path . '/search.php';
include_once $feature_folder_path . '/social.php';
include_once $feature_folder_path . '/toolbar.php';

$header_alignment = $data->params->get('header_alignment'); 
$overlay_header = $data->params->get('overlay_header'); 
$transparent_header_extra = $data->params->get('overlay_header') ? ' uk-' . $data->params->get('overlay_header') : '';

$header_wrap[] = '';
$header_wrap[] = 'tm-header uk-visible@' . $mobile_breakpoint_options . ' header-' . $data->params->get( 'header_style' );

// Navbar Container
$navbar_container[] = 'uk-navbar-container';
$navbar_container[] = $data->params->get('header_menu_options') ? ' uk-navbar-primary' : '';

$sticky = $data->params->get('header_navbar');

if ( $sticky ) {

	$attrs_sticky[] = 'sel-target: .uk-navbar-container';
	$attrs_sticky[] = 'cls-active: uk-navbar-sticky';
	$attrs_sticky[] = 'top: 300';
	$attrs_sticky[] = 'media: @' . $mobile_breakpoint_options;

	if ( '2' === $sticky ) {
		$attrs_sticky[] = 'animation: uk-animation-slide-top';
		$attrs_sticky[] = 'show-on-up: true';
	}
}

$app = Factory::getApplication();
$option = $app->input->get('option', '', 'STRING');
$menu_item   = $app->getMenu()->getActive();
$is_builder = $option == 'com_sppagebuilder' || $option == 'com_quix' || $option == 'com_pagebuilderck';

if($menu_item)
{
	$params = $menu_item->getParams();

	if($params->get('helixultimate_enable_page_title', 0) || $is_builder)
	{
		$header_wrap[] = 'tm-header-transparent tm-header-overlay';

		if ( $sticky ) {
			$attrs_sticky[] = 'cls-inactive: uk-navbar-transparent' . $transparent_header_extra;
			if ( '1' === $sticky ) {
				$attrs_sticky[] = 'animation: uk-animation-slide-top';
			}
		} else {
			$navbar_container[] = 'uk-navbar-transparent' . $transparent_header_extra;
		}

	}
}

$header_container = $data->params->get('header_maxwidth', 'default');

// Width Container
$header_container_cls[] = '';

$header_container_cls[] = $header_container != 'default' ? 'uk-container uk-container-' . $header_container : 'container';

$remove_logo_padding = $data->params->get('remove_logo_padding', '0');
$header_container_cls[] = $header_container == 'expand' && $remove_logo_padding ? 'uk-padding-remove-left' : '';
$social_pos = $data->params->get('social_pos');
$contact_pos = $data->params->get('contact_pos');
$header_wrap   = implode( ' ', array_filter( $header_wrap ) );
$attrs_sticky = ' uk-sticky="' . implode( '; ', array_filter( $attrs_sticky ) ) . '"';
$header_container_cls   = implode( ' ', array_filter( $header_container_cls ) );
$navbar_container   = implode( ' ', array_filter( $navbar_container ) );

$header_pos = $doc->countModules('header') || $navbar_search === 'header' || $social_pos === 'header' || $contact_pos === 'header' ;
$navbar_pos = $doc->countModules('navbar') || $navbar_search === 'navbar' || $social_pos === 'navbar' || $contact_pos === 'navbar' ;

/**
 * Helper classes for-
 * social icons, contact info, site logo, Menu header, toolbar, cookie, search.
 */

$contact = new HelixUltimateFeatureContact( $data->params );
$cookie  = new HelixUltimateFeatureCookie( $data->params );
$logo    = new HelixUltimateFeatureLogo( $data->params );
$menu    = new HelixUltimateFeatureMenu( $data->params );
$mobile    = new HelixUltimateFeatureMobile( $data->params );
$search  = new HelixUltimateFeatureSearch( $data->params );
$social  = new HelixUltimateFeatureSocial( $data->params );
$toolbar  = new HelixUltimateFeatureToolbar( $data->params );

$isheaderMenu = $data->params->get('header_enable_menu', 0);

$class_sfx  = $subnav_cls ='';
$menu_style_cls = $data->params->get('header_menu_options') ? 'primary' : 'default';

$menuStyle = $data->params->get('header_menu_style', 'navbar', 'STRING');
$subnav_cls .= $data->params->get('hd_subnav_divider') ? ' uk-subnav-divider' : '';
$subnav_cls .= $data->params->get('hd_subnav_pill') ? ' uk-subnav-pill' : '';

$class_sfx = $menuStyle == 'subnav' ? ' uk-subnav'.$subnav_cls : '';

$menuType = $data->params->get('header_menu', 'mainmenu', 'STRING');
$maxLevel = $data->params->get('hd_menu_max_level', 0, 'INT');

$headerMenuModule = Helper::createModule('mod_menu', [
	'title' => 'Main Menu',
	'params' => '{"menutype":"' . $menuType . '","base":"","startLevel":"1","endLevel":"' . $maxLevel . '","showAllChildren":"1","tag_id":"","class_sfx":"'.$class_sfx.'","window_open":"","layout":"_:'.$menuStyle.'","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}',
	'name' => 'menu'
]);
// Uikit Navbar style
$hasModMenu = array_search('mod_menu', array_column(ModuleHelper::getModules('menu'), 'module'));
$navbarMenuType = $data->params->get('navbar_menu', 'mainmenu', 'STRING');
$nav_cls = $data->params->get('nav_style') ? $data->params->get('nav_style') : 'navbar';
$navbarMenuModule = Helper::createModule('mod_menu', [
	'title' => 'Main Menu',
	'params' => '{"menutype":"' . $navbarMenuType . '","base":"","startLevel":1,"endLevel":0,"showAllChildren":1,"tag_id":"","class_sfx":"","window_open":"","layout":"_:'.$nav_cls.'","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}',
	'name' => 'menu'
]);

?>

<?php echo $cookie->renderFeature(); ?>

<?php if ( ! empty($toolbar_visibility) ) : ?>
	<?php echo $mobile->renderFeature(); ?>
<?php endif; ?>

<?php if ( ! $data->params->get('toolbar_transparent') ) : ?>
  <?php echo $toolbar->renderFeature(); ?>
<?php endif; ?>

<?php if ( empty($toolbar_visibility) ) : ?>
	<?php echo $mobile->renderFeature(); ?>
<?php endif; ?>

<div class="<?php echo $header_wrap; ?>" uk-header>

<?php if ( $data->params->get('toolbar_transparent') ) : ?>
  <?php echo $toolbar->renderFeature(); ?>
<?php endif; ?>

<?php if ( $sticky ) : ?>
	<div<?php echo $attrs_sticky; ?>>
<?php endif; ?>

<div class="<?php echo $navbar_container; ?>">

<div class="<?php echo $header_container_cls; ?>">

<nav class="uk-navbar" uk-navbar>

<div class="uk-navbar-left">

	<?php echo $logo->renderFeature(); ?>
	<?php if ( $doc->countModules('logo') ) : ?>
		<jdoc:include type="modules" name="logo" style="warp_xhtml" />
	<?php endif; ?>

	<?php if (empty($header_alignment)) : ?>
		<?php if ( ! $data->params->get('navbar_menu_style') ) : ?>
			<?php echo $menu->renderFeature(); ?>
		<?php else: ?>
			<?php if ($hasModMenu === false): ?>
				<?php echo ModuleHelper::renderModule($navbarMenuModule, ['style' => 'navbar_xhtml']); ?>
			<?php else: ?>
				<jdoc:include type="modules" name="menu" style="navbar_xhtml" />
			<?php endif ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( empty($header_alignment) && $navbar_pos ) : ?>

	<?php if ( $doc->countModules( 'navbar' ) ) : ?>
		<jdoc:include type="modules" name="navbar" style="warp_xhtml" />
	<?php endif; ?>

	<?php if ( $navbar_search === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $search->renderFeature(); ?>
		</div>
	<?php endif; ?>

	<?php if ( $social_pos === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $social->renderFeature(); ?>
		</div>
	<?php endif; ?>

	<?php if ( $contact_pos === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $contact->renderFeature(); ?>
		</div>
	<?php endif; ?>

	<?php endif; ?>

</div>

<?php if ( $header_alignment == 'center' ) : ?>

	<div class="uk-navbar-center">

		<?php if ( ! $data->params->get('navbar_menu_style') ) : ?>
			<?php echo $menu->renderFeature(); ?>
		<?php else: ?>
			<?php if ($hasModMenu === false): ?>
				<?php echo ModuleHelper::renderModule($navbarMenuModule, ['style' => 'navbar_xhtml']); ?>
			<?php else: ?>
				<jdoc:include type="modules" name="menu" style="navbar_xhtml" />
			<?php endif ?>
		<?php endif; ?>

		<?php if ( $doc->countModules( 'navbar' ) ) : ?>
			<jdoc:include type="modules" name="navbar" style="warp_xhtml" />
		<?php endif; ?>

		<?php if ( $navbar_search === 'navbar' ) : ?>
			<div class="uk-navbar-item">
				<?php echo $search->renderFeature(); ?>
			</div>
		<?php endif; ?>

		<?php if ( $social_pos === 'navbar' ) : ?>
			<div class="uk-navbar-item">
				<?php echo $social->renderFeature(); ?>
			</div>
		<?php endif; ?>

		<?php if ( $contact_pos === 'navbar' ) : ?>
			<div class="uk-navbar-item">
				<?php echo $contact->renderFeature(); ?>
			</div>
		<?php endif; ?>

	</div>

<?php endif; ?>

<?php if ( $header_pos || $header_alignment == 'right' ) : ?>

<div class="uk-navbar-right">

<?php if ($header_alignment == 'right') : ?>
	<?php if ( ! $data->params->get('navbar_menu_style') ) : ?>
	<?php echo $menu->renderFeature(); ?>
	<?php else: ?>
		<?php if ($hasModMenu === false): ?>
			<?php echo ModuleHelper::renderModule($navbarMenuModule, ['style' => 'navbar_xhtml']); ?>
		<?php else: ?>
			<jdoc:include type="modules" name="menu" style="navbar_xhtml" />
		<?php endif ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ($header_alignment == 'right' && $navbar_pos ) : ?>

	<?php if ( $doc->countModules( 'navbar' ) ) : ?>
		<jdoc:include type="modules" name="navbar" style="warp_xhtml" />
	<?php endif; ?>

	<?php if ( $navbar_search === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $search->renderFeature(); ?>
		</div>
	<?php endif; ?>

	<?php if ( $social_pos === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $social->renderFeature(); ?>
		</div>
	<?php endif; ?>

	<?php if ( $contact_pos === 'navbar' ) : ?>
		<div class="uk-navbar-item">
			<?php echo $contact->renderFeature(); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>

<?php if ($isheaderMenu) : ?>
	<?php if ($menuStyle != 'navbar'): ?>
		<div class="uk-navbar-item">
	<?php endif; ?>
		<?php echo ModuleHelper::renderModule($headerMenuModule); ?>
	<?php if ($menuStyle != 'navbar'): ?>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php if ( $doc->countModules( 'header' ) ) : ?>
	<jdoc:include type="modules" name="header" style="warp_xhtml" />
<?php endif; ?>

<?php if ( $navbar_search === 'header' ) : ?>
	<div class="uk-navbar-item">
		<?php echo $search->renderFeature(); ?>
	</div>
<?php endif; ?>

<?php if ( $social_pos === 'header' ) : ?>
	<div class="uk-navbar-item">
		<?php echo $social->renderFeature(); ?>
	</div>
<?php endif; ?>

<?php if ( $contact_pos === 'header' ) : ?>
	<div class="uk-navbar-item">
		<?php echo $contact->renderFeature(); ?>
	</div>
<?php endif; ?>

</div>

<?php endif; ?>

</nav>
</div>

</div>

<?php if ( $sticky ) : ?>
</div>
<?php endif; ?>

</div>