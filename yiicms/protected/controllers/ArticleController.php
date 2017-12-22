<?php
require_once 'log.php';

class ArticleController extends Controller
{
    
    private function getMultiConditionStr($columnName,$searchString)
    {
	    $searchString = str_replace('，', ',', $searchString);
	    $searchString = trim($searchString);
	    $search_array = explode(',', $searchString);

	    $condition = '(';
	    foreach ($search_array as $u_name)
	    {
        if(empty($u_name))
        {
	        continue;
        }
        
        $condition.=" $columnName like '%{$u_name}%' or";
	    }

	    $condition = trim($condition,'or');
	    $condition.=')';
	    
	    return $condition;
    }

    public function actionSeniorSearch($type,$author_name,$author_company,$name,$summary,$keywords,$pacs)
    {
        if(empty($type) && empty($author_name) && empty($author_company) && empty($name) && empty($summary) && empty($keywords) && empty($pacs))
        {
            $result = array('error_no'=>0,
                'error_msg'=>'',
                'search_results'=>''
            );
            echo json_encode($result);
            return;
        }
    
        
        log::getInstance()->warning("{$type}  {$author_name}  {$author_company}  {$name}  {$summary}  {$keywords}  {$pacs} ");
        $search_results = array();
   		$command = 'select ID,`name`,author,summary,issueId from t_article where ';
   		if(!empty($author_name))
   		{
//    		    $command.="author like '%{$author_name}%' and";

//    		    $author_name = str_replace('，', ',', $author_name);
//    		    $author_name = trim($author_name);
//    		    $author_namr_array = explode(',', $author_name);
   		    
//    		    $condition = '(';
//    		    foreach ($author_namr_array as $u_name)
//    		    {
//    		        $condition.=" author like '%{$u_name}%' or";
//    		    }
   		    
//    		    $condition = trim($condition,'or');
//    		    $condition.=')';
           $condition = $this->getMultiConditionStr('author', $author_name);
   		   $command.="$condition and";
//
   		}
   		
   		if(!empty($author_company))
   		{   		    
//    		    $command.=" authorIntroduction like '%{$author_company}%' and";
   		    $condition = $this->getMultiConditionStr('authorIntroduction', $author_company);
   		    $command.="$condition and";
   		}
   		
   		if(!empty($name))
   		{
   		    $command.=" name like '%{$name}%' and";
   		}
   		
   		if(!empty($summary))
   		{
   		    $command.=" summary like '%{$summary}%' and";
   		}
   		
   		if(!empty($keywords))
   		{
//    		    $command.=" keyword like'%{$keywords}%' and";
   		    $condition = $this->getMultiConditionStr('keyword', $keywords);
   		    $command.="$condition and";
   		}
   	
   		if(!empty($pacs))
   		{
   		    $command.=" fenleihao like '%{$pacs}%' and";
   		}
   		
   		if($type==1 || $type==2)
   		{
   		    $command.=" issueId IN (SELECT ID FROM t_issue WHERE periodicalId={$type}) ";
   		}
   		
   		$command = trim($command, "and");
   		log::getInstance()->warning('sqlcommand is :'.$command);
   		$articles = TArticle::model()->findAllBySql($command);
   		
   		$currentissue = array();
   		$currentKexueIssue = $this->getCurrentIssue(1);
   		if(!empty($currentKexueIssue))
   		{
   		    array_push($currentissue, $currentKexueIssue->id);
   		}
   		
   		$currentKejiIssue = $this->getCurrentIssue(2);
   		if(!empty($currentKejiIssue))
   		{
   		    array_push($currentissue, $currentKejiIssue->id);
   		}
        
        foreach ($articles as $item) {
            $article['ID']=$item->ID;
            $article['name']=$item->name;
            $article['author']=$item->author;  
            if(in_array($item->issueId,$currentissue))
            {
                $article['hot']=true;
            }else
            {
                log::getInstance()->warning('my issueId is '.$item->issueId);
            }
            $article['summary']=$item->summary;
            $article['issueId']=$item->issueId;
            

            $belongIssue = $this->getArticlePublshData($item->issueId);
            if(!empty($belongIssue))
            {
                $article['publshDate']=$belongIssue->publshDate;
            }
           
            array_push($search_results,$article);
        }
    
         
        $result = array('error_no'=>0,
            'error_msg'=>'',
            'search_results'=>$search_results            
        );
        echo json_encode($result);
    }
    
