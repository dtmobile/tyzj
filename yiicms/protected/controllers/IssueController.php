<?php

require_once 'CommonFunction.php';
require_once 'log.php';

class IssueController extends Controller
{
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('getIssues', 'getIssueById', 'GetIssuesByPeriodicalId', 'SaveIssue', 'issueIsExist','getTotalIssueCount','deleteIssue'),
                'users' => array('*'),
            ),
        );
    }

    public function actiongetTotalIssueCount()
    {
        $kexueCount = TIssue::model()->count(array('condition' => 'periodicalId=1'));
        $kejiCount = TIssue::model()->count(array('condition' => 'periodicalId=2'));
        $result = array('error_no' => 0,
            'error_msg' => '',
            'kexueCount' => $kexueCount,
            'kejiCount' => $kejiCount);
        echo json_encode($result);
    }


    public function actionissueIsExist($periodId, $name)
    {
        $issueArray = $this->getIssuesBuPeriodicalId($periodId, 5000, 1);
        $isExist = false;
        foreach ($issueArray as $item) {
            if($item['name'] == $name)
            {
                $isExist=true;
                break;
            }
        }
        $result = array('error_no' => 0,
            'error_msg' => '',
            'isExist' => $isExist);
        echo json_encode($result);
    }

    public function actionSaveIssue()
    {
        //            log::getInstance()->warning('files: '.json_encode($_FILES));
        //            log::getInstance()->warning('POST: '.json_encode($_POST));
        $tempPath = $_FILES['file']['tmp_name'];
        $issueId = $_POST['id'];

        $newPreiodId = $_POST['newPreiodId'];
        $newName = $_POST['newName'];
        $newSummary = $_POST['newSummary'];
        $newDescription = $_POST['newDescription'];
        $newPublshDate = $_POST['newPublshDate'];
        $newSummary_en = $_POST['newSummary_en'];
        $saveResult = $this->saveIssue($issueId, $tempPath, $newPreiodId, $newName, $newSummary, $newDescription, $newPublshDate, $newSummary_en);

        if (empty($saveResult)) {
            $result = array('error_no' => 0,
                'error_msg' => '');
        } else {
            $result = array('error_no' => -1,
                'error_msg' => $saveResult);
        }

        echo json_encode($result);

    }

    private function saveIssue($issueId, $tempPath, $newPreiodId, $newName, $newSummary, $newDescription, $newPublshDate, $newSummary_en)
    {
//        if (empty($_FILES)) {
//            return "没有图像文件";
//        }
        if (empty($newPreiodId) || empty($newName) || empty($newSummary) || empty($newDescription) || empty($newPublshDate) || empty($newSummary_en)) {
            return "参数不能为空{$newPreiodId} {$newName} {$newSummary} {$newDescription} {$newPublshDate} {$newSummary_en}";
        }

        $issueItem = new TIssue();
        if (empty($issueId)) {
            log::getInstance()->warning('create issue' . json_encode($_POST));
        } else {
            log::getInstance()->warning('modify issue' . $issueId);
            $issueItem = TIssue::model()->findByPk($issueId);
        }

        $imgPath = 'uploadfile/issue/';
        $imageFullPath = Yii::app()->basePath . '/../' . $imgPath;
        if (!is_dir($imageFullPath)) {
            $res = mkdir(iconv("UTF-8", "GBK", $imageFullPath), 0777, true);
            if (!$res) {
                return "创建{$imageFullPath}失败";
            }
        }
        $originFileName = $_FILES['file']['name'];
        $newFileName = date("Y-m-d-H-i-s"). $originFileName;

        if (!empty($originFileName)) {
            $filename = iconv("UTF-8", "gb2312", $imageFullPath .$newFileName);
//        log::getInstance()->warning('fileName: ' . $filename);
            if (file_exists($filename)) {
                log::getInstance()->warning('file already exist:' . $filename);
//            return "该文件已存在" . $originFileName;
            } else {
                //上传
                log::getInstance()->warning('file uploading:' . $filename);
                if (!move_uploaded_file($tempPath, $filename)) {
                    return $originFileName . "file uploaded fail";
                }
            }

            $issueItem->picPath = $imgPath .$newFileName;
            if (!$this->cutImageSize(iconv("UTF-8", "gb2312", $issueItem->picPath))) {
                return $originFileName . "file cut fail";
            }

        }

        $issueItem->createUser = 1;
        $issueItem->periodicalId = $newPreiodId;
        $issueItem->name = $newName;
        $issueItem->summary = $newSummary;
        $issueItem->createDate = date("Y-m-d H:i:s");
        $issueItem->desciption = $newDescription;
        $issueItem->publshDate = $newPublshDate;
        $issueItem->summary_en = $newSummary_en;
        log::getInstance()->warning('prepare save' . json_encode($issueItem));
        if (!$issueItem->save()) {
            log::getInstance()->warning('save fail');
            return $issueItem->getErrors();
        }
        return "";
//        return "{$title}  {$viceTitle}  {$content}  {$filename}";
    }

    private function cutImageSize($imgPath)
    {
        // $imgPath = 'uploadfile/news/ooo.jpg';
        // $imgNewPath = 'uploadfile/news/ooo.jpg';
        Log::getInstance()->warning("prepare cutImageSize" . $imgPath);
        if (!file_exists($imgPath)) {
            Log::getInstance()->warning("file not exists:" . $imgPath);
            return false;
        }

        $width = 250;
        $height = 200;
        $src = imagecreatefromstring(file_get_contents($imgPath));
        $des = imagecreatetruecolor($width, $height);
        imagecopyresampled($des, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
        imagejpeg($des, $imgPath);
        return true;
    }

    private function getIssuesBuPeriodicalId($periodicalId, $count, $page)
    {
        $offset = ($page - 1) * $count;
        $limit = $count;
        $issueArray = array();
        $results = TIssue::model()->findAll(array('select' => array('id', 'name', 'publshDate', 'picPath', 'desciption','summary','summary_en'), 'condition' => 'periodicalId=' . $periodicalId, 'order' => 'publshDate DESC', 'offset' => $offset, 'limit' => $limit));

        foreach ($results as $item) {
            $issue['id'] = $item->id;
            $issue['name'] = $item->name;
            $date = date_create($item->publshDate);
            $issue['publshDate'] = date_format($date, 'Y-m-d');//$item->publshDate;
            $issue['picPath'] = $item->picPath;
            $issue['desciption'] = $item->desciption;
            $issue['summary'] = $item->summary;
            $issue['summary_en'] = $item->summary_en;
            array_push($issueArray, $issue);
        }
        return $issueArray;
    }

    public function actionGetIssuesByPeriodicalId($periodicalId, $count, $page)
    {
        $issueArray = $this->getIssuesBuPeriodicalId($periodicalId, $count, $page);

        $result = array('error_no' => 0,
            'error_msg' => '',
            'issues' => $issueArray);
        echo json_encode($result);
    }

    public function actionGetIssueById($issueId)
    {

        $issue = TIssue::model()->find(array('select' => array('id', 'periodicalId', 'name', 'summary', 'picPath', 'desciption'), 'condition' => 'id=' . $issueId));


        if (NULL == $issue) {
            $result = array('error_no' => 1,
                'error_msg' => '无法找到记录,newsid=' . $issueId);
            echo json_encode($result);
            return;
        }

        $periodicalInfo = $this->getPeriodicalInfo($issue->periodicalId);


        $articleArray = array();
        $articles = $this->getArticleByIssueId($issueId);


        foreach ($articles as $item) {
            $artical['ID'] = $item->ID;
            $artical['name'] = $item->name;
            $artical['author'] = $item->author;
            array_push($articleArray, $artical);
        }

        //$articleArray = array_chunk($articleArray,5);

        // $scope.news_list = new NgTableParams({}, { dataset: data.all_news});


        $result = array('error_no' => 0,
            'error_msg' => '',

            'periodical_name' => $periodicalInfo['periodical_name'],
            'periodical_viceTitle' => $periodicalInfo['periodical_viceTitle'],

            'issue_zb' => $periodicalInfo['zb'],
            'issue_fzb' => $periodicalInfo['fzb'],
            'issue_bw' => $periodicalInfo['bw'],

            'issueId' => $issue->id,
            'issue_name' => $issue->name,
//             'issue_image'=>$issue->picPath,
            'issue_image' => "img/book" . $issue->periodicalId . ".png",
            'issue_summary' => $issue->summary,
            'issue_description' => $issue->desciption,
            'issue_articles' => $articleArray,
        );

        echo json_encode($result);
    }


    /***
     * 按照顺序显示科学和科技两种杂志的最新两期
     * @param unknown $start
     * @param unknown $count
     */
    public function actionGetIssues($start, $count)
    {
        $showNum = 3;
        $periodicalId = 2;//科技
        $kejiList = TIssue::model()->findAll(array('select' => array('id', 'name', 'picPath', 'summary', 'desciption'),
            'condition' => 'periodicalId=' . $periodicalId,
            'order' => 'id desc',
            'offset' => 0,
            'limit' => $showNum));
        $periodicalId = 1;//科学
        $kexueList = TIssue::model()->findAll(array('select' => array('id', 'name', 'picPath', 'summary', 'desciption'),
            'condition' => 'periodicalId=' . $periodicalId,
            'order' => 'id desc',
            'offset' => 0,
            'limit' => $showNum));
        $kejiListArray = array();
        $kexueListArray = array();

        log::getInstance()->warning('files: $kejiList count = ' . count($kejiList));
        log::getInstance()->warning('files: $kexueList count = ' . count($kexueList));

        if(count($kejiList) >= 3 && count($kexueList) >= 3)
        {
          foreach ($kexueList as $item)
          {
            $temp['id'] = $item->id;
            $temp['name'] = $item->name;
            $temp['summary'] =$item->summary;
            $temp['image'] = "img/tiyukexue.png";//$kejiList[0]->picPath;
            $temp['desciption'] = $item->desciption;
            $articleArray = array();
            $articles = $this->getArticleByIssueId($item->id);
            foreach ($articles as $key => $value) {
               // log::getInstance()->warning('$articleArray ' . 'key = ' . $key . 'value = ' .  $value->ID . $value->name);
               $article['id'] = $value->ID;
               $article['name'] = $value->name;
               array_push($articleArray, $article);
            }
            $temp['articles'] = $articleArray;
            array_push($kexueListArray, $temp);
          }

          foreach ($kejiList as $key => $item)
          {
            $temp['id'] = $item->id;
            $temp['name'] = $item->name;
            $temp['summary'] =$item->summary;
            $temp['image'] = "img/tiyukeji.png";//$kejiList[0]->picPath;
            $temp['desciption'] = $item->desciption;
            $articleArray = array();
            $articles = $this->getArticleByIssueId($item->id);
            foreach ($articles as $key => $value) {
               // log::getInstance()->warning('$articleArray ' . 'key = ' . $key . 'value = ' .  $value->ID . $value->name);
               $article['id'] = $value->ID;
               $article['name'] = $value->name;
               array_push($articleArray, $article);
            }
            $temp['articles'] = $articleArray;
            array_push($kejiListArray, $temp);
          }
        }

        $result = array('error_no' => 0,
            'error_msg' => '',
            'kexueList' => $kexueListArray,
            'kejiList' => $kejiListArray);
        echo json_encode($result);
    }


    public function getPeriodicalInfo($periodical_id)
    {
        $result = TExpert::model()->findAll(array('select' => array('name', 'job'), 'condition' => 'periodical_id=' . $periodical_id));
        $zb = array();
        $fzb = array();
        $bw = array();
        foreach ($result as $item) {
            if ($item->job == 1) {
                array_push($zb, $item->name);
            } else if ($item->job == 2) {
                array_push($fzb, $item->name);
            } else if ($item->job == 3) {
                array_push($bw, $item->name);
            }
        }

        $periodical = TPeriodical::model()->find(array('select' => array('name', 'viceTitle'), 'condition' => 'ID=' . $periodical_id));

        $result = array('error_no' => 0,
            'error_msg' => '',
            'periodical_name' => $periodical->name,
            'periodical_viceTitle' => $periodical->viceTitle,
            'zb' => $zb,
            'fzb' => $fzb,
            'bw' => $bw
        );
        return $result;
    }

    public function getArticleByIssueId($issueId)
    {
        $articalList = TArticle::model()->findAll(array('select' => array('ID', 'name', 'author'),
            'condition' => 'issueId=' . $issueId,
            'order' => 'ID ASC'));
        return $articalList;
    }

    public function actionDeleteIssue($issueId)
    {
        $article = TIssue::model()->findByPk($issueId);
        $deleteResult = $article->delete();
        $result = array('error_no' => 0,
            'error_msg' => '',
            'data' => $deleteResult);
        echo json_encode($result);
    }
}