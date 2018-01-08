<?php

class IndexController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionVisitInfo()
	{
        $visitCount = TSyscfg::getVisitCount();
        $visitCount+=1;
        TSyscfg::setVisitCount($visitCount);

//        TCounter::SessionExist();
//        $visitCount = TCounter::VisitCount();
//        $onlineCount = TCounter::onLineCount();

        $result = array('error_no'=>0,
            'error_msg'=>'',
            'visit_count'=>$visitCount,
        );
        echo json_encode($result);
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