    protected function getArticlePublshData($issueId)
    {
        $currentIssue = TIssue::model()->find(array('select'=>array('publshDate'),'condition' => 'id='.$issueId));
        return $currentIssue;
    }
    
    protected function report_error($error_reason)
    {

        $result = array('error_no'=>-1,
            'error_msg'=>$error_reason);
        echo json_encode($result);
    }

    public function actionGetArticleDetail($articleId)
    {
        $article = TArticle::model()->find(array('select'=>array('ID','name','name_en','author','authorIntroduction','summary','summary_en',
            'keyword','keyword_en','query1','visit_num'),'condition' => 'ID='.$articleId));
    
        $attach_file_list = $this->getAttachs($articleId);
        TArticle::model()->visitNumIncrease($articleId);
         
        $result = array('error_no'=>0,
            'name'=>$article->name,
            'name_en'=>$article->name_en,
            'author'=>$article->author,
            'authorIntroduction'=>$article->authorIntroduction,
            'summary'=>$article->summary,
            'summary_en'=>$article->summary_en,
            'keyword'=>$article->keyword,
            'keyword_en'=>$article->keyword_en,
            'query1'=>$article->query1,
            'visit_num'=>$article->visit_num,
            'attach_file_list'=>$attach_file_list);
        echo json_encode($result);
    }

    public function actionSaveArticle()
    {
//        echo "123";return;
        log::getInstance()->warning($_POST['params']);
        $param = json_decode($_POST['params']);
        $articleId = $param->articleId;
        $articleItem = new TArticle();
        if (empty($articleId)) {
            log::getInstance()->warning('create article'. json_encode($param));
        } else {
            log::getInstance()->warning('modify article' . $articleId);
            $articleItem = TIssue::model()->findByPk($articleId);
        }

        $articleItem->issueId = $param->issueId;
        $articleItem->author = $param->newArticleAuthor;
        $articleItem->authorIntroduction = $param->newArticleAuthorIntroduction;
        $articleItem->content = $param->newArticleContent;
        $articleItem->content_en = $param->newArticleContentEn;
        $articleItem->keyword = $param->newArticleKeyWord;
        $articleItem->keyword_en = $param->newArticleKeyWordEn;
        $articleItem->name = $param->newArticleName;
        $articleItem->name_en = $param->newArticleNameEn;
        $articleItem->query1 = $param->newArticleQuery1;
        $articleItem->summary = $param->newArticleSummary;
        $articleItem->summary_en = $param->newArticleSummaryEn;
        $articleItem->viceTitle = $param->newArticleViceTitle;
        $articleItem->fenleihao = $param->newArticlefenleihao;
        $articleItem->createUser = 1;
        $articleItem->source = '';
        $articleItem->url = '';
        $articleItem->publishUrl = '';
        $articleItem->viewCount = 0;
        $articleItem->wordCount = 0;
        $articleItem->grade = 0;
        $articleItem->version = '';
        $articleItem->type = 0;
        $articleItem->status = 0;
        $articleItem->pubFlag = 0;
        $articleItem->creationdate = date("Y-m-d H:i:s");
        $articleItem->modifieddate =  date("Y-m-d H:i:s");
        $articleItem->publishdate = date("Y-m-d H:i:s");
        $articleItem->owner = '';
        $articleItem->wenxianhao = '';
        $articleItem->xueke = 0;
        $articleItem->query2 = '';
        $articleItem->lockedFlag = 0;
        $articleItem->lockedBy = '';
        $articleItem->image = '';
        $articleItem->visit_num = rand(500,1000);

        $saveResult="";
        log::getInstance()->warning('prepare save article' . json_encode($articleItem));
        if (!$articleItem->save()) {
            log::getInstance()->warning('save fail');
            $saveResult = $articleItem->getErrors();
        }

        $result = array('error_no' => 0,
            'error_msg' => $saveResult);

        echo json_encode($result);
    }


