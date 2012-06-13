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

use Tempus\App;

use Silex\Provider\UrlGeneratorServiceProvider;


class WebApp extends App
{
    public function run()
    {
        $this->app->run();
    }

    protected function configure()
    {
        parent::configure();

        $app = $this->app;

        $app->mount('/', new AppControllerProvider);
        $app->mount('/api', new ApiControllerProvider);
        $app->mount('/admin', new AdminControllerProvider);

        $app->register(new UrlGeneratorServiceProvider());

    }
}
