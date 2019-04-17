<?php

namespace Gewaer\Cli\Tasks;

use Phalcon\Cli\Task as PhTask;
use Gewaer\Models\UserLinkedSources;
use Gewaer\Models\Users;
use Throwable;
use Phalcon\Di;
use Gewaer\Notifications\Mobile\Apps as AppsPushNotifications;
use Gewaer\Notifications\Mobile\Users as UsersPushNotifications;
use Gewaer\Notifications\Mobile\System as SystemPushNotifications;

/**
 * CLI To send push ontification and pusher msg
 *
 * @package Gewaer\Cli\Tasks
 *
 * @property Config $config
 * @property \Pusher\Pusher $pusher
 * @property \Monolog\Logger $log
 * @property Channel $channel
 * @property Queue $queue
 *
 */
class QueueTask extends PhTask
{
    public function notificationAction()
    {
        $channel = $this->queue->channel();

        // Create the queue if it doesnt already exist.
        $channel->queue_declare(
            $queue = "notifications",
            $passive = false,
            $durable = true,
            $exclusive = false,
            $auto_delete = false,
            $nowait = false,
            $arguments = null,
            $ticket = null
        );

        echo ' [*] Waiting for notifications. To exit press CTRL+C', "\n";

        $callback = function ($msg) {
            $msgObject = json_decode($msg->body);



            echo ' [x] Received from system module: ',$msgObject->system_module, "\n";


            /**
             * Lets determine what type of notification we are dealing with
             */
            switch ($msgObject->notification_type_id) {
                 case 1:
                      $notification = new AppsPushNotifications((array)$msgObject->user, $msgObject->content, $msgObject->system_module);
                     break;
                 case 2:
                    $notification = new UsersPushNotifications((array)$msgObject->user, $msgObject->content, $msgObject->system_module);
                     break;

                 case 3:
                    $notification = new SystemPushNotifications((array)$msgObject->user, $msgObject->content, $msgObject->system_module);
                     break;
                 default:
                     break;
             }


            /**
             * Trigger Event Manager
             */
            Di::getDefault()->getManager()->trigger($notification);

            /**
             * Log the delivery info
             */
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_qos(null, 1, null);

        $channel->basic_consume(
            $queue = "notifications",
            $consumer_tag = '',
            $no_local = false,
            $no_ack = false,
            $exclusive = false,
            $nowait = false,
            $callback
        );

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->queue->close();
    }
}
