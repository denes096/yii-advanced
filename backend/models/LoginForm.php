<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/30/19
 * Time: 4:16 PM
 */

namespace backend\models;


use Yii;
use common\models\User;

class LoginForm extends \common\models\LoginForm
{

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = User::find()->ofEmail($this->email)->ofIsAdmin(User::STATUS_ADMIN)->one();
        }

        return $this->user;
    }

}