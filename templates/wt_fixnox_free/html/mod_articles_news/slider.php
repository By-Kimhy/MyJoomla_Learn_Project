<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

if (!$list)
{
	return;
}

?>

<div class="uk-slider-container-offset uk-slider uk-slider-container" data-uk-slider="finite:true">

	<div class="uk-position-relative uk-visible-toggle">

		<ul class="uk-slider-items uk-grid uk-grid-match">
			<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
				<?php $item = $list[$i]; ?>
				<li class="el-item uk-width-1-1 uk-width-1-3@m">
					<?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item_slider'); ?>
				</li>
			<?php endfor; ?>
		</ul>

		<a class="uk-position-center-left uk-position-small uk-hidden-hover" href data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		<a class="uk-position-center-right uk-position-small uk-hidden-hover" href data-uk-slidenav-next data-uk-slider-item="next"></a>

	</div>

<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

</div>
 