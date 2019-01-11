<?php

namespace Gewaer\Tests\api;

use ApiTester;

class FileSystemCest
{
    protected $model = 'filesystem';

    /**
     * Create
     *
     * @param ApiTester $I
     * @return void
     */
    public function create(ApiTester $I) : void
    {
        $userData = $I->apiLogin();
        $fileName = 'test.png';

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->haveHttpHeader('Content-Type', 'multipart/form-data');

        $I->sendPost('/v1/' . $this->model, ['system_modules_id' => 1, 'entity_id' => 1], ['file' => '/app/tests/testfiles/test.png']);

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->assertTrue($data[0]['name'] == $fileName);
    }

    /**
     * update
     *
     * @param ApiTester $I
     * @return void
     */
    public function update(ApiTester $I) : void
    {
        $userData = $I->apiLogin();

        $I->haveHttpHeader('Authorization', $userData->token);
        $I->sendGet('/v1/' . $this->model);

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->sendPUT('/v1/' . $this->model . '/' . $data[count($data) - 1]['id'], [
            'system_modules_id' => 2
        ]);

        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data = json_decode($response, true);

        $I->assertTrue($data['system_modules_id'] == 2);
    }
}
