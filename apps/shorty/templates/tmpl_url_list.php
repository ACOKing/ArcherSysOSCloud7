<?php
/**
* @package shorty an ownCloud url shortener plugin
* @category internet
* @author Christian Reiner
* @copyright 2011-2014 Christian Reiner <foss@christian-reiner.info>
* @license GNU Affero General Public license (AGPL)
* @link information http://apps.owncloud.com/content/show.php/Shorty?content=150401
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the license, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.
* If not, see <http://www.gnu.org/licenses/>.
*
*/
?>

<?php
/**
 * @file templates/tmpl_url_list.php
 * A table to visualize the list of existing shortys.
 * @access public
 * @author Christian Reiner
 */
?>

<!-- the 'hourglass', a general busy indicator -->
<div id="hourglass" class="shorty-hourglass" style="left:5em;top:6em;"><img src="<?php p(OCP\Util::imagePath('shorty', 'loading-disk.gif')); ?>"></div>

<!-- the list of urls, empty variant -->
<div id="vacuum" class="shorty-vacuum personalblock">
	<div class="factoid"><?php p(OC_Shorty_L10n::t("Nothing here yet")." !"); ?></div>
	<!-- a hint to use the personal preferences -->
	<p>
		<div class="suggestion"><?php p(OC_Shorty_L10n::t("If you just started using Shorty").":"); ?></div>
		<div class="explanation">
			<?php print_unescaped(sprintf(OC_Shorty_L10n::t("Set personal preferences using the cog wheel (%%s) on the upper right!" ),
				sprintf('<img id="controls-preferences" class="svg settings" style="vertical-align:bottom;cursor:pointer;" src="%s" />',
						OCP\Util::imagePath('core', 'actions/settings.svg'))
				)); ?>
		</div>
	</p>
	<!-- a hint explaining how to create content -->
	<p>
		<div class="suggestion"><?php p(OC_Shorty_L10n::t("Create a new 'Shorty' and share it").":"); ?></div>
		<div class="explanation"><?php p(OC_Shorty_L10n::t("Use the '%s' button above or the fine 'Shortlet'",OC_Shorty_L10n::t("New Shorty")).":"); ?></div>
	</p>
<?php require_once('tmpl_wdg_shortlet.php'); ?>
</div>

