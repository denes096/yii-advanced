<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/23/19
 * Time: 1:09 PM
 */

namespace frontend\models;

use Yii;
use yii\base\Model;

class SimpleForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}