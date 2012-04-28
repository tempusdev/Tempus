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

use Silex\Application as SilexApplication;

class App
{
    private $env;
    private $debug;
    private $app;

    /**
     * Constructor
     * 
     * @param string $env
     * @param bool $debug
     */
    public function __construct($env, $debug)
    {
        $this->env = $env;
        $this->debug = $debug;
        $this->app = new SilexApplication;

        $this->configure();
        $this->mountControllerProviders();
    }

    public function run()
    {
        $this->app->run();
    }

    protected function configure()
    {
        $app = $this->app;

        $app['env'] = $this->env;
        $app['debug'] = $this->debug;

        $projectRoot = __DIR__.'/../../..';

        if ( $app['debug'] ) {
            $app->register(new \Silex\Provider\MonologServiceProvider(), array(
                'monolog.logfile' => $projectRoot.'/logs/'.$this->env.'.log',
            ));
        }

        $app->register(new \Silex\Provider\SymfonyBridgesServiceProvider());
        $app->register(new \Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => $projectRoot.'/views',
            'twig.options' => array('cache' => false,),
        ));

        $app->register(new \Silex\Provider\SessionServiceProvider());
    }

    protected function mountControllerProviders()
    {
        $this->app->mount('/', new AppControllerProvider);
        $this->app->mount('/api', new ApiControllerProvider);
        $this->app->mount('/admin', new AdminControllerProvider);
    }
}
