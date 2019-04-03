<?php

declare(strict_types=1);

namespace Gewaer\Api\Controllers;

use Gewaer\Models\UserLinkedSources;
use Baka\Auth\Models\Sources;
use Phalcon\Http\Response;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Gewaer\Exception\BadRequestHttpException;
use Gewaer\Exception\NotFoundHttpException;
use Gewaer\Exception\UnprocessableEntityHttpException;

/**
 * Class LanguagesController
 *
 * @package Gewaer\Api\Controllers
 * @property UserData $userData
 *
 */
class UserLinkedSourcesController extends BaseController
{
    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $createFields = ['users_id', 'source_id', 'source_users_id', 'source_users_id_text', 'source_username'];

    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $updateFields = ['users_id', 'source_id', 'source_users_id', 'source_users_id_text', 'source_username'];

    /**
     * set objects
     *
     * @return void
     */
    public function onConstruct()
    {
        $this->model = new UserLinkedSources();
        $this->additionalSearchFields = [
            ['is_deleted', ':', '0'],
        ];
    }

    /**
     * Associate a Device with the corrent loggedin user
     *
     * @url /users/{id}/device
     * @method POST
     * @return Response
     */
    public function devices() : Response
    {
        //Ok let validate user password
        $validation = new Validation();
        $validation->add('app', new PresenceOf(['message' => _('App name is required.')]));
        $validation->add('deviceId', new PresenceOf(['message' => _('device ID is required.')]));
        $msg = null;

        //validate this form for password
        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            foreach ($messages as $message) {
                throw new BadRequestHttpException((string)$message);
            }
        }

        $app = $this->request->getPost('app', 'string');
        $deviceId = $this->request->getPost('deviceId', 'string');

        //get the app source
        if ($source = Sources::getByTitle($app)) {
            $userSource = UserLinkedSources::findFirst([
                'conditions' => 'users_id = ?0 and source_users_id_text = ?1',
                'bind' => [$this->userData->getId(), $deviceId]
            ]);

            if (!is_object($userSource)) {
                $userSource = new UserLinkedSources();
                $userSource->users_id = $this->userData->getId();
                $userSource->source_id = $source->getId();
                $userSource->source_users_id = $this->userData->getId();
                $userSource->source_users_id_text = $deviceId;
                $userSource->source_username = $this->userData->displayname . ' ' . $app;
                $userSource->is_deleted = 0;

                if (!$userSource->save()) {
                    throw new UnprocessableEntityHttpException((string) current($userSource->getMessages()));
                }

                $msg = 'User Device Associated';
            } else {
                $msg = 'User Device Already Associated';
            }
        }

        //clean password @todo move this to a better place
        $this->userData->password = null;

        return $this->response([
            'msg' => $msg,
            'user' => $this->userData
        ]);
    }

    /**
     * Detach user's devices
     * @param integer $deviceId User's devices id
     * @return Response
     */
    public function detachDevice(int $id, int $deviceId): Response
    {
        //Validation
        $validation = new Validation();
        $validation->add('source_id', new PresenceOf(['message' => _('Source Id is required.')]));

        //validate this form for password
        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            foreach ($messages as $message) {
                throw new BadRequestHttpException((string)$message);
            }
        }

        $sourceId = $this->request->getPost('source_id', 'int');

        $userSource = UserLinkedSources::findFirst([
                'conditions' => 'users_id = ?0 and source_id = ?1 and source_users_id_text = ?2 and is_deleted = 0',
                'bind' => [$this->userData->getId(), $sourceId, $deviceId]
            ]);

        //Check if User Linked Sources exists by users_id and source_users_id_text
        if (!is_object($userSource)) {
            throw new NotFoundHttpException('User Linked Source not found');
        }

        $userSource->is_deleted = 1;
        if (!$userSource->update()) {
            throw new UnprocessableEntityHttpException((string) current($userSource->getMessages()));
        }

        return $this->response([
                'msg' => 'User Device detached',
                'user' => $this->userData
            ]);
    }
}
