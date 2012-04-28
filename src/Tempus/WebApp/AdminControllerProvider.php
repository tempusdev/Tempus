<?php

/*
 * This file is a part of tempus/tempus-webapp.
 * 
 * (c) Josh LaRosee
 *     Beau Simensen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tempus\WebApp;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $origApp)
    {
        $app = new SilexAppWrapper($origApp);

        $controllers = new ControllerCollection();

        $controllers->get('/', function() use ($app) {
            return $app->render('admin/home.html.twig');            
        })->bind('admin_home');

        return $controllers;
    }
}
