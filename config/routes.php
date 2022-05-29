<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Http\Middleware\CsrfProtectionMiddleware;

return static function (RouteBuilder $routes) {

    $routes->setRouteClass(DashedRoute::class);

    require_once('user_route.php');

    /*
    * Router Admin
    */
    $routes->prefix('admin', function (RouteBuilder $routes) {
        // $routes->applyMiddleware('csrf');

        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index'], ['_name' => 'admin_dashboard']);
        $routes->connect('/admin/ajaxGraph', ['controller' => 'Dashboard', 'action' => 'ajaxGraph'], ['_name' => 'admin_graph']);

        //User route
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'admin_logout']);
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index'], ['_name' => 'admin_user_index']);
        $routes->connect('/users/add', ['controller' => 'Users', 'action' => 'add'], ['_name' => 'admin_user_add']);
        $routes->connect('/users/edit/{id}', ['controller' => 'Users', 'action' => 'edit'], ['_name' => 'admin_user_edit']);
        $routes->connect('/users/delete/{id}', ['controller' => 'Users', 'action' => 'delete'], ['_name' => 'admin_users_delete']);
        $routes->connect('/users/search', ['controller' => 'Users', 'action' => 'search'], ['_name' => 'admin_users_search']);

        //Category route
        $routes->connect('/categories/create', ['controller' => 'Categories', 'action' => 'add'], ['_name' => 'admin_categories_add']);
        $routes->connect('/categories/home', ['controller' => 'Categories', 'action' => 'index'], ['_name' => 'admin_categories_index']);
        $routes->connect('/categories/{slug}/edit', ['controller' => 'Categories', 'action' => 'edit'], ['_name' => 'admin_categories_edit']);
        $routes->connect('/categories/delete/{id}', ['controller' => 'Categories', 'action' => 'delete'], ['_name' => 'admin_categories_delete']);
        $routes->connect('/categories/search', ['controller' => 'Categories', 'action' => 'search'], ['_name' => 'admin_categories_search']);
        $routes->connect('/categories/change-number', ['controller' => 'Categories', 'action' => 'changeNumberCategory'], ['_name' => 'admin_change_number_category']);

        //Genre route
        $routes->connect('/genres/home', ['controller' => 'Genres', 'action' => 'index'], ['_name' => 'admin_genre_home']);
        $routes->connect('/genres/create', ['controller' => 'Genres', 'action' => 'add'], ['_name' => 'admin_genre_create']);
        $routes->connect('/genres/{slug}/edit', ['controller' => 'Genres', 'action' => 'edit'], ['_name' => 'admin_genre_edit']);
        $routes->connect('/genres/delete/{id}', ['controller' => 'Genres', 'action' => 'delete'], ['_name' => 'admin_genre_delete']);
        $routes->connect('/genres/search', ['controller' => 'Genres', 'action' => 'search'], ['_name' => 'admin_genre_search']);

        //Country route
        $routes->connect('/countries/home', ['controller' => 'Countries', 'action' => 'index'], ['_name' => 'admin_countries_home']);
        $routes->connect('/countries/create', ['controller' => 'Countries', 'action' => 'add'], ['_name' => 'admin_countries_add']);
        $routes->connect('/countries/{slug}/edit', ['controller' => 'Countries', 'action' => 'edit'], ['_name' => 'admin_countries_edit']);
        $routes->connect('/countries/delete/{id}', ['controller' => 'Countries', 'action' => 'delete'], ['_name' => 'admin_countries_delete']);
        $routes->connect('/countries/search', ['controller' => 'Countries', 'action' => 'view'], ['_name' => 'admin_countries_search']);

        //movies
        $routes->connect('/movies/home', ['controller' => 'Movies', 'action' => 'index'], ['_name' => 'admin_movies_home']);
        $routes->connect('/movies/create', ['controller' => 'Movies', 'action' => 'add'], ['_name' => 'admin_movies_add']);
        $routes->connect('/movies/{slug}/edit', ['controller' => 'Movies', 'action' => 'edit'], ['_name' => 'admin_movies_edit']);
        $routes->connect('/movies/delete/{id}', ['controller' => 'Movies', 'action' => 'delete'], ['_name' => 'admin_movies_delete']);
        $routes->connect('/movies/search', ['controller' => 'Movies', 'action' => 'view'], ['_name' => 'admin_movies_search']);

        //Episodes
        $routes->connect('/episode/home', ['controller' => 'Episodes', 'action' => 'index'], ['_name' => 'admin_episodes_home']);
        $routes->connect('/episode/create', ['controller' => 'Episodes', 'action' => 'add'], ['_name' => 'admin_episodes_create']);
        $routes->connect('/ajaxEpisode', ['controller' => 'Episodes', 'action' => 'ajaxEpisode'], ['_name' => 'admin_episodes_total']);
        $routes->connect('/episode/edit/{id}', ['controller' => 'Episodes', 'action' => 'edit'], ['_name' => 'admin_episodes_edit']);
        $routes->connect('/episode/delete/{id}', ['controller' => 'Episodes', 'action' => 'delete'], ['_name' => 'admin_episodes_delete']);
        $routes->connect('/episode/search', ['controller' => 'Episodes', 'action' => 'search'], ['_name' => 'admin_episodes_search']);

        //Comments
        $routes->connect('/comment/home', ['controller' => 'Comments', 'action' => 'index'], ['_name' => 'admin_comment_home']);
        $routes->connect('/comment/delete/{id}', ['controller' => 'Comments', 'action' => 'delete'], ['_name' => 'admin_comment_delete']);
        $routes->connect('/comment/search', ['controller' => 'Comments', 'action' => 'search'], ['_name' => 'admin_comment_search']);
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */

    $routes->scope('/', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);
        $routes->resources('Api', function (RouteBuilder $routes) {
            $routes->resources('Movies', ['prefix' => 'Api']);
        });
    });
};
