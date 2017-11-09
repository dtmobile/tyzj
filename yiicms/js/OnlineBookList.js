/**
 * Created by wuzhijun on 13-12-26.
 */

function OnLineBookList($scope, $location, $http, NgTableParams,$q,$resource) {
    $scope.options = {
        focus: false,
        toolbar: false,
        shortcuts: false,
        disableDragAndDrop: true,
        placeholder: '请输入内容',
    };

    $scope.inint_sn = function() {
        $('.myIssueSummary:first').summernote('destroy');
        $('.myIssueSummary:first').removeClass("myIssueSummary");
    }

    function initIssueList(kexueCount,kejiCount)
    {
        $scope.kexueIssues = new NgTableParams(
            {
                page: 1,            // show first page
                count: 10,          // count per page
                sorting: {
                    create_time: 'desc'     // initial sorting
                }
            },
            {
                total:kexueCount,
                counts: [],
                getData: function (params) {

                    var kexue=1;
                    var url = "index.php?r=Issue/getIssuesByPeriodicalId&periodicalId="+kexue;

                    $paramaters = new Object();
                    $paramaters.pageNow = params.page();
                    $paramaters.pageSize = params.count();

                    var Api = $resource(url);
                    return Api.get(params.url()).$promise.then(function(data) {
                        return data.issues;
                    });
                }
            }
        );

        $scope.kejiIssues = new NgTableParams(
            {
                page: 1,            // show first page
                count: 10,          // count per page
                sorting: {
                    create_time: 'desc'     // initial sorting
                }
            },
            {
                total:kejiCount,
                counts: [],
                getData: function (params) {

                    var keji=2;
                    var url = "index.php?r=Issue/getIssuesByPeriodicalId&periodicalId="+keji;

                    $paramaters = new Object();
                    $paramaters.pageNow = params.page();
                    $paramaters.pageSize = params.count();

                    var Api = $resource(url);
                    return Api.get(params.url()).$promise.then(function(data) {
                        return data.issues;
                    });
                }
            }
        );
    }


    function init()
    {
        var url = "index.php?r=Issue/getTotalIssueCount";
        $http.get(url).success(function (data) {
            var kexueCount = data.kexueCount;
            var kejiCount = data.kejiCount;
            if(kejiCount==0 || kejiCount==0)
            {
              alert('查询期刊失败,请联系管理员');
                return;
            }
            initIssueList(kexueCount,kejiCount);
        });

    }
    init();



    $scope.open_issue_view = function(issueId) {
        if(issueId == "undefined")
        {
           return;
        }
        window.location.href = "#/onlinebook?issueId=" + issueId;
    }
}