<!-- the list of urls, non-empty variant -->
<table id="list-of-shortys" class="shorty-list shorty-collapsible" style="display:none;">
	<thead>
		<tr id="list-of-shortys-titlebar" class="shorty-titlebar">
			<!-- a button to open/close the toolbar below -->
			<th id="list-of-shortys-favicon" data-id="favicon">
				<div>
					<img id="list-of-shortys-tools" class="shorty-tools" alt="toolbar" title="<?php p(OC_Shorty_L10n::t("Toggle toolbar")); ?>"
							 class="svg" src="<?php p(OCP\Util::imagePath('shorty','actions/unshade.svg')); ?>"
							 data-unshade="actions/unshade" data-shade="actions/shade">
				</div>
			</th>
			<th id="list-of-shortys-title"    data-id="title"    class="collapsible"><div><?php p(OC_Shorty_L10n::t('Title'));     ?></div></th>
			<th id="list-of-shortys-target"   data-id="target"   class="collapsible"><div><?php p(OC_Shorty_L10n::t('Target'));    ?></div></th>
			<th id="list-of-shortys-clicks"   data-id="clicks"   class="collapsible"><div><?php p(OC_Shorty_L10n::t('Clicks'));    ?></div></th>
			<th id="list-of-shortys-until"    data-id="until"    class="collapsible"><div><?php p(OC_Shorty_L10n::t('Expiration'));?></div></th>
			<th id="list-of-shortys-created"  data-id="created"  class="collapsible"><div><?php p(OC_Shorty_L10n::t('Creation'));  ?></div></th>
			<th id="list-of-shortys-accessed" data-id="accessed" class="collapsible"><div><?php p(OC_Shorty_L10n::t('Last'));      ?></div></th>
			<th id="list-of-shortys-status"   data-id="status"   class="collapsible"><div><?php p(OC_Shorty_L10n::t('Status'));    ?></div></th>
			<th id="list-of-shortys-actions"  data-id="actions"><div>&nbsp;</div></th>
		</tr>
		<!-- toolbar opened/closed by the button above -->
		<tr id="list-of-shortys-toolbar" data-id="favicon" class="shorty-toolbar">
			<th id="list-of-shortys-favicon">
				<div style="display:none;">
					<a id="list-of-shortys-reload" class="shorty-reload">
						<img alt="<?php p(OC_Shorty_L10n::t('reload')); ?>" title="<?php p(OC_Shorty_L10n::t('Reload list')); ?>"
							class="svg" src="<?php p(OCP\Util::imagePath('shorty','actions/reload.svg')); ?>">
					</a>
				</div>
			</th>
			<th id="list-of-shortys-title" data-id="title" class="collapsible">
				<div style="display:none;">
					<img id="sort-up" data-sort-code="ta" data-sort-type="string" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="td" data-sort-type="string" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
					<input id="filter-title" class="shorty-filter" type="text" value="">
					<img id="clear" alt="<?php p(OC_Shorty_L10n::t('clear')); ?>" title="<?php p(OC_Shorty_L10n::t('Clear filter')); ?>"
						class="shorty-clear svg" src="<?php p(OCP\Util::imagePath('shorty','actions/clear.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-target" data-id="target" class="collapsible">
				<div style="display:none;">
					<img id="sort-up" data-sort-code="ua" data-sort-type="string" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="ud" data-sort-type="string" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
					<input id="filter-target" class="shorty-filter" type="text" value="">
					<img id="clear" alt="<?php p(OC_Shorty_L10n::t('clear')); ?>" title="<?php p(OC_Shorty_L10n::t('Clear filter')); ?>"
						class="shorty-clear svg" src="<?php p(OCP\Util::imagePath('shorty','actions/clear.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-clicks" data-id="clicks" class="collapsible">
				<div style="display:none;">
					<img id="sort-up" data-sort-code="ha" data-sort-type="int" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="hd" data-sort-type="int" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-until" data-id="until" class="collapsible">
				<div style="display:none;">
					<img id="sort-up"  data-sort-code="da" data-sort-type="date" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="dd" data-sort-type="date" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-created" data-id="created" class="collapsible">
				<div style="display:none;">
					<img id="sort-up"  data-sort-code="ca" data-sort-type="date" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="cd" data-sort-type="date" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-accessed" data-id="accessed" class="collapsible">
				<div style="display:none;">
					<img id="sort-up"  data-sort-code="aa" data-sort-type="date" data-sort-direction='asc'
						alt="<?php p(OC_Shorty_L10n::t('up'));   ?>" title="<?php p(OC_Shorty_L10n::t('Sort ascending'));  ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/up.svg'));   ?>">
					<img id="sort-down" data-sort-code="ad" data-sort-type="date" data-sort-direction='desc'
						alt="<?php p(OC_Shorty_L10n::t('down')); ?>" title="<?php p(OC_Shorty_L10n::t('Sort descending')); ?>"
						class="shorty-sorter svg" src="<?php p(OCP\Util::imagePath('shorty','actions/down.svg')); ?>">
				</div>
			</th>
			<th id="list-of-shortys-status" data-id="status" class="collapsible">
				<div style="display:none;">
					<span class="shorty-select">
						<select id="filter-status" class="shorty-filter" value="" data-placeholder=" ">
						<?php foreach($_['shorty-status'] as $option=>$label)
							print_unescaped(sprintf("<option value=\"%s\">%s</option>\n",($option?$option:''),$label));
						?>
						</select>
					</span>
					<img id="clear" alt="<?php p(OC_Shorty_L10n::t('clear')); ?>" title="<?php p(OC_Shorty_L10n::t('Clear filter')); ?>"
						class="shorty-clear svg" src="<?php p(OCP\Util::imagePath('shorty','actions/clear.svg')); ?>">
				</div>
			</th>
		</tr>
		<!-- the 'dummy' row, a blueprint -->
		<tr class="shorty-dummy"
			data-id=""
			data-status=""
			data-source=""
			data-relay=""
			data-title=""
			data-favicon=""
			data-target=""
			data-clicks=""
			data-until=""
			data-created=""
			data-accessed=""
			data-created=""
			data-accessed=""
			data-notes="">
			<td id="list-of-shortys-favicon"  data-id="favicon"></td>
			<td id="list-of-shortys-title"    data-id="title"    class="collapsible"></td>
			<td id="list-of-shortys-target"   data-id="target"   class="collapsible"></td>
			<td id="list-of-shortys-clicks"   data-id="clicks"   class="collapsible"></td>
			<td id="list-of-shortys-until"    data-id="until"    class="collapsible"></td>
			<td id="list-of-shortys-created"  data-id="created"  class="collapsible"></td>
			<td id="list-of-shortys-accessed" data-id="accessed" class="collapsible"></td>
			<td id="list-of-shortys-status"   data-id="status"   class="collapsible"></td>
			<td id="list-of-shortys-actions"  data-id="actions">
				<span class="shorty-actions">
