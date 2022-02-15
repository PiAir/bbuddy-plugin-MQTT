<?php 
/**
 * Barcode Buddy for Grocy MQTT Plugin
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU General
 * Public License v3.0 that is attached to this project.
 *
 * 
 * MQTT Plugin
 *
 * @author     Pierre Gorissen
 * @copyright  2022 Pierre Gorissen
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 * @since      Plugin available since Release v1.8.1.4 of Barcode Buddy
 */

require_once __DIR__ . "/composer/vendor/autoload.php";
require_once __DIR__ . "/composer/vendor/php-mqtt/client/src/MQTTClient.php";
require_once __DIR__ . "/config.php";

use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;


const EVENT_TYPE_PLUGIN               = -2;
const EVENT_TYPES   = array(
        "-1" => "ERROR",
        "0" => "MODE_CHANGE",
        "1" => "CONSUME",
        "2" => "CONSUME_S",
        "3" => "PURCHASE", 
        "4" => "OPEN", 
        "5" => "INVENTORY",
        "6" => "EXEC_CHORE",
        "7" => "ADD_KNOWN_BARCODE",
        "8" => "ADD_NEW_BARCODE",
        "9" => "ADD_UNKNOWN_BARCODE",
        "10" => "CONSUME_PRODUCT", 
        "11" => "CONSUME_S_PRODUCT",
        "12" => "PURCHASE_PRODUCT",
        "13" => "OPEN_PRODUCT",
        "14" => "GET_STOCK_PRODUCT",
        "15" => "ADD_TO_SHOPPINGLIST",
        "16" => "ASSOCIATE_PRODUCT",
        "17" => "ACTION_REQUIRED", 
        "18" => "CONSUME_ALL_PRODUCT",
        "19" => "NO_STOCK"
    );

class LogNoPluginOutput extends LogOutput {

    /**
     *
     * If we use the regular createLog() function, it will create a loop 
     *
     * @return string
     * @throws DbConnectionDuringEstablishException
     */
    public function createLog(): string {
        global $LOADED_PLUGINS;

        if ($this->isError) {
            $this->websocketText = str_replace("</span>", "", $this->websocketText);
            $this->websocketText = preg_replace("/<span .*?>+/", "- WARNING: ", $this->websocketText);
        }
        $logText = str_replace('\n', " ", $this->logText);
        DatabaseConnection::getInstance()->saveLog($logText, $this->isVerbose, $this->isError);
        if ($this->sendWebsocketMessage) {
            SocketConnection::sendWebsocketMessage($this->websocketResultCode, $this->websocketText);
        }
        return $this->logText;
    }
}

function bbuddy_mqtt_sendMQTT($eventType, $log): void {

    try {
        // Create a new instance of an MQTT client and configure it to use the shared broker host and port.
        $client = new MqttClient(MQTT_BROKER_HOST, MQTT_BROKER_PORT, 'barcode-buddy');
        
        // Connect to the broker with the configured connection settings and with a clean session.
        $client->connect(AUTHORIZATION_USERNAME, AUTHORIZATION_PASSWORD, null, true);        

        $payload = array(   'log' => $log,
                            'eventtype' => $eventType, 
                            'eventtype_text' => EVENT_TYPES[$eventType]);

        $json_payload = json_encode($payload);

        // Publish the log message on the topic 'barcode-buddy/'+ using QoS 0.
        $client->publish('barcode-buddy/log', $json_payload, MqttClient::QOS_AT_MOST_ONCE);

        // Gracefully terminate the connection to the broker.
        // $client->disconnect();
    } catch (MqttClientException $e) {
        // MqttClientException is the base exception of all exceptions in the library. Catching it will catch all MQTT related exceptions.
        $log = new LogNoPluginOutput('Publishing a message using QoS 0 failed. An exception occurred!', EVENT_TYPE_PLUGIN);
        $log->setVerbose()->dontSendWebsocket()->createLog();
    }
}
