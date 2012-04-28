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