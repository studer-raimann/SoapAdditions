<?php namespace srag\Plugins\SoapAdditions;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Routes\RBAC\BlockRoleRoute;
use srag\Plugins\SoapAdditions\Parameter\PossibleValue;
use srag\Plugins\SoapAdditions\Routes\User\UpdateUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\User\GetUserSettingsRoute;
use srag\Plugins\SoapAdditions\Routes\Favourites\AddToFavouritesRoute;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Parameter\Parameter;

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

        require_once "$basedir/Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/classes/class.ilSoapAdditionsPlugin.php";

        try {
            $soap_methods = [
                new BlockRoleRoute(),
                new \srag\Plugins\SoapAdditions\Routes\Course\UpdateCourseSettingsRoute(),
                new UpdateUserSettingsRoute(),
                new GetUserSettingsRoute(),
                new AddToFavouritesRoute(),
            ];
        } catch (\Throwable $t) {
            echo '<pre>' . print_r($t->getMessage() . '  ' . $t->getFile() . ':' . $t->getLine(), true) . '</pre>';
            $soap_methods = [];
        }

        $docu = "";

        foreach ($soap_methods as $method) {
            if ($method instanceof Base) {
                $docu .= "### Route: " . $method->getName() . "\n";
                $docu .= "" . $method->getShortDocumentation() . "\n";
                $docu .= "Parameters:\n";
                foreach ($method->getAdditionalInputParams() as $p) {
                    $docu .= self::paramToString($p);
                }
                if ($method->getSampleRequest()) {
                    $docu .= "```xml\n";
                    $docu .= $method->getSampleRequest();
                    $docu .= "\n```";
                    $docu .= "\n";
                }
                $docu .= "\n";
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

    private static function paramToString(Parameter $p, int $level = 1) : string
    {
        $docu = str_repeat("\t", $level - 1);
        $docu .= "* {$p->getKey()} ({$p->getType()}";
        if ($p->isOptional()) {
            $docu .= ", optional";
        }
        $docu .= ")";
        if ($p->getDescription()) {
            $docu .= ": " . $p->getDescription();
        }
        if ($p instanceof ComplexParameter) {
            foreach ($p->getSubParameters() as $subParameter) {
                $docu .= self::paramToString($subParameter, $level + 1);
            }
        }

        $possible_values = $p->getPossibleValues();

        $possible_values_description = array_map(static function (PossibleValue $value) {
            /** @noinspection ForgottenDebugOutputInspection */
            return var_export($value->getValue(), true) . ": {$value->getDescription()}";
        }, $possible_values);

        $implode = implode(", ", $possible_values_description);
        $docu .= $implode !== '' ? " " . $implode : '';
        $docu .= "\n";

        return $docu;
    }
}
