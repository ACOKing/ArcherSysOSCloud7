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

/**
 * @file query.php
 * This is the plugins central query service
 * @access public
 * @author Christian Reiner
 */

// swallow any accidential output generated by php notices and stuff to preserve a clean JSON reply structure
OC_Shorty_Tools::ob_control ( TRUE );

// Session checks
OCP\App::checkAppEnabled ( 'shorty' );

$RUNTIME_NOSETUPFS = true;

try
{
	$p_id      = OC_Shorty_Type::req_argument ( 'id',     OC_Shorty_Type::ID,     FALSE );
	$p_query   = OC_Shorty_Type::req_argument ( 'query',  OC_Shorty_Type::STRING, FALSE );
	$p_format  = OC_Shorty_Type::req_argument ( 'format', OC_Shorty_Type::STRING, FALSE );
	$p_sort    = OC_Shorty_Type::req_argument ( 'sort',   OC_Shorty_Type::STRING, 'ka' );
	$param = array (
		':user'   => OCP\User::getUser ( ),
		':id'     => $p_id,
		':sort'   => OC_Shorty_Type::$SORTING[$p_sort],
		':format' => $p_format,
		':sort'   => $p_sort,
		':query'  => $p_query,
	);

	$match = NULL;
	$candidates = OC_Shorty_Hooks::requestQueries();
	foreach ($candidates['list'] as $candidate)
		if ($candidate['id']==$p_query)
			$match = $candidate;
	if ( ! $match )
		throw new OC_Shorty_Exception ( "Request for unknown query '%1'.", array($p_query) );

	// run query
	$query = OCP\DB::prepare ( $match['query'] );
	$result = $query->execute(array_intersect($param,$match['param']));
	$reply = $result->fetchAll();

	// swallow any accidential output generated by php notices and stuff to preserve a clean JSON reply structure
	OC_Shorty_Tools::ob_control ( FALSE );

	// output payload
	switch ( strtolower($p_format) ) {
		default:
			throw new OC_Shorty_Exception ( "Sorry, no payload format specified." );

			case 'json':
				// check availability of phps yaml extension ("syck")
				if ( ! extension_loaded('json') )
					throw new OC_Shorty_Exception ( "Sorry, support for payload format 'json' not installed." );
				// output payload
				print json_encode($reply);
			break;

			case 'yaml':
				// first option: php extension 'yaml'
				if ( extension_loaded('yaml') )
					print yaml_emit($reply);
				elseif ( function_exists('syck_dump') )
					syck_dump($reply);
				elseif (class_exists('Spyc'))
					Spyc::YAMLDump($reply);
				else
					// no implementation found, sorry...
					throw new OC_Shorty_Exception ( "Sorry, support for payload format 'yaml' not installed." );
			break;

			case 'csv':
				// apparently php _always_ offers csv support...
				// output payload
				$buffer = fopen('php://temp', 'r+');
				foreach ($reply as $entry) {
					fputcsv($buffer, $entry);
				} // foreach
				rewind($buffer);
				print fpassthru($buffer);
				fclose($buffer);
			break;

	} // switch format
	
	OCP\Util::writeLog( 'shorty', sprintf("Delivered response to remote call of query '%s'",$p_query), OCP\Util::DEBUG );

} catch ( OC_Shorty_Exception $e ) { header($e->getMessage()); }
?>
