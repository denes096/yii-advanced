<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/26/19
 * Time: 1:47 PM
 */

namespace frontend\models;


use common\models\User;
use yii\base\Model;

class UpdateUserForm extends Model
{
    public $name;
    public $password;

    public function rules()
    {
        return [
          [['name'], 'required'],
          ['name', 'string', 'min' => 2, 'max' => 255],
          ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * @param User $user
     * @return $this
     */
    public function fillFrom($user)
    {
        $this->name = $user->name;
        return $this;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function fillTo($user)
    {
        $user->name = $this->name;
        if(strlen($this->password) > 0) {
            $user->setPassword($this->password);
        }
        return $user;
    }
}