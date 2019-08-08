<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $description
 * @property string $create_time
 * @property int $user_id
 * @property int $ticket_id
 * @property string $picture_url
 * @property Ticket $ticket
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $asd;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['create_time'], 'safe'],
            [['user_id', 'ticket_id'], 'default', 'value' => null],
            [['user_id', 'ticket_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['picture_url'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'user_id' => 'User ID',
            'ticket_id' => 'Ticket ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        try {
            $this->user_id = Yii::$app->user->getId();
            self::createDate();
        } catch (\Exception $e) {
            //TODO error
        }

        return true;
    }

    public function createDate()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->ticket->modified_time = date("Y-m-d H:i:s");
        $this->ticket->update();
        return $this->create_time = date("Y-m-d H:i:s");
    }

    public function upload()
    {
        if(!file_exists(Url::to('@frontend_web/images/'))) {
            mkdir(Url::to('@frontend_web/images/'),0777,true);
        }
        $this->picture_url = Url::to('@frontend_web/images/') . '/' . $this->id . '.jpg';
        $this->asd->saveAs($this->picture_url);
    }
}
