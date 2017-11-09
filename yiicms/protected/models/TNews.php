<?php

/**
 * This is the model class for table "t_news".
 *
 * The followings are the available columns in table 't_news':
 * @property string $id
 * @property string $image
 * @property integer $createUser
 * @property string $title
 * @property string $viceTitle
 * @property string $Content
 * @property string $createDate
 * @property string $title_en
 * @property string $viceTitle_en
 * @property string $Content_en
 */
class TNews extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createUser', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>100),
			array('title, viceTitle, Content, createDate, title_en, viceTitle_en, Content_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, createUser, title, viceTitle, Content, createDate, title_en, viceTitle_en, Content_en', 'safe', 'on'=>'search'),
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
			'image' => 'Image',
			'createUser' => 'Create User',
			'title' => 'Title',
			'viceTitle' => 'Vice Title',
			'Content' => 'Content',
			'createDate' => 'Create Date',
			'title_en' => 'Title En',
			'viceTitle_en' => 'Vice Title En',
			'Content_en' => 'Content En',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('createUser',$this->createUser);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('viceTitle',$this->viceTitle,true);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('viceTitle_en',$this->viceTitle_en,true);
		$criteria->compare('Content_en',$this->Content_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TNews the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
