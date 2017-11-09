/**
 * Created by wuzhijun on 13-12-26.
 */

function OnlineBook($scope, $http, $location, NgTableParams) {

    $scope.issue_image = "img/image_miss.png";

    $scope.magazineTypes = [{
        type: 1,
        name: '体育科学'
    }, {
        type: 2,
        name: '中国体育科技'
    }];
    $scope.search_type = "";
    $scope.search_author_name = "";
    $scope.search_author_company = "";
    $scope.search_name = "";
    $scope.search_summary = "";
    $scope.search_keywords = "";
    $scope.search_pacs = "";


    var issueId = $location.search().issueId;
    if (typeof (issueId) == 'undefined') {
        alert('期刊编号不存在');
        return;
    }
    $scope.issueId = issueId;

    function initdata() {
        var url = "index.php?r=Issue/getIssueById&issueId=" + issueId;
        $http.get(url + "&t=" + (new Date()).getTime()).success(function (data) {
            $scope.issue_image = data.issue_image;

            $scope.issue_articles = new NgTableParams({
                count: 8
            }, {
                dataset: data.issue_articles
            });

            //$scope.issue_articles = data.issue_articles;
            $scope.issue_zb = data.issue_zb;
            $scope.issue_fzb = data.issue_fzb;
            $scope.issue_bw = data.issue_bw;
            $scope.issue_summary = data.issue_description;

            $('#summernote_issue_summary').summernote('code', data.issue_summary);
            $('#summernote_issue_summary').summernote('destroy');
            $('#issue_summary').summernote('code', data.issue_description);
            $('#issue_summary').summernote('destroy');
        });
    }

    $scope.open_onlinebook_view = function (articleId) {
        if (articleId == "undefined") {
            return;
        }

        window.location.href = "#/onlinebook_view?articleId=" + articleId + "&issueId=" + $scope.issueId;
    };

    $scope.commit_search = function () {
        window.location.href = "#/senior_search?type=" + $scope.search_type +
            "&author_name=" + $scope.search_author_name + "&author_company=" + $scope.search_author_company +
            "&name=" + $scope.search_name + "&summary=" + $scope.search_summary +
            "&keywords=" + $scope.search_keywords + "&pacs=" + $scope.search_pacs;
    }

    $scope.$on('$viewContentLoaded', function () {
        initdata();
    });
}
