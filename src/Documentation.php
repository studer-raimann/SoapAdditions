<?php namespace srag\Plugins\SoapAdditions;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRole;
use srag\Plugins\SoapAdditions\Parameter\PossibleValue;
use srag\Plugins\SoapAdditions\Routes\User\Settings;

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
        try {
            $soap_methods = [
                new BlockRole(),
                new \srag\Plugins\SoapAdditions\Routes\Course\Settings(),
                new Settings()
            ];
        } catch (\Throwable $t) {
            echo '<pre>' . print_r(array_map(function ($a) {
                    return $a["file"];
                }, $t->getTrace()), true) . '</pre>';
        }
        $docu = "";
        foreach ($soap_methods as $method) {
            if ($method instanceof Base) {
                $docu .= " ### Route: " . $method->getName() . "\n";
                $docu .= "" . $method->getShortDocumentation() . "\n";
                $docu .= "Parameters:\n";
                foreach ($method->getInputParamsObjects() as $p) {
                    $docu .= "- {$p->getKey()}";
                    $implode = implode(", ", array_map(function (PossibleValue $value) {
                        return $value->getDescription();
                    }, $p->getPossibleValues()));
                    $docu .= $implode === '' ? $implode : 'none';
                    $docu .= "\n";
                }
                $docu .= "\n\n";
            }
        }

        $readme_file = "./Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/README.md";
        $content = file_get_contents($readme_file);

        $begin = "<!-- BEGIN definitions -->";
        $end = "<!-- END definitions -->";

        $re = '/(' . $begin . ')(.*)(' . $end . ')/ms';
        $subst = "\${1}\n$docu \n\${3}";

        $result = preg_replace($re, $subst, $content);

        file_put_contents($readme_file, $result);

    }
}
