<?php namespace srag\Plugins\SoapAdditions;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRole;

/**
 * Class Documentation
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Documentation
{
    public static function postAutoloadDump(Event $event)
    {
        $cwd = getcwd();
        $basedir = strstr($cwd, "Customizing", true);
        chdir($basedir);

        require_once "$basedir/libs/composer/vendor/autoload.php";
        require_once "$basedir/Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/classes/class.ilSoapAdditionsPlugin.php";

        $soap_methods = [
            new BlockRole()
        ];

        foreach ($soap_methods as $method) {
            if ($method instanceof Base) {
                foreach ($method->getInputParamsObjects() as $p) {
                    echo $p->getKey();
                }
            }
        }

        $readme_file = "./Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/README.md";
        $content = file_get_contents($readme_file);



        $re = '/<!-- BEGIN definitions -->(.*)<!-- END definitions -->/ms';
        $subst = 'here we go';

        $result = preg_replace($re, $subst, $content);



        file_put_contents($readme_file, $result);

    }
}
