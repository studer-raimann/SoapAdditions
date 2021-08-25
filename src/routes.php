<?php

use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRoleRoute;
use srag\Plugins\SoapAdditions\Routes\Course\UpdateCourseSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\Favourites\AddToFavouritesRoute;
use srag\Plugins\SoapAdditions\Routes\User\UpdateUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\User\GetUserSettingsRoute;

return [
    new BlockRoleRoute(),
    new UpdateCourseSettingsRoute(),
    new AddToFavouritesRoute(),
    new UpdateUserSettingsRoute(),
    new GetUserSettingsRoute(),
];
