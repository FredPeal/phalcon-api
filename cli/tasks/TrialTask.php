<?php

namespace Gewaer\Cli\Tasks;

use Phalcon\Cli\Task as PhTask;
use Gewaer\Models\Subscription;
use Carbon\Carbon;
use \Datetime;

class TrialTask extends PhTask
{
    /**
     * Unset subscription trial_ends_at if trial has ended
     * @return void
     */
    public function unsetTrialEndsAtAction(): void
    {
        $subscriptions = Subscription::find([
            'conditions' => 'is_deleted = 0'
        ]);

        foreach ($subscriptions as $subscription) {
            $trialEnds = new Datetime($subscription->trial_ends_at);
            $trialEnds->setTime(0, 0);
            $formattedTrialEnds = $trialEnds->format('Y-m-d');

            if ($formattedTrialEnds == Carbon::today()->toDateString()) {
                $subscription->trial_ends_at = null;

                if ($subscription->update()) {
                    echo("Company: {$subscription->id} trial has ended, so its trial_ends_at is NULL \n");
                }
            }
        }
    }
}
