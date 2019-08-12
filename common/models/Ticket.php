<?php

namespace common\models;

use common\models\TicketQuery;
use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $title
 * @property string $createtime
 * @property bool $is_open
 * @property int $user_id
 * @property int $admin_id
 * @property string $modified_time
 *
 * @property Comment[] $comments
 * @property User $user
 * @property User $admin
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['createtime','modified_time'], 'safe'],
            [['is_open'], 'boolean'],
            [['user_id', 'admin_id'], 'default', 'value' => null],
            [['user_id', 'admin_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'createtime' => 'Createtime',
            'is_open' => 'Is Open',
            'user_id' => 'User ID',
            'admin_id' => 'Admin ID',
        ];
    }

    public static function find()
    {
        return new TicketQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        if($insert) {
            try {
                $this->user_id = Yii::$app->user->getId();
                self::createDate();
            } catch (\Exception $e) {
                //TODO error
            }
        }

        return true;
    }

    public function createDate()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->modified_time = date("Y-m-d H:i:s");
        $this->createtime = date("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getLastCommentId()
    {
        return $this->getComments()->max('id');
    }
}
