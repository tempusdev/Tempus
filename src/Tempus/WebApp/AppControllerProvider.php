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
        })->bind('dashboard');



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
            $project = new \Tempus\Entity\Project($request->get('name'));

            $app->doctrine()->persist($project);
            $app->doctrine()->flush();

            return $app->redirect('/tempus_dev.php/project/' . $project->id());

        })->bind('project_save');


        $controllers->post('/project/{projectId}/delete', function(Request $request) use ($app) {
            if( $request->get('delete')) {
                $project = $app->projectRepository()->find($request->get('projectId'));

                $app->doctrine()->remove($project);
                $app->doctrine()->flush();
            }

            return $app->redirect('/tempus_dev.php/projects');

        })->bind('project_delete');


        $controllers->get('/project/{projectId}', function($projectId) use ($app) {
            $project = $app->projectRepository()->find($projectId);

            echo "<Pre>";
            print_r($project);
            echo "Activities: ";
            print_r($project->getActivity()); exit;

            return $app->render('app/project/project.html.twig', array('project' => $project));
        })->bind('project');



        /**
         * ACTIVITY
         */
        $controllers->get('/activities', function() use ($app) {
            $activities = $app->activityRepository()->findAll();

            //echo "<pre>"; print_r($activities); exit;

            return $app->render('app/activity/activities.html.twig', array('activities' => $activities));

        })->bind('activities');

         $controllers->get('/activities/new', function() use ($app) {
            return $app->render('app/activity/activity_new.html.twig');

        })->bind('activity_new');

        $controllers->post('/activities/save', function(Request $request) use ($app) {
            $activity = new \Tempus\Entity\Activity($request->get('name'));

            $activity->setDescription($request->get('description'));

            $app->doctrine()->persist($activity);
            $app->doctrine()->flush();

            return $app->redirect('/tempus_dev.php/activities');

        })->bind('activity_save');

        $controllers->post('/activity/{activityId}/delete', function(Request $request) use ($app) {
            if( $request->get('delete')) {
                $activity = $app->activityRepository()->find($request->get('activityId'));

                $app->doctrine()->remove($activity);
                $app->doctrine()->flush();
            }

            return $app->redirect('/tempus_dev.php/activities');

        })->bind('activity_delete');

        $controllers->get('/activity/{activityId}', function($activityId) use ($app) {
            $activity = $app->activityRepository()->find($activityId);

            return $app->render('app/activity/activity.html.twig', array('activity' => $activity));
        })->bind('activity');



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
