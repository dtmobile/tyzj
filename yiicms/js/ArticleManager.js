/**
 * Created by wuzhijun on 13-12-26.
 */

function ArticleManager($scope, $http, NgTableParams, FileUploader) {





    function initValue() {
        $scope.models = {
            selectedPeriodicalId: '',
            periodicalTypes: [{id: 1, name: "体育科学"}, {id: 2, name: "中国体育科技"}],
            issueList: [],
            selectedIssueId: 0,

            selectNewPreiodId: 0,
            selectedNewYear: '',
            yearList: ["2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025"],


            selectedNewMonth: '',
            monthList: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"],


            issueDetailMode:'create',
            newSummary: 'testSummary',
            newDescription: 'testDesciption',
            newPublshDate: '2017-11-15 00:00:00',
            newSummary_en: 'test_summary_en',

            newArticleParentIssueName: '',
            newArticleName: '1',
            newArticleNameEn: '2',
            newArticleViceTitle: '3',
            newArticleKeyWord: '4',
            newArticleKeyWordEn: '5',
            newArticleSummary: '6',
            newArticleSummaryEn: '7',
            newArticleContent: '8',
            newArticleAuthor: '9',
            newArticleAuthorIntroduction: '10',
            newArticlefenleihao: '11',
            newArticleQuery1: '12',
            newArticleContentEn: '13',
            article_list:new NgTableParams(),
        };
    }
    initValue();

    function getArticleList() {
        if($scope.models.selectedIssueId==0)
        {
            $scope.models.article_list = new NgTableParams();
            return;
        }
        var url = "index.php?r=Issue/getIssueById&issueId="+$scope.models.selectedIssueId;
        $http.get(url).success(function (data) {
            // console.log(data);
            $scope.models.article_list = new NgTableParams({
                count: 100, sorting: {
                    createDate: 'desc'     // initial sorting
                }
            }, {dataset: data.issue_articles});
        });
    }

    var uploader = $scope.uploader = new FileUploader({
        url: 'index.php?r=issue/saveIssue',
        queueLimit: 1,     //文件个数
    });


    $scope.deleteIssueClick = function () {
        if (IsNull($scope.models.selectedIssueId)) {
            Confirm.show('无法删除期刊', '请先选中期刊和期数');
            return;
        }
        var issueName = getSelectedIssueName();
        if (IsNull(issueName)) {
            Confirm.show('无法删除期刊', '请先选中期刊和期数');
            return;
        }

        Confirm.show('删除期刊', '确定要删除期刊\n' + issueName + "?", {
            '删除': {
                'primary': true,
                'callback': function () {
                    var url = "index.php?r=Issue/DeleteIssue&issueId=" + $scope.models.selectedIssueId;
                    $http.get(url).success(function (data) {
                        if (data.error_no != 0 || !data.data) {
                            Confirm.show('删除期刊', issueName+'删除失败 ' + data.error_msg);
                            return;
                        }
                        Confirm.show('删除期刊', issueName+ '删除成功');
                        $scope.models.selectedIssueId=0;
                        getIssueList();
                        getArticleList();
                    });
                }
            }
        });
    }

    function getIssueList() {
        if (IsNull($scope.models.selectedPeriodicalId)) {
            $scope.models.issueList = [];
            return;
        }
        var url = "index.php?r=Issue/getIssuesByPeriodicalId&periodicalId=" + $scope.models.selectedPeriodicalId + "&count=5000&page=1";
        $http.get(url).success(function (data) {
            if (data.error_no != 0) {
                Confirm.show('获取期数列表失败', '失败原因' + data.error_msg);
                return;
            }
            // console.log(data);
            $scope.models.issueList = data.issues;
            $scope.models.selectedIssueId=0;
        });
    }

    $scope.issue_selected_change = function () {
        if (typeof($scope.models.selectedPeriodicalId) == "undefined") {
            $scope.models.issueList = [];
            return;
        }

        getArticleList();
    }
    $scope.period_selected_change = function () {
        getIssueList();
    }

    $scope.saveNewsIssue = function () {

        if (IsNull($scope.models.selectNewPreiodId)) {
            Confirm.show('请选择期刊类型', '缺少期刊类型');
            return;
        }

        if (IsNull($scope.models.selectedNewYear)) {
            Confirm.show('请选择年份', '缺少年份');
            return;
        }

        if (IsNull($scope.models.selectedNewMonth)) {
            Confirm.show('请选择期数', '缺少期数');
            return;
        }

        if (IsNull($scope.models.newSummary) || IsNull($scope.models.newDescription) || IsNull($scope.models.newPublshDate) || IsNull($scope.models.newSummary_en)) {
            Confirm.show('请输入参数', '缺少参数');
            return;
        }


        var newIssueName = $scope.models.selectedNewYear + "年第" + $scope.models.selectedNewMonth + "期";
        var url = "index.php?r=Issue/issueIsExist&periodId=" + $scope.models.selectNewPreiodId + "&name=" + newIssueName;
        $http.get(url).success(function (data) {
            // console.log(data);
            if (data.error_no != 0) {
                Confirm.show('获取期数列表失败', '失败原因' + data.error_msg);
                return;
            }

            if (data.isExist) {
                Confirm.show('添加新期刊失败', newIssueName + "已经存在");
                return;
            }

            var result = uploader.uploadAll();
        });

    }

    $scope.$watch('$viewContentLoaded', function () {
        getArticleList();
    });

    uploader.onBeforeUploadItem = function (item) {
        formData = [{
            id: 0,
            newPreiodId: $scope.models.selectNewPreiodId,
            newName: $scope.models.selectedNewYear + "年第" + $scope.models.selectedNewMonth + "期",
            newSummary: $scope.models.newSummary,
            newDescription: $scope.models.newDescription,
            newPublshDate: $scope.models.newPublshDate,
            newSummary_en: $scope.models.newSummary_en
        }];
        Array.prototype.push.apply(item.formData, formData);
    };

    uploader.onSuccessItem = function (fileItem, response, status, headers) {

        if (response.error_no != 0) {
            console.log(response.error_msg);
            Confirm.show('保存失败', response.error_msg);
            uploader.clearQueue();
        } else {
            Confirm.show('保存结果', '保存成功');
            uploader.clearQueue();
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


    function getSelectedIssue() {
        var selectIssue=null;
        angular.forEach($scope.models.issueList, function (issue) {
            if (issue.id == $scope.models.selectedIssueId) {
                selectIssue = issue;
            }
        });
        return selectIssue;
    }

    function getSelectedIssueName() {
        var parentIssueName = "";
        if ($scope.models.selectedPeriodicalId == 1) {
            parentIssueName += "体育科学-";
        } else if ($scope.models.selectedPeriodicalId == 2) {
            parentIssueName += "中国体育科技-";
        } else {
            return "";
        }

        angular.forEach($scope.models.issueList, function (issue) {
            if (issue.id == $scope.models.selectedIssueId) {
                parentIssueName += issue.name;
            }
        });
        return parentIssueName;
    }

    $scope.showNewArticleDialog = function () {

        var parentIssueName = getSelectedIssueName();
        if(IsNull(parentIssueName))
        {
            Confirm.show("无法编辑", '请先选中新文章所属的期刊');
            return;
        }

        $scope.models.newArticleParentIssueName = parentIssueName;
    };


    $scope.modifyIssueClick = function () {

        $scope.models.issueDetailMode="modify";
        var selectIssue = getSelectedIssue();
        if(IsNull(selectIssue))
        {
            Confirm.show("无法编辑期刊", '请先选中要编辑的期刊');
            return;
        }

        $scope.models.selectNewPreiodId =  $scope.models.selectedPeriodicalId;
        $scope.models.newSummary=selectIssue.summary;
        $scope.models.newDescription=selectIssue.desciption;
        $scope.models.newPublshDate=selectIssue.publshDate;
        $scope.models.newSummary_en=selectIssue.summary_en;

        $scope.models.selectedNewYear = selectIssue.name.substr(0,4);

        month = selectIssue.name.substr(6);
        monthEndPositon = month.indexOf("期");

        $scope.models.selectedNewMonth= month.substr(0,monthEndPositon);

    };

    $scope.saveArticleContent = function () {

        if(IsNull($scope.models.selectedIssueId)||
            IsNull($scope.models.newArticleName)||
            IsNull($scope.models.newArticleNameEn)||
            IsNull($scope.models.newArticleViceTitle)||
            IsNull($scope.models.newArticleKeyWord)||
            IsNull($scope.models.newArticleKeyWordEn)||
            IsNull( $scope.models.newArticleSummary)||
            IsNull($scope.models.newArticleSummaryEn)||
            IsNull($scope.models.newArticleContent)||
            IsNull($scope.models.newArticleAuthor)||
            IsNull($scope.models.newArticleAuthorIntroduction)||
            IsNull($scope.models.newArticlefenleihao)||
            IsNull($scope.models.newArticleQuery1)||
            IsNull($scope.models.newArticleContentEn))
        {
            Confirm.show('无法保存', '参数不可以为空');
            return;
        }

        params = new Object();
        params.articleId = 0;
        params.issueId = $scope.models.selectedIssueId;
        params.newArticleName = $scope.models.newArticleName;
        params.newArticleNameEn = $scope.models.newArticleNameEn;
        params.newArticleViceTitle = $scope.models.newArticleViceTitle;
        params.newArticleKeyWord = $scope.models.newArticleKeyWord;
        params.newArticleKeyWordEn = $scope.models.newArticleKeyWordEn;
        params.newArticleSummary = $scope.models.newArticleSummary;
        params.newArticleSummaryEn = $scope.models.newArticleSummaryEn;
        params.newArticleContent = $scope.models.newArticleContent;
        params.newArticleAuthor = $scope.models.newArticleAuthor;
        params.newArticleAuthorIntroduction = $scope.models.newArticleAuthorIntroduction;
        params.newArticlefenleihao = $scope.models.newArticlefenleihao;
        params.newArticleQuery1 = $scope.models.newArticleQuery1;
        params.newArticleContentEn = $scope.models.newArticleContentEn;
        var url='index.php?r=article/saveArticle';
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        // var params = "params=" + encodeURIComponent(params);
        var params = "params=" + JSON.stringify(params);
        $http.post(url, params).success(function (data, header, config, status) {
        // $http.post(url, ).success(function (data, header, config, status) {
        //     console.log(data);
            if (data.error_no != 0) {
                Confirm.show('保存文章', '保存失败'+data.error_msg);
            }else {
                Confirm.show('保存文章', '保存成功');
                getArticleList();
            }
        }).error(function (data, header, config, status) {
            //处理响应失败
            Confirm.show('响应失败', data);
            console.log("响应失败" + data);
        });
    }

    $scope.delete_article = function (article) {

        if(IsNull(article) || IsNull(article.ID))
        {
            return;
        }
        Confirm.show('删除文章', '确定要删除文章\n' + article.name + "?", {
            '删除': {
                'primary': true,
                'callback': function () {

                    var url = "index.php?r=article/deleteArticle&articleId=" + article.ID;
                    $http.get(url).success(function (data) {
                        // console.log(data);
                        if (data.error_no != 0 || !data.data) {
                            Confirm.show('删除文章', '删除失败' + data.error_msg);
                            return;
                        }
                        Confirm.show('删除文章', '删除成功');
                        getArticleList();
                    });
                }
            }
        });
    };
    $scope.modify_article = function () {

    }


}
