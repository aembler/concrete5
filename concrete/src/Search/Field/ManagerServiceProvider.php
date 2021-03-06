<?php
namespace Concrete\Core\Search\Field;

use Concrete\Core\Foundation\Service\Provider as ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['manager/search_field/file'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\File\Search\Field\Manager');

            return $manager;
        });
        $this->app['manager/search_field/page'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\Page\Search\Field\Manager');

            return $manager;
        });
        $this->app['manager/search_field/user'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\User\Search\Field\Manager');

            return $manager;
        });
        $this->app['manager/search_field/express'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\Express\Search\Field\Manager');
            return $manager;
        });
        $this->app['manager/search_field/calendar_event'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\Calendar\Event\Search\Field\Manager');

            return $manager;
        });
        $this->app['manager/search_field/logging'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\Logging\Search\Field\Manager');

            return $manager;
        });
        $this->app['manager/search_field/group'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\User\Group\Search\Field\Manager');

            return $manager;
        });
    }
}
