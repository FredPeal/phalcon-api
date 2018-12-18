<?php

declare (strict_types = 1);

namespace Gewaer\Traits;

use Gewaer\Models\Subscription;
use Gewaer\Models\UserCompanyAppsActivities;
use Gewaer\Exception\SubscriptionPlanLimitException;
use Gewaer\Exception\ServerErrorHttpException;
use ReflectionClass;
use Phalcon\Di;

/**
 * Trait ResponseTrait
 *
 * @package Gewaer\Traits
 */
trait SubscriptionPlanLimitTrait
{
    /**
     * Get the key for the subscriptoin plan limit
     *
     * @return string
     */
    private function getSubcriptionPlanLimitModelKey() : string
    {
        return strtolower((new ReflectionClass($this))->getShortName()) . '_total';
    }

    /**
     * Validate if the current module for this app is at the limit of the paid plan
     *
     * @return boolean
     */
    public function isAtLimit() : bool
    {
        if (!is_object($this->di->getUserData) && !$this->di->getUserData()->isLoggedIn()) {
            return false;
        }

        $subcription = Subscription::getActiveForThisApp();
        $appPlan = $subcription->appPlan;

        if (is_object($appPlan)) {
            //get the current module limit for this plan
            $appPlanLimit = $appPlan->get($this->getSubcriptionPlanLimitModelKey());

            if (!is_null($appPlanLimit)) {
                //get tht total activity of the company current plan
                $currentCompanyAppActivityTotal = UserCompanyAppsActivities::get($this->getSubcriptionPlanLimitModelKey());

                if ($currentCompanyAppActivityTotal >= $appPlanLimit) {
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
    public function updateAppActivityLimit() : bool
    {
        if (!is_object($this->di->getUserData) && !$this->di->getUserData()->isLoggedIn()) {
            return false;
        }
        
        $companyAppActivityLimit = UserCompanyAppsActivities::findFirst([
            'conditions' => 'company_id = ?0 and apps_id = ?1 and key = ?2',
            'bind' => [Di::getDefault()->getUserData()->default_company, Di::getDefault()->getApp()->getId(), $this->getSubcriptionPlanLimitModelKey()]
        ]);

        if (is_object($companyAppActivityLimit)) {
            //its a varchar so lets make sure we convert it to int
            $companyAppActivityLimit->value = (int)$companyAppActivityLimit->value + 1;
            if (!$companyAppActivityLimit->save()) {
                throw new ServerErrorHttpException((string)current($companyAppActivityLimit->getMessages()));
            }
        } else {
            $userCopmanyAppsActivites = new UserCompanyAppsActivities();
            $userCopmanyAppsActivites->set($this->getSubcriptionPlanLimitModelKey(), 1);
        }

        return true;
    }
}
