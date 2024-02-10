<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public $password_repeat;
    public $check;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'password', 'password_repeat', 'check'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают'
            ],
            ['check', 'compare', 'compareValue' => 1,
                'message' => 'Примите соглашение'
            ],
            ['email', 'email',  'message' => 'Невалидный email'],
            ['username', 'unique',  'message' => 'Логин занят'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i',
                'message' => 'Только латиница'
            ],
            ['name', 'match', 'pattern' => '/^[А-яЁё -]*$/u',
                'message' => 'Только кириллица, дефис и пробел'
            ],
            [['name', 'username'], 'string', 'max' => 30, 'min' => 4],
            [['email'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 32, 'min' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'check' => 'Согласие на обработку персональных данных'
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }
}
