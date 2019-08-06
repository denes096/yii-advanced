<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/26/19
 * Time: 1:47 PM
 */

namespace backend\models;


use yii\base\Model;

class UpdateUserForm extends Model
{
    public $name;
    public $password;
    public $email;
    public $is_admin;

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 8],
            ['email', 'email'],
            ['is_admin','boolean'],
        ];
    }

    /**
     * @param User $user
     * @return $this
     */
    public function fillFrom($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
        return $this;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function fillTo($user)
    {
        $user->name = $this->name;
        $user->is_admin = $this->is_admin;
        $user->email = $this->email;
        if(strlen($this->password) > 0) {
            $user->setPassword($this->password);
        }
        return $user;
    }
}