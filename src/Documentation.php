<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

/** @noinspection PhpUndefinedNamespaceInspection */

namespace srag\Plugins\SoapAdditions;

use Composer\Script\Event;
use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Parameter\PossibleValue;
use srag\Plugins\SoapAdditions\Parameter\ComplexParameter;
use srag\Plugins\SoapAdditions\Parameter\Parameter;

/**
 * Class Documentation
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Documentation
{
    /**
     * @return array
     */
    protected static function getSoapRoutes(): array
    {
        return include 'routes.php';
    }

    public static function postAutoloadDump(Event $event): void
    {
        $soap_routes = self::getSoapRoutes();
        $docu = implode("\n\n", array_map(self::routeToString(), $soap_routes));

        self::saveFile($docu);
    }

    protected static function paramsToString(array $ps, int $level = 1): string
    {
        return implode("\n", array_map(self::paramToString($level), $ps));
    }

    /**
     * @param int $level
     * @return \Closure
     */
    protected static function paramToString(int $level = 1): \Closure
    {
        return static function (Parameter $p) use ($level): string {
            $docu = str_repeat("\t", $level - 1);
            $docu .= "* {$p->getKey()} ({$p->getType()}";
            if ($p->isOptional()) {
                $docu .= ", optional";
            }
            $docu .= ")";
            if ($p->getDescription() !== '' && $p->getDescription() !== '0') {
                $docu .= ": " . $p->getDescription();
            }
            if ($p instanceof ComplexParameter) {
                $docu .= "\n";
                $docu .= self::paramsToString($p->getSubParameters(), $level + 1);
            }

            $implode = implode(", ", array_map(self::possibleValueToString(), $p->getPossibleValues()));

            return $docu . ($implode !== '' ? " " . $implode : '');
        };
    }

    /**
     * @return \Closure
     */
    protected static function routeToString(): \Closure
    {
        return static function (Base $r): string {
            $docu = "### Route: " . $r->getName() . "\n";
            $docu .= "" . $r->getShortDocumentation() . "\n";
            $docu .= "Parameters:\n";
            $docu .= self::paramsToString($r->getAdditionalInputParams());

            if ($r->getSampleRequest() !== '' && $r->getSampleRequest() !== '0') {
                $docu .= "\n\n```xml\n";
                $docu .= $r->getSampleRequest();
                $docu .= "\n```";
                $docu .= "\n";
            }

            return $docu;
        };
    }

    private static function possibleValueToString(): \Closure
    {
        return static fn(PossibleValue $value): string =>
            /** @noinspection ForgottenDebugOutputInspection */
            var_export($value->getValue(), true) . ": {$value->getDescription()}";
    }

    /**
     * @param string $docu
     */
    protected static function saveFile(string $docu)
    {
        self::initBaseDir();
        $readme_file = "./Customizing/global/plugins/Services/WebServices/SoapHook/SoapAdditions/README.md";
        $content = file_get_contents($readme_file);

        $begin = "<!-- BEGIN definitions -->";
        $end = "<!-- END definitions -->";

        $re = '/(' . $begin . ')(.*)(' . $end . ')/ms';
        $subst = "\${1}\n$docu \n\${3}";

        $result = preg_replace($re, $subst, $content);

        file_put_contents($readme_file, $result);
    }

    protected static function initBaseDir()
    {
        static $init;
        if (!isset($init)) {
            $cwd = getcwd();
            $basedir = strstr($cwd, "Customizing", true);
            chdir($basedir);
            $init = true;
        }
    }

}
