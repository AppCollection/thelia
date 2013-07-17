<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*	    email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace Thelia\Core\Template\Smarty\Plugins;

use Thelia\Core\Template\Smarty\SmartyPluginDescriptor;
use Thelia\Core\Template\Smarty\SmartyPluginInterface;
use Thelia\Tools\URL;
use Thelia\Core\HttpFoundation\Request;

class UrlGenerator implements SmartyPluginInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

	/**
     * Process url generator function
     *
     * @param  array $params
     * @param  unknown $smarty
     * @return string no text is returned.
     */
    public function generateUrlFunction($params, &$smarty)
    {
    	// the path to process
   		$path =trim($params['path']);

   		return URL::absoluteUrl($path, $this->getArgsFromParam($params));
     }

     /**
      * Process view url generator function
      *
      * @param  array $params
      * @param  unknown $smarty
      * @return string no text is returned.
      */
     public function generateViewUrlFunction($params, &$smarty)
     {
     	// the path to process
     	$view = trim($params['view']);

     	return URL::viewUrl($view, $this->getArgsFromParam($params));
     }

     /**
      * Get URL parameters array from a comma separated list or arguments in the
      * parameters.
      *
      * @param array $params Smarty function params
      * @return array the parameters array (either emply, of valued)
      */
     private function getArgsFromParam($params) {

     	if (isset($params['args']))
     		return explode($params['args'], ',');

     	return array();
     }

     /**
      * Process view url generator function
      *
      * @param  array $params
      * @param  unknown $smarty
      * @return string no text is returned.
      */
     public function generateReturnToUrl($params, &$smarty)
     {
		return URL::absoluteUrl($this->request->getSession()->getReturnToUrl());
     }

    /**
     * Define the various smarty plugins hendled by this class
     *
     * @return an array of smarty plugin descriptors
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor('function', 'url', $this, 'generateUrlFunction'),
            new SmartyPluginDescriptor('function', 'viewurl', $this, 'generateViewUrlFunction'),
            new SmartyPluginDescriptor('function', 'return_to_url', $this, 'generateReturnToUrl')
        );
    }
}