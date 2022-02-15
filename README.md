# bbuddy-plugin-MQTT
 MQTT plugin for [barcodebuddy](https://github.com/Forceu/barcodebuddy) version 0.1 
 
 
## About

This plugin for barcodebuddy uses the EventReceiver.php to attach to all log-events produced by barcodebuddy.
Just enter the url and credentials for you MQTT-server in the config-file and you're set.


## Prerequisites

Webserver with barcodebuddy installed.
If you're using [Docker](https://github.com/Forceu/barcodebuddy-docker) then you'll have to make sure that the app/bbuddy/plugins folder inside the container is mapped to a folder on the filesystem, eg. using
```
docker run -d -v plugins:/app/bbuddy/plugins -v bbconfig:/config -p 80:80 -p 443:443 f0rc3/barcodebuddy-docker:latest
```
AFAIK at the moment this won't work while using the [Homeassistant Docker Image](https://github.com/Forceu/barcodebuddy-homeassistant) because mapping the plugin folder there is less trivial.

### Installation
- copy the bbuddy-mqtt folder into the plugins folder of your existing barcodebuddy installation
- edit [bbuddy-mqtt/config.php](bbuddy-mqtt/config.php) so that it points to your MQTT server (add credentials if needed)
- edit [EventReceiver.php](EventReceiver.php), add the `require_once` statement and the call to `bbuddy_mqtt_sendMQTT($eventType, $log);` within the `pluginEventReceiver_processEvent()` function.

### Screenshots
![Screenshot of the raw result in Home Assistant](https://raw.githubusercontent.com/PiAir/bbuddy-plugin-MQTT/main/resources/screenshot_1.png)

![Screenshot of the nicer result in Home Assistant](https://raw.githubusercontent.com/PiAir/bbuddy-plugin-MQTT/main/resources/screenshot_2.png)

## Contributors
<a href="https://github.com/PiAir/bbuddy-plugin-MQTT/graphs/contributors">
  <img src="https://contributors-img.web.app/image?repo=PiAir/bbuddy-plugin-MQTT" />
</a>

## TODO
- [ ] Check why autoload isn't working
- [ ] Code cleanup
- [ ] Try to find modification for original Barcodebuddy logging function so that log is not just text but also structure
- [ ] Discuss the use of composer.lock versus the current (usually not advised) inclusion of vendor folder 

## Acknowledgments

* Marc Ole Bulling for creating [Barcodebuddy](https://github.com/Forceu/barcodebuddy)
* Bernd Bestel for creating the [Grocy](https://github.com/grocy/grocy) Project


## License

This project is AGPL3+ licensed — browse the [LICENSE.md](LICENSE.md) file for details
