/**
 * Created by wuzhijun on 13-12-26.
 */

function NewsManager($scope, $http, NgTableParams, FileUploader) {

    var uploader = $scope.uploader = new FileUploader({
        url: 'index.php?r=News/SaveNewsWithAttach',
        queueLimit: 1,     //文件个数
    });

    function initValue() {
        $scope.newsDetail = {
            mode: "create",
            imgReplaceShow: true,
            id: 0,
            title: '',
            viceTitle: '',
            content: '',
            title_en: '',
            viceTitle_en: '',
            Content_en: '',
            image: '',
            createDate: '',
        };
    }

    initValue();

    $scope.news_list = new NgTableParams();

    function getNewsList() {
        var url = "index.php?r=News/getAllNews";
        $http.get(url).success(function (data) {
            // console.log(data.all_news);
            $scope.news_list = new NgTableParams({
                count: 100, sorting: {
                    createDate: 'desc'     // initial sorting
                }
            }, {dataset: data.all_news});
        });
    }

    $scope.$watch('$viewContentLoaded', function () {
        getNewsList();
    });

    uploader.onBeforeUploadItem = function (item) {
        formData = [{
            id: $scope.newsDetail.id,
            title: $scope.newsDetail.title,
            viceTitle: $scope.newsDetail.viceTitle,
            content: $scope.newsDetail.content,
            title_en: $scope.newsDetail.title_en,
            vicetitle_en: $scope.newsDetail.viceTitle_en,
            content_en: $scope.newsDetail.Content_en
        }];
        Array.prototype.push.apply(item.formData, formData);
    };

    uploader.onSuccessItem = function (fileItem, response, status, headers) {
        if (response.error_no != 0) {
            console.log(response.error_msg);
            Confirm.show('保存失败', response.error_msg);
            uploader.clearQueue();
        } else {
            Confirm.show('保存结果', '成功');
            uploader.clearQueue();
            getNewsList();
        }
    };
    uploader.onErrorItem = function (fileItem, response, status, headers) {
        console.log(response);
        uploader.clearQueue();
        Confirm.show('保存失败', response);
        console.log(fileItem);
        console.log(response);
        console.log(status);
        console.log(headers);
    };

    function postNewsDetailNoAttach() {
        var url = 'index.php?r=News/saveNewsNoAttach';
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        var params = new Object();
        params.id = $scope.newsDetail.id;
        params.title = $scope.newsDetail.title;
        params.viceTitle = $scope.newsDetail.viceTitle;
        params.content = $scope.newsDetail.content;
        params.title_en = $scope.newsDetail.title_en;
        params.vicetitle_en = $scope.newsDetail.viceTitle_en;
        params.content_en = $scope.newsDetail.Content_en;

        var params = "params=" + JSON.stringify(params);
        $http.post(url, params).success(function (data, header, config, status) {
            if (data.error_no != 0) {
                Confirm.show('保存文章', '保存失败' + data.error_msg);
            } else {
                Confirm.show('保存文章', '保存成功');
                getNewsList();
            }
        }).error(function (data, header, config, status) {
            //处理响应失败
            Confirm.show('响应失败', data);
            console.log("响应失败" + data);
        });
    }

    $scope.saveNewsDetail = function () {
        // console.info('onBeforeUploadItem', item);
        if ($scope.newsDetail.title == '' || $scope.newsDetailviceTitle == '' || $scope.newsDetail.content == '' || $scope.newsDetail.en_title == '' || $scope.newsDetail.en_viceTitle == '' || $scope.newsDetail.en_content == '') {
            Confirm.show('对不起', '参数不可以为空');
            return;
        }

        if (uploader.getNotUploadedItems().length == 0) {
            postNewsDetailNoAttach();
        } else {
            uploader.uploadAll();
        }
    }

    $scope.delete_news = function (news) {

        Confirm.show('删除新闻', '确定要删除新闻\n' + news.title + "?", {
            '删除': {
                'primary': true,
                'callback': function () {
                    var url = "index.php?r=News/deleteNews&newsid=" + news.id;
                    $http.get(url).success(function (data) {
                        if (data.error_no != 0 || !data.data) {
                            Confirm.show('删除新闻', '删除失败' + data.error_msg);
                            return;
                        }
                        Confirm.show('删除新闻', '删除成功');
                        getNewsList();
                    });
                }
            }
        });
    };


    $scope.create_news = function () {
        initValue();
    };

    $scope.modify_news = function (news) {
        // console.log(news);
        $scope.newsDetail.mode = "modify";
        $scope.newsDetail.imgReplaceShow = false;
        $scope.newsDetail.id = news.id;
        $scope.newsDetail.title = news.title;
        $scope.newsDetail.viceTitle = news.viceTitle;
        $scope.newsDetail.content = news.content;
        $scope.newsDetail.title_en = news.title_en;
        $scope.newsDetail.viceTitle_en = news.viceTitle_en;
        $scope.newsDetail.Content_en = news.Content_en;
        $scope.newsDetail.image = news.image;
        $scope.newsDetail.createDate = news.createDate;
    };


}
