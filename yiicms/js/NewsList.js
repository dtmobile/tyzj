/**
 * Created by wuzhijun on 13-12-26.
 */

function NewsList($scope, $location, $http, NgTableParams) {
    // $scope.news_list = new Array();


    function getNewsList() {
        var url = "index.php?r=News/getAllNews";
        $http.get(url).success(function (data) {
            $scope.news_list = new NgTableParams({
                count: 100,
                sorting: {
                    createDate: 'desc'     // initial sorting
                }
            }, {dataset: data.all_news});
        });
    }

    getNewsList();

    $scope.open_news_view = function (newsid) {
        if (newsid == "undefined") {
            return;
        }

        window.location.href = "#/news_view?newsid=" + newsid;
    }

}
