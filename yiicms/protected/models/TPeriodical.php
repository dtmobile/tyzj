<?php

/**
 * This is the model class for table "t_periodical".
 *
 * The followings are the available columns in table 't_periodical':
 * @property integer $ID
 * @property string $name
 * @property string $viceTitle
 * @property string $summary
 * @property string $name_en
 * @property string $viceTitle_en
 * @property string $summary_en
 */
class TPeriodical extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_periodical';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID', 'required'),
			array('ID', 'numerical', 'integerOnly'=>true),
			array('name, viceTitle, summary, name_en, viceTitle_en, summary_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, name, viceTitle, summary, name_en, viceTitle_en, summary_en', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'name' => 'Name',
			'viceTitle' => 'Vice Title',
			'summary' => 'Summary',
			'name_en' => 'Name En',
			'viceTitle_en' => 'Vice Title En',
			'summary_en' => 'Summary En',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('viceTitle',$this->viceTitle,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('viceTitle_en',$this->viceTitle_en,true);
		$criteria->compare('summary_en',$this->summary_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TPeriodical the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
