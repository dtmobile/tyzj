<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('getQuestions'),
                'users'=>array('*'),
            ),      
        );
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    
    public function actionGetQuestions()
    {
        $questions_list = array();
        $question_answer = array();
        $questions_list = TQuestion::model()->findAll(array('select' => array('name', 'ID')));
        foreach ($questions_list as $item) {
             $answer = TAnswer::model()->find(array('select' => 'context',
                                                        'condition' => 'questionId='.$item->ID));
            array_push($question_answer, array('question'=>$item->name, 'answer'=>$answer->context));
         }
        $result = array('error_no'=>0,
            'error_msg'=>'',
            'question_answer'=>$question_answer
        );
        echo json_encode($result);
    }
}
