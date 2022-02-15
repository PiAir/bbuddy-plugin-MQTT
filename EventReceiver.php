<?php
/**
 * Barcode Buddy for Grocy
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU General
 * Public License v3.0 that is attached to this project.
 *
 * @author     Marc Ole Bulling
 * @copyright  2019 Marc Ole Bulling
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 * @since      File available since Release 1.2
 */

 
require_once __DIR__ . "/bbuddy-mqtt/bbuddy-mqtt.inc.php";

/**
 * Example file for receiving events
 *
 * @author Marc Ole Bulling
 *
 * @copyright 2019 Marc Ole Bulling
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 *
 * @since File available since Release 1.2
 *
 * @return void
 */
function pluginEventReceiver_processEvent($eventType, $log): void {

    bbuddy_mqtt_sendMQTT($eventType, $log);
}


