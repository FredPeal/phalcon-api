<?php

declare(strict_types=1);

namespace Gewaer\Api\Controllers;

use Gewaer\Models\EmailTemplates;
use Gewaer\Exception\NotFoundHttpException;
use Gewaer\Exception\UnprocessableEntityHttpException;
use Phalcon\Security\Random;
use Phalcon\Http\Response;

/**
 * Class LanguagesController
 *
 * @package Gewaer\Api\Controllers
 *
 * @property Users $userData
 * @property Request $request
 * @property Config $config
 * @property \Baka\Mail\Message $mail
 * @property Apps $app
 *
 */
class EmailTemplatesController extends BaseController
{
    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $createFields = ['users_id', 'companies_id', 'apps_id', 'name', 'template'];

    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $updateFields = ['users_id', 'companies_id', 'apps_id', 'name', 'template'];

    /**
     * set objects
     *
     * @return void
     */
    public function onConstruct()
    {
        $this->model = new EmailTemplates();
        $this->additionalSearchFields = [
            ['is_deleted', ':', '0'],
            ['companies_id', ':', '0|' . $this->userData->currentCompanyId()],
        ];
    }

    /**
     * Add a new by copying a specific email template based on
     *
     * @method POST
     * @url /v1/data
     * @param integer $id
     * @return \Phalcon\Http\Response
     */
    public function copy(int $id): Response
    {
        $request = $this->request->getPost();

        if (empty($request)) {
            $request = $this->request->getJsonRawBody(true);
        }

        //Find email template based on the basic parameters
        $existingEmailTemplate = $this->model::findFirst([
            'conditions' => 'id = ?0 and companies_id in (?1,?2) and apps_id in (?3,?4) and is_deleted = 0',
            'bind' => [$id, $this->userData->default_company, 0, $this->app->getId(), 0]
        ]);

        if (!is_object($existingEmailTemplate)) {
            throw new NotFoundHttpException('Email Template not found');
        }

        $random = new Random();
        $randomInstance = $random->base58();

        $request['users_id'] = $existingEmailTemplate->users_id;
        $request['companies_id'] = $this->userData->default_company;
        $request['apps_id'] = $this->app->getId();
        $request['name'] = $existingEmailTemplate->name . '-' . $randomInstance;
        $request['template'] = $existingEmailTemplate->template;

        //try to save all the fields we allow
        if ($this->model->save($request, $this->createFields)) {
            return $this->response($this->model->toArray());
        } else {
            //if not thorw exception
            throw new UnprocessableEntityHttpException((string) current($this->model->getMessages()));
        }
    }
}
