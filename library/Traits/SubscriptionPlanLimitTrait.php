<?php

declare(strict_types=1);

namespace Gewaer\Traits;

use Gewaer\Models\Subscription;
use Gewaer\Models\UserCompanyAppsActivities;
use Gewaer\Exception\SubscriptionPlanLimitException;
use Gewaer\Exception\ServerErrorHttpException;

/**
 * Trait ResponseTrait
 *
 * @package Gewaer\Traits
 */
trait SubscriptionPlanLimit
{
    /**
     * Get the key for the subscriptoin plan limit
     *
     * @return string
     */
    private function getSubcriptionPlanLimitModelKey(): string
    {
        return strtolower(get_class($this)) . '_total';
    }

    /**
     * Validate if the current module for this app is at the limit of the paid plan
     *
     * @return boolean
     */
    public function isAtLimit(): bool
    {
        $subcription = Subscription::getActiveForThisApp();
        $appPlan = $subcription->appPlan;

        if (is_object($appPlan)) {
            //get the current module limit for this plan
            $appPlanLimit = $appPlan::get($this->getSubcriptionPlanLimitModelKey());

            if (!is_null($appPlanLimit)) {
                //get tht total activity of the company current plan
                $currentCompanyAppActivityTotal = UserCompanyAppsActivities::get($this->getSubcriptionPlanLimitModelKey());

                if ($appPlanLimit == $currentCompanyAppActivityTotal) {
                    throw new SubscriptionPlanLimitException(_($subcription->company->name . ' has reach the limit of it current plan ' . $appPlan->name . ' please upgrade or contact support'));
                }
            }
        }

        return true;
    }

    /**
     * Call at the afterCreate of all modules which are part of a plan activity
     *
     * @return boolean
     */
    public function updateAppActivityLimit(): bool
    {
        $companyAppActivityLimit = UserCompanyAppsActivities::findFirst([
            'conditions' => 'company_id = ?0 and apps_id = ?1 and key = ?2',
            'bind' => [$this->di->getUserData()->default_company, $this->di->getApp()->getId(), $this->getSubcriptionPlanLimitModelKey()]
        ]);

        if (is_object($companyAppActivityLimit)) {
            //its a varchar so lets make sure we convert it to int
            $companyAppActivityLimit->value = (int) $companyAppActivityLimit->value + 1;
            if (!$companyAppActivityLimit->save()) {
                throw new ServerErrorHttpException((string) current($companyAppActivityLimit->getMessages()));
            }
        } else {
            $userCopmanyAppsActivites = new UserCompanyAppsActivities();
            $userCopmanyAppsActivites->set($this->getSubcriptionPlanLimitModelKey(), 1);
        }

        return true;
    }
}
