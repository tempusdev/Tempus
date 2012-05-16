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

class AppControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $origApp)
    {
        $app = new SilexAppWrapper($origApp);

        $controllers = new ControllerCollection();

        $controllers->get('/', function() use ($app) {
            return $app->render('app/home.html.twig');
        });

        $controllers->get('/project/{projectId}', function($projectId) use ($app) {
            $project = $app->projectRepository()->find($projectId);

            return $app->render('app/project.html.twig', array('project' => $project));
        });

        $controllers->get('/activity/{activityId}', function($activityId) use ($app) {
            $activity = $app->activityRepository()->find($activityId);

            return $activity->name();
        });
    
        $controllers->get('/users', function() use ($app) {
            $users = $app->userRepository()->findAll();

            return $users;
        });

        $controllers->get('/user/{userId}', function($userId) use ($app) {
            $user = $app->userRepository()->find($userId);

            return $app->render('app/user.html.twig', array('user' => $user));
        });

         $controllers->get('/user/{userId}/edit', function($userId) use ($app) {
            $user = $app->userRepository()->find($userId);

            return $app->render('app/userEdit.html.twig', array('user' => $user));
        });

        return $controllers;
    }
}
