<?php

/**
 * This is the model class for table "t_attachment".
 *
 * The followings are the available columns in table 't_attachment':
 * @property integer $ID
 * @property integer $articleID
 * @property string $name
 * @property integer $type
 * @property string $filename
 * @property string $bigFilename
 * @property string $linkAlt
 * @property string $srcFile
 * @property string $fileExt
 * @property string $filesize
 * @property string $contentType
 * @property string $creationdate
 * @property string $modifieddate
 * @property string $owner
 */
class TAttachment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_attachment';
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
			array('ID, articleID, type', 'numerical', 'integerOnly'=>true),
			array('name, filename, bigFilename, linkAlt, srcFile', 'length', 'max'=>255),
			array('fileExt', 'length', 'max'=>20),
			array('filesize', 'length', 'max'=>19),
			array('contentType', 'length', 'max'=>50),
			array('owner', 'length', 'max'=>30),
			array('creationdate, modifieddate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, articleID, name, type, filename, bigFilename, linkAlt, srcFile, fileExt, filesize, contentType, creationdate, modifieddate, owner', 'safe', 'on'=>'search'),
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
			'articleID' => 'Article',
			'name' => 'Name',
			'type' => 'Type',
			'filename' => 'Filename',
			'bigFilename' => 'Big Filename',
			'linkAlt' => 'Link Alt',
			'srcFile' => 'Src File',
			'fileExt' => 'File Ext',
			'filesize' => 'Filesize',
			'contentType' => 'Content Type',
			'creationdate' => 'Creationdate',
			'modifieddate' => 'Modifieddate',
			'owner' => 'Owner',
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
		$criteria->compare('articleID',$this->articleID);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('bigFilename',$this->bigFilename,true);
		$criteria->compare('linkAlt',$this->linkAlt,true);
		$criteria->compare('srcFile',$this->srcFile,true);
		$criteria->compare('fileExt',$this->fileExt,true);
		$criteria->compare('filesize',$this->filesize,true);
		$criteria->compare('contentType',$this->contentType,true);
		$criteria->compare('creationdate',$this->creationdate,true);
		$criteria->compare('modifieddate',$this->modifieddate,true);
		$criteria->compare('owner',$this->owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TAttachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
