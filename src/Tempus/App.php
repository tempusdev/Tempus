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

namespace Tempus;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Tempus\Silex\ServiceProvider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application as SilexApplication;

class App
{
    protected $env;
    protected $debug;
    protected $app;

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
    }

    protected function configure()
    {
        $app = $this->app;

        $app['env'] = $this->env;
        $app['debug'] = $this->debug;

        $projectRoot = __DIR__.'/../..';

        if ( $app['debug'] ) {
            $app->register(new \Silex\Provider\MonologServiceProvider(), array(
                'monolog.logfile' => $projectRoot.'/logs/'.$this->env.'.log',
            ));
        }

        $app->register(new DoctrineOrmServiceProvider, array(
            'doctrine.dbal.connection_options' => array(
                'driver' => 'pdo_sqlite',
                'path' => $projectRoot.'/db/tempus.sqlite',
            ),
            'doctrine.orm' => true,
            'doctrine.orm.entities' => array(
                array(
                    'type' => 'annotation',
                    'path' => $projectRoot.'/src/Tempus/Entity',
                    'namespace' => 'Tempus\\Entity',
                ),
            ),
        ));

        /*
        AnnotationRegistry::registerLoader(function($class) use ($loader) {
            $loader->loadClass($class);
            return class_exists($class, false);
        });
        */

        AnnotationRegistry::registerFile($projectRoot.'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

        $app->register(new \Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => $projectRoot.'/views',
            'twig.options' => array('cache' => false,),
        ));

        $app->register(new \Silex\Provider\SessionServiceProvider());
    }
}
