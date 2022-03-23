<?php

use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRoleRoute;
use srag\Plugins\SoapAdditions\Routes\Course\UpdateCourseSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\Favourites\AddToFavouritesRoute;
use srag\Plugins\SoapAdditions\Routes\User\UpdateUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\User\GetUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\ItemGroup\AddToItemGroupRoute;

return [
    new BlockRoleRoute(),
    new UpdateCourseSettingsRoute(),
    new AddToFavouritesRoute(),
    new AddToItemGroupRoute(),
    new UpdateUserSettingsRoute(),
    new GetUserSettingsRoute(),
];
