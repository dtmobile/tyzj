<?php

class ExpertController extends Controller
{

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('getExperts'),
                'users'=>array('*'),
            ),      
        );
    }
    
    public function actionGetExperts()
    {
        $tiyukexue_id=1;
        $result = TExpert::model()->findAll(array('select'=>array('name','job'),'condition' => 'periodical_id='.$tiyukexue_id));
        $kxzb = array();
        $kxfzb = array();
        $kxbj = array();
        foreach ($result as $item) {
            if($item->job == 1)
            {
                array_push($kxzb, $item->name);
            }else if($item->job == 2)
            {
                array_push($kxfzb, $item->name);
            }else if($item->job == 3)
            {
                array_push($kxbj, $item->name);                
            }            
        }
        
        $kexuePeriodical = TPeriodical::model()->find(array('select'=>array('name','viceTitle'),'condition' => 'ID='.$tiyukexue_id));
        $tiyukexue = array('title'=>$kexuePeriodical->name,
                                    'zb'=>$kxzb,'fzb'=>$kxfzb,
                                    'bw'=>$kxbj,
                                    'viceTitle'=>$kexuePeriodical->viceTitle,
                                    'image'=>'img/book2.png'
        );
    
         
        $tiyukeji_id=2;
        $result = TExpert::model()->findAll(array('select'=>array('name','job'),'condition' => 'periodical_id='.$tiyukeji_id));
        $kjzb = array();
        $kjfzb = array();
        $kjbj = array();
        foreach ($result as $item) {
            if($item->job == 1)
            {
                array_push($kjzb, $item->name);
            }else if($item->job == 2)
            {
                array_push($kjfzb, $item->name);
            }else if($item->job == 3)
            {
                array_push($kjbj, $item->name);
            }
        }
        $kejiPeriodical = TPeriodical::model()->find(array('select'=>array('name','viceTitle'),'condition' => 'ID='.$tiyukeji_id));
        $tiyukeji = array('title'=>$kejiPeriodical->name,
                                    'zb'=>$kjzb,'fzb'=>$kjfzb,
                                    'bw'=>$kjbj,
                                    'viceTitle'=>$kejiPeriodical->viceTitle,
                                    'image'=>'img/book1.png'            
        );


        $result = array('error_no'=>0,
            'error_msg'=>'',
            'tiyukexue'=>$tiyukexue,
            'tiyukeji'=>$tiyukeji
        );
        echo json_encode($result);
    }
}