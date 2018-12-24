<?php

use Gewaer\Models\Subscription;

class AppsPlanCest
{
    /**
     * Create subscription
     *
     * @param ApiTester $I
     * @return void
     */
    public function create(ApiTester $I): void
    {
        $userData = $I->apiLogin();

        //when doing a signup we create a subscription, so need to delete to confirm this test
        $subscriptions = Subscription::find('user_id =' . $userData->id);
        foreach ($subscriptions as $subscription) {
            $subscription->is_deleted = 1;
            $subscription->update();
        }

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->sendPost('/v1/apps-plans', [
            'stripe_id' => 'monthly-10-1',
            'exp_month' => '05',
            'exp_year' => '2020',
            'cvc' => '123',
            'number' => '4242424242424242',
        ]);

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->assertTrue(isset($data['id']));
    }

    /**
     * Create subscription
     *
     * @param ApiTester $I
     * @return void
     */
    public function upgrade(ApiTester $I): void
    {
        $userData = $I->apiLogin();
        $this->undeleteSubscriptions();

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->sendPut('/v1/apps-plans/monthly-10-2');

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->assertTrue(isset($data['id']));
    }

    /**
     * Create subscription
     *
     * @param ApiTester $I
     * @return void
     */
    public function downgrade(ApiTester $I): void
    {
        $userData = $I->apiLogin();
        $this->undeleteSubscriptions();

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->sendPut('/v1/apps-plans/monthly-10-1');

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->assertTrue(isset($data['id']));
    }

    /**
     * Create subscription
     *
     * @param ApiTester $I
     * @return void
     */
    public function cancelSubscription(ApiTester $I): void
    {
        $userData = $I->apiLogin();

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->sendDelete('/v1/apps-plans/monthly-10-1');

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        //we need to update all subscriptions for other test
        $this->undeleteSubscriptions();

        $I->assertTrue(isset($data['id']));
    }

    /**
     * We need to make sure we dont have the current subscription delete by other test
     *
     * @return void
     */
    public function undeleteSubscriptions()
    {
        //we need to update all subscriptions for other test
        $subscriptions = Subscription::find();
        foreach ($subscriptions as $subscription) {
            $subscription->is_deleted = 0;
            $subscription->update();
        }
    }
}
