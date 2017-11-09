<?php

/**
 * This is the model class for table "t_issue".
 *
 * The followings are the available columns in table 't_issue':
 * @property string $id
 * @property integer $createUser
 * @property integer $periodicalId
 * @property string $name
 * @property string $summary
 * @property string $desciption
 * @property string $picPath
 * @property string $publshDate
 * @property string $createDate
 * @property string $name_en
 * @property string $summary_en
 * @property string $picPath_en
 */
class TIssue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_issue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createUser, periodicalId', 'numerical', 'integerOnly'=>true),
			array('desciption', 'length', 'max'=>500),
			array('name, summary, picPath, publshDate, createDate, name_en, summary_en, picPath_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, createUser, periodicalId, name, summary, desciption, picPath, publshDate, createDate, name_en, summary_en, picPath_en', 'safe', 'on'=>'search'),
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
			'createUser' => 'Create User',
			'periodicalId' => 'Periodical',
			'name' => 'Name',
			'summary' => 'Summary',
			'desciption' => 'Desciption',
			'picPath' => 'Pic Path',
			'publshDate' => 'Publsh Date',
			'createDate' => 'Create Date',
			'name_en' => 'Name En',
			'summary_en' => 'Summary En',
			'picPath_en' => 'Pic Path En',
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
		$criteria->compare('createUser',$this->createUser);
		$criteria->compare('periodicalId',$this->periodicalId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('desciption',$this->desciption,true);
		$criteria->compare('picPath',$this->picPath,true);
		$criteria->compare('publshDate',$this->publshDate,true);
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('summary_en',$this->summary_en,true);
		$criteria->compare('picPath_en',$this->picPath_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TIssue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
