<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
 
 

//Router::connect('/copydb', ['controller' => 'Copydb']);
	
Router::connect('/ajax', ['controller' => 'Ajax']);

Router::connect('/', ['controller' => 'Home', 'action' => 'home']);


Router::connect('/:lang/', ['controller' => 'Home', 'action' => 'home'], ['pass' => ['lang']]);
	
Router::connect('/:lang/contacts', ['controller' => 'Contacts', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/cart', ['controller' => 'Cart', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/search', ['controller' => 'Search', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/company', ['controller' => 'AboutUs', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/company/about-us', ['controller' => 'AboutUs', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/company/about-us/*', ['controller' => 'AboutUs', 'action' => 'designer'], ['pass' => ['lang']]);

Router::connect('/:lang/company/:item/*', ['controller' => 'AboutUs', 'action' => 'article'], ['pass' => ['item']], ['pass' => ['lang']]);

Router::connect('/:lang/catalog/product/*', ['controller' => 'Catalog', 'action' => 'product'], ['pass' => ['lang']]);


Router::connect('/:lang/catalog/', ['controller' => 'Catalog', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/catalog/:item/*', ['controller' => 'Catalog', 'action' => 'index'], ['pass' => ['item']], ['pass' => ['lang']]);



Router::connect('/:lang/projects', ['controller' => 'Projects', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/projects/:item/*', ['controller' => 'Projects', 'action' => 'project'], ['pass' => ['item']], ['pass' => ['lang']]);

Router::connect('/:lang/fabriki', ['controller' => 'Factories', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/fabriki/:item/*', ['controller' => 'Factories', 'action' => 'factory'], ['pass' => ['item']], ['pass' => ['lang']]);

Router::connect('/:lang/news', ['controller' => 'News', 'action' => 'index'], ['pass' => ['lang']]);

Router::connect('/:lang/news/:item/', ['controller' => 'News', 'action' => 'category'], ['pass' => ['item']], ['pass' => ['lang']]);

Router::connect('/:lang/news/:item/*', ['controller' => 'News', 'action' => 'article'], ['pass' => ['item']], ['pass' => ['lang']]);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/:lang/pages/*', ['controller' => 'Pages', 'action' => 'display'], ['pass' => ['lang']]);
    $routes->fallbacks('DashedRoute');
	
});


Router::connect('/404/', ['controller' => 'Home', 'action' => 'error404']);

Router::connect('/rus/', ['controller' => 'Home', 'action' => 'home']);

Router::connect('/rus/*', ['controller' => 'Home', 'action' => 'home']);

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
