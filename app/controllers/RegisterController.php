<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use ZxcvbnPhp\Zxcvbn;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email as EmailValidator;
use Phalcon\Filter\Validation\Validator\StringLength as StringLengthValidator;

class RegisterController extends \Phalcon\Mvc\Controller
{

    public function registerAction()
    {
        $jsonData = $this->request->getJsonRawBody(true);

        $email = $jsonData['email'] ?? null;
        $password = $jsonData['password'] ?? null;

        $validation = new Validation();
        $validation->add('email', new EmailValidator([
            'message' => 'Invalid email format'
        ]));

        $messages = $validation->validate(['email' => $email]);
        if (count($messages)) {
            return $this->response
            ->setStatusCode(400)
            ->setJsonContent([
                'status' => 'error',
                'message' => $messages[0]->getMessage()
            ]);
        }

        $existingUser = Users::findFirst([
            'conditions' => 'email = :email:',
            'bind'       => [
                'email' => $email
            ]
        ]);

        if ($existingUser) {
            return $this->response
            ->setStatusCode(400)
            ->setJsonContent([
                'status' => 'error',
                'message' => 'User with this email already exists'
            ]);
        }

        $passwordStrength = $this->checkPasswordStrength($password);

        if($passwordStrength == 'weak') {
            return $this->response
            ->setStatusCode(400)
            ->setJsonContent([
                'status' => 'error',
                'message' => 'Weak password'
            ]);
        } 

        $user = new Users();
        $user->email = $email;
        $user->password = $this->security->hash($password);

        if ($user->save()) {
            return $this->response
            ->setStatusCode(201)
            ->setJsonContent([
                'user_id' => (int)$user->id,
                'password_check_status' => $passwordStrength
            ]);
        } else {
            return $this->response->setJsonContent([
                'status' => 'error'
            ]);
        }
    }

    private function checkPasswordStrength($password)
    {
        $output = 'weak';
        $zxcvbn = new Zxcvbn();

        $passwordStrength = $zxcvbn->passwordStrength($password);

        switch($passwordStrength['score']) {
            case 3:
                $output = 'good';
                break;
            case 4:
                $output = 'perfect';
                break;
        }

        return $output;
    }

}

