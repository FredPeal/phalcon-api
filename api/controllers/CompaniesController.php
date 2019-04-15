<?php

declare(strict_types=1);

namespace Gewaer\Api\Controllers;

use Gewaer\Models\Companies;
use Gewaer\Models\CompaniesCustomFields;
use Phalcon\Http\Response;
use Gewaer\Exception\UnauthorizedHttpException;
use Gewaer\Exception\UnprocessableEntityHttpException;

/**
 * Class CompaniesController
 *
 * @package Gewaer\Api\Controllers
 *
 * @property Users $userData
 * @property Request $request
 */
class CompaniesController extends BaseCustomFieldsController
{
    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $createFields = ['name', 'profile_image', 'website', 'users_id', 'address', 'zipcode', 'email', 'language', 'timezone', 'currency_id','phone'];

    /*
     * fields we accept to create
     *
     * @var array
     */
    protected $updateFields = ['name', 'profile_image', 'website', 'address', 'zipcode', 'email', 'language', 'timezone', 'currency_id','phone'];

    /**
     * set objects
     *
     * @return void
     */
    public function onConstruct()
    {
        $this->model = new Companies();
        $this->customModel = new CompaniesCustomFields();

        $this->model->users_id = $this->userData->getId();

        //my list of avaiable companies
        $this->additionalSearchFields = [
            ['id', ':', implode('|', $this->userData->getAssociatedCompanies())],
        ];
    }

    /**
     * Update an item.
     *
     * @method PUT
     * url /v1/companies/{id}
     *
     * @param mixed $id
     *
     * @return \Phalcon\Http\Response
     * @throws \Exception
     */
    public function edit($id): Response
    {
        if ($company = $this->model->findFirst($id)) {
            if (!$company->userAssociatedToCompany($this->userData) && !$this->userData->hasRole('Default.Admins')) {
                throw new UnauthorizedHttpException(_('You dont have permission to update this company info'));
            }

            $data = $this->request->getPut();

            if (empty($data)) {
                throw new UnprocessableEntityHttpException('No valid data sent.');
            }

            //set the custom fields to update
            $company->setCustomFields($data);

            //update
            if ($company->update($data, $this->updateFields)) {
                return $this->getById($id);
            } else {
                //didnt work
                throw new UnprocessableEntityHttpException($company->getMessages()[0]);
            }
        } else {
            throw new UnprocessableEntityHttpException(_('Company doesnt exist'));
        }
    }

    /**
     * Delete an item.
     *
     * @method DELETE
     * url /v1/companies/{id}
     *
     * @param mixed $id
     *
     * @return \Phalcon\Http\Response
     * @throws \Exception
     */
    public function delete($id): Response
    {
        if ($company = $this->model->findFirst($id)) {
            if (!$company->userAssociatedToCompany($this->userData) && !$this->userData->hasRole('Default.Admins')) {
                throw new UnauthorizedHttpException(_('You dont have permission to delete this company'));
            }

            if ($company->delete() === false) {
                foreach ($company->getMessages() as $message) {
                    throw new UnprocessableEntityHttpException($message);
                }
            }

            return $this->response(['Delete Successfully']);
        } else {
            throw new UnprocessableEntityHttpException(_('Company doesnt exist'));
        }
    }
}
