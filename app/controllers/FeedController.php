<?php
declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FeedController extends \Phalcon\Mvc\Controller
{

    public function feedAction()
    {
        $token = $this->request->getHeader('Authorization');

        if (!$token) {
            return $this->response
                ->setStatusCode(401)
                ->setJsonContent(['error' => 'Unauthorized']);
        }

        $token = str_replace('Bearer ', '', $token);

        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));

            return $this->response
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(401)
                ->setJsonContent(['error' => 'Unauthorized']);
        }
    }

}