    public function actionDeleteArticle($articleId)
    {
        $article = TArticle::model()->findByPk($articleId);
        $deleteResult = $article->delete();
        $result = array('error_no' => 0,
            'error_msg' => '',
            'data' => $deleteResult);
        echo json_encode($result);
    }
    
    protected function getAttachs($articleId)
    {
        $attach_file_list = array();
        $attachFiles = TAttachment::model()->findAll(array('select'=>array('ID','filename','bigFilename'),'condition' => 'articleID='.$articleId));

        foreach ($attachFiles as $item) {
            $attach['ID']=$item->ID;
            $attach['filename']=$item->filename;
            $attach['bigFilename']=$item->bigFilename;//'uploadfile/test.pdf'
            array_push($attach_file_list,$attach);
        }
        return $attach_file_list;
         
    }

    public function actionGetCurrentArticleTotal()
    {
        $periodicalId=1;//科学
        $kexueCurrentIssue = $this->getCurrentIssue($periodicalId);
        if(empty($kexueCurrentIssue))
        {
            $this->report_error('获取当前期刊失败,periodicalId='.$periodicalId);
            return;
        }
        
        $kexuetotal=TArticle::model()->count(array('condition' => 'issueId='.$kexueCurrentIssue->id));
        
        $periodicalId=2;//科技
        $kejiCurrentIssue = $this->getCurrentIssue($periodicalId);
        if(empty($kejiCurrentIssue))
        {
            $this->report_error('获取当前期刊失败,periodicalId='.$periodicalId);
            return;
        }
        $kejitotal=TArticle::model()->count(array('condition' => 'issueId='.$kejiCurrentIssue->id));
        $result = array('error_no'=>0,
            'error_msg'=>'',
            'kexue_current_issueId'=>$kexueCurrentIssue->id,
            'keji_current_issueId'=>$kejiCurrentIssue->id,
            'kexue_total'=>$kexuetotal,
            'keji_total'=>$kejitotal,
        );
        echo json_encode($result);
    }
    
    public function actionGetCurrentArticle($periodicalId,$start,$count)
	{
	    $articalArray = array();
        $currentIssue = $this->getCurrentIssue($periodicalId);
        if(empty($currentIssue))
        {
            $this->report_error('获取当前期刊失败,periodicalId='.$periodicalId);
            return;
        }
        $articalList = $this->getArticalList($currentIssue->id,$start,$count);
         
        foreach ($articalList as $item) {
            $artical['id']=$item->ID;
            $artical['name']=$item->name;
            $artical['issueId']=$item->issueId;
            $artical['author']=$item->author;                    
            $artical['summary']=$item->summary;
            $artical['image']=$item->image;
            //            $artical['image']="img/item".rand(1,4).".png";
            $artical['visitNum']=$item->visit_num;
            array_push($articalArray,$artical);
        }
        
         
        $result = array('error_no'=>0,
            'error_msg'=>'',
            'artical_list'=>$articalArray);
        echo json_encode($result);
	}
	
	protected function getCurrentIssue($periodicalId)
	{
	    $currentIssue = TIssue::model()->find(array('select'=>array('id','name','summary','publshDate'),'condition' => 'periodicalId='.$periodicalId,'order'=>'id DESC','limit'=>"1"));
	    return $currentIssue;
	}
	
	protected function getArticalList($issueId,$start,$count)
	{
	    $articalList = TArticle::model()->findAll(array('select'=>array('ID','issueId','name','author','summary','image','visit_num'),
	                                               'condition' => 'issueId='.$issueId,
                                                   'order'=>'ID ASC',
	                                               'offset'=>$start,
	                                               'limit'=>$count));
	    return $articalList;	    
	}
}