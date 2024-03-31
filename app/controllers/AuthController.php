<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use Phalcon\Http\Response;

class AuthController extends \Phalcon\Mvc\Controller
{

    public function authenticationAction()
    {
        $jsonData = $this->request->getJsonRawBody(true);

        $email = $jsonData['email'] ?? null;
        $password = $jsonData['password'] ?? null;

        $user = Users::findFirstByEmail($email);


        if (!$user || !password_verify($password, $user->password)) {

            return $this->response
            ->setStatusCode(401)
            ->setJsonContent(['error' => 'Unauthorized']);
        }

        $user_id = $user->id;
        $token = JWT::encode(['user_id' => $user_id,
                              'iat' => time(),
                              'exp' => time() + 3600], $_ENV['JWT_SECRET'], 'HS256');

        return $this->response
        ->setStatusCode(200)
        ->setJsonContent(['access_token' => $token]);

    }

}

