<?php
require_once 'CommonFunction.php';
require_once 'log.php';

class NewsController extends Controller
{
    private $adminName = "tyadmin";
    protected $topN = 7;

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('getTopNews', 'getNewsById', 'getAllNews', 'saveNewsWithAttach','saveNewsNoAttach','deleteNews'),
                'users' => array('*'),
            ),
        );
    }


    private function saveNews($newsId, $originAttachFileName, $title, $viceTitle, $content, $title_en, $viceTitle_en, $content_en)
    {
//        if (empty($_FILES)) {
//            return "没有图像文件";
//        }
        if (empty($title) || empty($viceTitle) || empty($content) || empty($title_en) || empty($viceTitle_en) || empty($content_en)) {
            return "参数不能为空{$title} {$viceTitle} {$content} {$title_en} {$viceTitle_en} {$content_en}";
        }

        $newsItem = new TNews();
        if (empty($newsId)) {
            log::getInstance()->warning('create news' . json_encode($_POST));
        } else {
            log::getInstance()->warning('modify news' . $newsId);
            $newsItem = TNews::model()->findByPk($newsId);
        }

        $imgPath = 'uploadfile/news/' . date('Ymd') . '/';
        $imageFullPath = Yii::app()->basePath . '/../' . $imgPath;
        if (!is_dir($imageFullPath)) {
            $res = mkdir(iconv("UTF-8", "GBK", $imageFullPath), 0777, true);
            if (!$res) {
                return "创建{$imageFullPath}失败";
            }
        }
        if (!empty($originAttachFileName)) {
            $filename = iconv("UTF-8", "gb2312", $imageFullPath . $originAttachFileName);
//        log::getInstance()->warning('fileName: ' . $filename);
            if (file_exists($filename)) {
                log::getInstance()->warning('file already exist:' . $filename);
//            return "该文件已存在" . $originFileName;
            } else {
                //上传
                log::getInstance()->warning('file uploading:' . $filename);
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
                    return $originAttachFileName . "file uploaded fail";
                }
            }

            if(!$this->cutImageSize(iconv("UTF-8", "gb2312", $imgPath . $originAttachFileName)))
            {
                return $originAttachFileName . "file cut fail";
            }
            $newsItem->image = $imgPath . $originAttachFileName;
        }else{
            if(empty($newsId))
            {
                $newsItem->image = '';
            }
        }

        $newsItem->createUser = 1;
        $newsItem->title = $title;
        $newsItem->viceTitle = $viceTitle;
        $newsItem->Content = $content;
        $newsItem->createDate = date("Y-m-d H:i:s");
        $newsItem->title_en = $title_en;
        $newsItem->viceTitle_en = $viceTitle_en;
        $newsItem->Content_en = $content_en;
        if (!$newsItem->save()) {
            log::getInstance()->warning('save fail');
            return $newsItem->getErrors();
        }
        return "";
//        return "{$title}  {$viceTitle}  {$content}  {$filename}";
    }


    public function actionSaveNewsWithAttach()
    {
        //            log::getInstance()->warning('files: '.json_encode($_FILES));
        //            log::getInstance()->warning('POST: '.json_encode($_POST));
        $newsId = $_POST['id'];
        $attachFileName = $_FILES['file']['name'];
        $title = $_POST['title'];
        $viceTitle = $_POST['viceTitle'];
        $content = $_POST['content'];
        $title_en = $_POST['title_en'];
        $viceTitle_en = $_POST['vicetitle_en'];
        $content_en = $_POST['content_en'];
        $saveResult = $this->saveNews($newsId, $attachFileName, $title, $viceTitle, $content, $title_en, $viceTitle_en, $content_en);

        if (empty($saveResult)) {
            $result = array('error_no' => 0,
                'error_msg' => '');
        } else {
            $result = array('error_no' => -1,
                'error_msg' => $saveResult);
        }

        echo json_encode($result);

    }

    public function actionsaveNewsNoAttach()
    {
        //            log::getInstance()->warning('files: '.json_encode($_FILES));
//        echo "123";return;
        log::getInstance()->warning($_POST['params']);
        $param = json_decode($_POST['params']);
        $newsId = $param->id;
        $title = $param->title;
        $viceTitle = $param->viceTitle;
        $content = $param->content;
        $title_en = $param->title_en;
        $viceTitle_en = $param->vicetitle_en;
        $content_en = $param->content_en;

        $saveResult = $this->saveNews($newsId, null, $title, $viceTitle, $content, $title_en, $viceTitle_en, $content_en);

        if (empty($saveResult)) {
            $result = array('error_no' => 0,
                'error_msg' => '');
        } else {
            $result = array('error_no' => -1,
                'error_msg' => $saveResult);
        }

        echo json_encode($result);
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

        $width = 288;
        $height = 168;
        $src = imagecreatefromstring(file_get_contents($imgPath));
        $des = imagecreatetruecolor($width, $height);
        imagecopyresampled($des, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
        imagejpeg($des, $imgPath);
        return true;
    }

    public function actionGetAllNews()
    {
        $allNnews = array();
        $topNews = TNews::model()->findAll();

        foreach ($topNews as $item) {
            $news['id'] = $item->id;
            $news['image'] = $item->image;
            $news['title'] = $item->title;
            $news['createDate'] = date('Y-m-d', strtotime($item->createDate));
            $news['viceTitle'] = $item->viceTitle;
            $news['content'] = $item->Content;

            $news['title_en'] = $item->title_en;
            $news['viceTitle_en'] = $item->viceTitle_en;
            $news['Content_en'] = $item->Content_en;
            array_push($allNnews, $news);
        }


        $result = array('error_no' => 0,
            'error_msg' => '',
            'all_news' => $allNnews);
        echo json_encode($result);
    }

    public function actionDeleteNews($newsid)
    {
        $news = TNews::model()->findByPk($newsid);
//        echo json_encode($user);return;
        $deleteResult = $news->delete();
        $result = array('error_no' => 0,
            'error_msg' => '',
            'data' => $deleteResult);
        echo json_encode($result);
    }


    public function actionGetTopNews()
    {

        $topNnews = array();
        $topNews = TNews::model()->findAll(array('select' => array('id', 'title', 'createDate'), 'order' => 'createDate DESC', 'limit' => "$this->topN"));

        foreach ($topNews as $item) {
            $news['id'] = $item->id;
            $news['title'] = $item->title;
            $news['createDate'] = date('Y-m-d', strtotime($item->createDate));
            array_push($topNnews, $news);
        }


        $result = array('error_no' => 0,
            'error_msg' => '',
            'top_news' => $topNnews);
        echo json_encode($result);
    }

    public function actionGetNewsById($newsid)
    {

        $newsRecord = TNews::model()->find('id=:id', array(':id' => $newsid));
        if (NULL == $newsRecord) {
            $result = array('error_no' => 1,
                'error_msg' => '无法找到记录,newsid=' . $newsid,
                'top_news' => null);
            echo json_encode($result);
            return;
        }

        $result = array('error_no' => 0,
            'error_msg' => '',
            'title' => $newsRecord->title,
            'createDate' => $newsRecord->createDate,
            'image' => $newsRecord->image,
            'content' => $newsRecord->Content);
        echo json_encode($result);
    }


}