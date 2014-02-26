<?php

/**
 * This is the model class for table "dbs_user".
 *
 * The followings are the available columns in table 'dbs_user':
 * @property string $user_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $nickname
 * @property integer $gender
 * @property integer $age
 * @property string $description
 * @property string $avator
 * @property integer $type
 * @property integer $user_rate
 * @property integer $credit_rate
 * @property double $longitude
 * @property double $latitude
 * @property string $address
 * @property string $register_time
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dbs_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, username, password, nickname', 'required'),
			array('gender, age, type, user_rate, credit_rate', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('user_id, username, password, nickname', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('description, address', 'length', 'max'=>200),
			array('avator', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, password, email, phone, nickname, gender, age, description, avator, type, user_rate, credit_rate, longitude, latitude, address, register_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'phone' => 'Phone',
			'nickname' => 'Nickname',
			'gender' => 'Gender',
			'age' => 'Age',
			'description' => 'Description',
			'avator' => 'Avator',
			'type' => 'Type',
			'user_rate' => 'User Rate',
			'credit_rate' => 'Credit Rate',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'address' => 'Address',
			'register_time' => 'Register Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('age',$this->age);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('avator',$this->avator,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_rate',$this->user_rate);
		$criteria->compare('credit_rate',$this->credit_rate);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('register_time',$this->register_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
