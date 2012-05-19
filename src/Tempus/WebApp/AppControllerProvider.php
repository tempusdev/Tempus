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

use Symfony\Component\HttpFoundation\Request;

class AppControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $origApp)
    {
        $app = new SilexAppWrapper($origApp);

        $controllers = new ControllerCollection();

        /**
         * DASHBOARD
         */
        $controllers->get('/', function() use ($app) {
            return $app->render('app/dashboard/dashboard.html.twig');
        });



        /**
         * PROJECTS
         */
        $controllers->get('/projects', function() use ($app) {
            $projects = $app->projectRepository()->findAll();

            return $app->render('app/project/projects.html.twig', array('projects' => $projects));
        })->bind('projects');


        $controllers->get('/projects/new', function() use ($app) {
            //$project = $app->projectRepository()->find($projectId);

            return $app->render('app/project/project_new.html.twig');

        })->bind('project_new');

        $controllers->post('/projects/save', function(Request $request) use ($app) {

            $project = new Project($request->get('name'));

            echo "win"; exit;

            $app->doctrine()->persist($project);
            $app->doctrine()->flush();

            return $app->render('app/project/project_new.html.twig');

        })->bind('project_save');


        $controllers->get('/project/{projectId}', function($projectId) use ($app) {
            $project = $app->projectRepository()->find($projectId);

            return $app->render('app/project/project.html.twig', array('project' => $project));
        })->bind('project');

        




        /**
         * ACTIVITY
         */
        $controllers->get('/activity/{activityId}', function($activityId) use ($app) {
            $activity = $app->activityRepository()->find($activityId);

            return $activity->name();
        });
   

        /**
         * USER
         */ 
        $controllers->get('/users', function() use ($app) {
            $users = $app->userRepository()->findAll();

            return $users;
        });

        $controllers->get('/user/{username}', function($username) use ($app) {

            $user = $app->userRepository()->findOneByUsername($username);

            return $app->render('app/user/user.html.twig', array('user' => $user));
        })->bind('user');

        $controllers->get('/user/{username}/edit', function($username) use ($app) {
            $user = $app->userRepository()->findOneByUsername($username);

            return $app->render('app/user/user_edit.html.twig', array('user' => $user));

        })->bind('user_edit');


        $controllers->post('/user/{username}/save', function(Request $request, $username) use ($app) {
            $user = $app->userRepository()->findOneByUsername($username);

            $user->setUsername($request->get('username'));
            $user->setPassword($request->get('password'));

            $app->doctrine()->flush();

            return $app->render('app/user/user.html.twig', array('user' => $user));

        })->bind('user_save');

        return $controllers;
    }
}
