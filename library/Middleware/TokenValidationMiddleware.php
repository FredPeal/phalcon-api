<?php

declare(strict_types=1);

namespace Gewaer\Middleware;

use Gewaer\Exception\ModelException;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Request;
use Gewaer\Models\Users;
use Gewaer\Exception\PermissionException;
use Baka\Http\RouterCollection;

/**
 * Class TokenValidationMiddleware.
 *
 * @package Gewaer\Middleware
 */
class TokenValidationMiddleware extends TokenBase
{
    /**
     * @param Micro $api
     *
     * @return bool
     * @throws ModelException
     */
    public function call(Micro $api)
    {
        /** @var Request $request */
        $request = $api->getService('request');

        if ($this->isValidCheck($request, $api)) {
            /**
             * This is where we will validate the token that was sent to us
             * using Bearer Authentication.
             *
             * Find the user attached to this token
             */
            $token = $this->getToken($request->getBearerTokenFromHeader());

            if (!$token->validate(Users::getValidationData($token->getHeader('jti')))) {
                throw new PermissionException('Invalid Token');
                //return false;
            }
        }

        return true;
    }
}
