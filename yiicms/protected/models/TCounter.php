<?php

/**
 * This is the model class for table "t_counter".
 *
 * The followings are the available columns in table 't_counter':
 * @property string $id
 * @property string $session_id
 * @property string $visit_time
 * @property string $visit_ip
 * @property integer $online
 */
class TCounter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_counter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_id, visit_time, online', 'required'),
			array('online', 'numerical', 'integerOnly'=>true),
			array('session_id', 'length', 'max'=>255),
			array('visit_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, session_id, visit_time, visit_ip, online', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'session_id' => 'Session',
			'visit_time' => 'Visit Time',
			'visit_ip' => 'Visit Ip',
			'online' => 'Online',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('visit_time',$this->visit_time,true);
		$criteria->compare('visit_ip',$this->visit_ip,true);
		$criteria->compare('online',$this->online);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TCounter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function SessionExist()
    {
        $sessionId = Yii::app()->session->sessionID;
        $userIp = Yii::app()->request->getUserHostAddress();
        $exist = self::model()->find(array('condition' => "session_id='{$sessionId}'"));
        if(!$exist)
        {
            $record = new TCounter();
            $record->session_id=$sessionId;
            $record->visit_ip =$userIp;
            $record->online =1;
            $record->visit_time = time();
            return $record->save();
        }

        return $exist;
    }

    public static function VisitCount()
    {
        return self::model()->count();
    }

    public static function onLineCount()
    {
        return self::model()->count(array('condition' => 'online=1'));
    }
}
