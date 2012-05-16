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

class SilexAppWrapper
{
    /**
     * @var Application
     */
    private $wrapped;

    /**
     * Constructor
     * 
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->wrapped = $app;
    }

    /**
     * Wrapped application
     *
     * @return Application
     */
    public function wrapped()
    {
        return $this->wrapped;
    }

    /**
     * Get something from the wrapped Silex application
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->wrapped[$key];
    }

    /**
     * Get Doctrine entity manager
     */
    public function doctrine()
    {
        return $this->wrapped['doctrine.orm.em'];
    }

    /**
     * The Project Repository
     */
    public function projectRepository()
    {
        return $this->doctrine()->getRepository('Tempus\Entity\Project');
    }

    /**
     * The Activity Repository
     */
    public function activityRepository()
    {
        return $this->doctrine()->getRepository('Tempus\Entity\Activity');
    }

    /**
     * The User Repository
     */
    public function userRepository()
    {
        return $this->doctrine()->getRepository('Tempus\Entity\User');
    }


    /**
     * Render
     * 
     * @param string $template
     * @param array $context
     * @return string
     */
    public function render($template, array $context = array())
    {
        return $this->wrapped['twig']->render($template, $context);
    }
} 