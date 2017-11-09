<?php

/**
 * This is the model class for table "t_article".
 *
 * The followings are the available columns in table 't_article':
 * @property string $ID
 * @property integer $createUser
 * @property integer $issueId
 * @property string $name
 * @property string $name_en
 * @property string $viceTitle
 * @property string $keyword
 * @property string $keyword_en
 * @property string $source
 * @property string $summary
 * @property string $summary_en
 * @property string $url
 * @property string $publishUrl
 * @property integer $viewCount
 * @property integer $wordCount
 * @property integer $grade
 * @property string $content
 * @property string $version
 * @property integer $type
 * @property integer $status
 * @property integer $pubFlag
 * @property string $creationdate
 * @property string $modifieddate
 * @property string $publishdate
 * @property string $owner
 * @property string $author
 * @property string $authorIntroduction
 * @property string $fenleihao
 * @property string $wenxianhao
 * @property integer $xueke
 * @property string $query1
 * @property string $query2
 * @property integer $lockedFlag
 * @property string $lockedBy
 * @property string $content_en
 * @property string $image
 * @property string $visit_num
 */
class TArticle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visit_num', 'required'),
			array('createUser, issueId, viewCount, wordCount, grade, type, status, pubFlag, xueke, lockedFlag', 'numerical', 'integerOnly'=>true),
			array('source, version, owner, fenleihao, wenxianhao, lockedBy', 'length', 'max'=>150),
			array('url, publishUrl, query2, image', 'length', 'max'=>255),
			array('visit_num', 'length', 'max'=>11),
			array('name, name_en, viceTitle, keyword, keyword_en, summary, summary_en, content, creationdate, modifieddate, publishdate, author, authorIntroduction, query1, content_en', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, createUser, issueId, name, name_en, viceTitle, keyword, keyword_en, source, summary, summary_en, url, publishUrl, viewCount, wordCount, grade, content, version, type, status, pubFlag, creationdate, modifieddate, publishdate, owner, author, authorIntroduction, fenleihao, wenxianhao, xueke, query1, query2, lockedFlag, lockedBy, content_en, image, visit_num', 'safe', 'on'=>'search'),
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
			'createUser' => 'Create User',
			'issueId' => 'Issue',
			'name' => 'Name',
			'name_en' => 'Name En',
			'viceTitle' => 'Vice Title',
			'keyword' => 'Keyword',
			'keyword_en' => 'Keyword En',
			'source' => 'Source',
			'summary' => 'Summary',
			'summary_en' => 'Summary En',
			'url' => 'Url',
			'publishUrl' => 'Publish Url',
			'viewCount' => 'View Count',
			'wordCount' => 'Word Count',
			'grade' => 'Grade',
			'content' => 'Content',
			'version' => 'Version',
			'type' => 'Type',
			'status' => 'Status',
			'pubFlag' => 'Pub Flag',
			'creationdate' => 'Creationdate',
			'modifieddate' => 'Modifieddate',
			'publishdate' => 'Publishdate',
			'owner' => 'Owner',
			'author' => 'Author',
			'authorIntroduction' => 'Author Introduction',
			'fenleihao' => 'Fenleihao',
			'wenxianhao' => 'Wenxianhao',
			'xueke' => 'Xueke',
			'query1' => 'Query1',
			'query2' => 'Query2',
			'lockedFlag' => 'Locked Flag',
			'lockedBy' => 'Locked By',
			'content_en' => 'Content En',
			'image' => 'Image',
			'visit_num' => 'Visit Num',
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

		$criteria->compare('ID',$this->ID,true);
		$criteria->compare('createUser',$this->createUser);
		$criteria->compare('issueId',$this->issueId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('viceTitle',$this->viceTitle,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('keyword_en',$this->keyword_en,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('summary_en',$this->summary_en,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('publishUrl',$this->publishUrl,true);
		$criteria->compare('viewCount',$this->viewCount);
		$criteria->compare('wordCount',$this->wordCount);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('pubFlag',$this->pubFlag);
		$criteria->compare('creationdate',$this->creationdate,true);
		$criteria->compare('modifieddate',$this->modifieddate,true);
		$criteria->compare('publishdate',$this->publishdate,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('authorIntroduction',$this->authorIntroduction,true);
		$criteria->compare('fenleihao',$this->fenleihao,true);
		$criteria->compare('wenxianhao',$this->wenxianhao,true);
		$criteria->compare('xueke',$this->xueke);
		$criteria->compare('query1',$this->query1,true);
		$criteria->compare('query2',$this->query2,true);
		$criteria->compare('lockedFlag',$this->lockedFlag);
		$criteria->compare('lockedBy',$this->lockedBy,true);
		$criteria->compare('content_en',$this->content_en,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('visit_num',$this->visit_num,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TArticle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function visitNumIncrease($articleId)
    {
        $article = self::model()->findByPk($articleId);

        if(!empty($article))
        {
            $article->visit_num=$article->visit_num+1;
            $article->save();
        }
    }
}