<!-- IF any additional actions are registered via hooks, additional icons will appear here -->
<?php foreach ( $_['shorty-actions']['list'] as $action ) { ?>
					<a id="<?php p($action['id']); ?>" title="<?php p(array_key_exists('title',$action)?$action['title']:''); ?>"
						data_method="<?php p($action['call']); ?>" class="">
						<img class="shorty-icon svg"
							alt="<?php p(array_key_exists('alt',$action)?$action['alt']:''); ?>"
							title="<?php p(array_key_exists('title',$action)?$action['title']:''); ?>"
							src="<?php p($action['icon']); ?>" />
					</a>
<?php } ?>
				<a id="shorty-action-show"   title="<?php p(OC_Shorty_L10n::t('show'));   ?>"   class="">
					<img alt="<?php p(OC_Shorty_L10n::t('show')); ?>"   title="<?php p(OC_Shorty_L10n::t('Show details')); ?>"
						class="shorty-icon svg" src="<?php p(OCP\Util::imagePath('shorty','actions/info.svg'));   ?>" />
				</a>
				<a id="shorty-action-edit"   title="<?php p(OC_Shorty_L10n::t('edit'));   ?>"   class="">
					<img alt="<?php p(OC_Shorty_L10n::t('modify')); ?>"   title="<?php p(OC_Shorty_L10n::t('Modify shorty')); ?>"
						class="shorty-icon svg" src="<?php p(OCP\Util::imagePath('core','actions/rename.svg')); ?>" />
				</a>
				<a id="shorty-action-del"    title="<?php p(OC_Shorty_L10n::t('delete')); ?>" class="">
					<img alt="<?php p(OC_Shorty_L10n::t('delete')); ?>" title="<?php p(OC_Shorty_L10n::t('Delete shorty')); ?>"
						class="shorty-icon svg" src="<?php p(OCP\Util::imagePath('core','actions/delete.svg')); ?>" />
				</a>
				<a id="shorty-action-share"  title="<?php p(OC_Shorty_L10n::t('share'));  ?>"   class="">
					<img alt="<?php p(OC_Shorty_L10n::t('share')); ?>"  title="<?php p(OC_Shorty_L10n::t('Share shorty')); ?>"
						class="shorty-icon svg" src="<?php p(OCP\Util::imagePath('core','actions/share.svg'));  ?>" />
				</a>
				<a id="shorty-action-open"   title="<?php p(OC_Shorty_L10n::t('open'));   ?>"   class="">
					<img alt="<?php p(OC_Shorty_L10n::t('open')); ?>"   title="<?php p(OC_Shorty_L10n::t('Open target')); ?>"
						class="shorty-icon svg" src="<?php p(OCP\Util::imagePath('shorty','actions/open.svg')); ?>" />
				</a>
				</span>
			</td>
		</tr>
	</thead>
	<!-- the standard body for non-empty lists -->
	<tbody>
	</tbody>
</table>
