/**
 * Created by wuzhijun on 13-12-26.
 */

function Index($scope, $http){
    $scope.route = "#/";
    
    $scope.kexue_current_issueId=0;
    $scope.keji_current_issueId=0;

	$scope.keji_start_index=0;
    $scope.keji_current_articals_total=0;
    $scope.keji_current_articals = new Array();
    

	$scope.kexue_start_index=0;
    $scope.kexue_current_articals_total=0;
    $scope.kexue_current_articals = new Array();

    $scope.current_artical_page_size=4;
    



    $scope.issue_start_index=0;
    $scope.issue_page_size=0;
    $scope.issues = new Array();
  $scope.kejiList = new Array();
  $scope.kexueList = new Array();
    
    $scope.top_news = new Array();

  function CutSummary(artical_list, len) {
        for (var i = artical_list.length - 1; i >= 0; i--) {
      if (artical_list[i].summary.length > len) {
        artical_list[i].summary = artical_list[i].summary.substring(0, len) + '...';
            }
        };

    }

  function initial() {
        var url = "index.php?r=News/getTopNews";
        $http.get(url).success(function(data){
            $scope.top_news = data.top_news;
        });

       var url = "index.php?r=Article/getCurrentArticleTotal";
        $http.get(url).success(function(data){
            $scope.kexue_current_issueId=data.kexue_current_issueId;
            $scope.keji_current_issueId=data.keji_current_issueId;
            $scope.kexue_current_articals_total=data.kexue_total;
            $scope.keji_current_articals_total=data.keji_total;
        });

        var url = "index.php?r=Article/getCurrentArticle&periodicalId=2"+"&start="+$scope.keji_start_index+"&count="+$scope.current_artical_page_size;
        $http.get(url).success(function(data){
      CutSummary(data.artical_list, 80);
            $scope.keji_current_articals = data.artical_list;
            
        });

        var url = "index.php?r=Article/getCurrentArticle&periodicalId=1"+"&start="+$scope.kexue_start_index+"&count="+$scope.current_artical_page_size;
        $http.get(url).success(function(data){
      CutSummary(data.artical_list, 80);
            $scope.kexue_current_articals = data.artical_list;
        });

        var url = "index.php?r=Issue/GetIssues&start="+$scope.issue_start_index+"&count="+$scope.issue_page_size;
        $http.get(url).success(function(data){
      CutSummary(data.kejiList, 150);
      CutSummary(data.kexueList, 150);
      $scope.onlineKejiList = data.kejiList;
      $scope.onlinekexueList = data.kexueList;

    });

    $scope.open_onlinebook_view = function (articleId) {
        if (articleId == "undefined") {
            return;
    }

        window.location.href = "#/onlinebook_view?articleId=" + articleId + "&issueId=" + $scope.issueId;
    };

    $scope.Loop_onlineKejiList = function(p_index)
    {
      if (p_index==2) {
        $(".onlineKejiList").bootstrapNews({
          newsPerPage: 4,
          autoplay: true,
          pauseOnHover: true,
          navigation: false,
          direction: 'up',
          newsTickerInterval: 1500,
          onToDo: function() {
            // console.log(this);
          }
        });
      }
    }

    $scope.Loop_onlineKexueList = function(p_index)
    {
      if (p_index==2) {
        $(".onlineKexueList").bootstrapNews({
          newsPerPage: 4,
          autoplay: true,
          pauseOnHover: true,
          navigation: false,
          direction: 'up',
          newsTickerInterval: 1500,
          onToDo: function() {
            // console.log(this);
          }
        });
      }
    }

  }
    initial();

    function kejiReload(isNext){
    if (isNext) {
            //获取下一页
            $scope.keji_start_index += $scope.current_artical_page_size;
    } else {
            //获取上一页
            $scope.keji_start_index -= $scope.current_artical_page_size;
        }

        var url = "index.php?r=Article/getCurrentArticle&periodicalId=2"+"&start="+$scope.keji_start_index+"&count="+$scope.current_artical_page_size;
        $http.get(url).success(function(data){
      CutSummary(data.artical_list, 80);
        	$scope.keji_current_articals = data.artical_list;
        	
        });
    }

    function kexueReload(isNext){
    if (isNext) {
            //获取下一页
            $scope.kexue_start_index += $scope.current_artical_page_size;
    } else {
            //获取上一页
            $scope.kexue_start_index -= $scope.current_artical_page_size;
        }

        var url = "index.php?r=Article/getCurrentArticle&periodicalId=1"+"&start="+$scope.kexue_start_index+"&count="+$scope.current_artical_page_size;
        $http.get(url).success(function(data){
      CutSummary(data.artical_list, 80);
        	$scope.kexue_current_articals = data.artical_list;
        });
    }


    // function issueReload(isNext){
    //     if(isNext)
    //     {
    //         //获取下一页
    //         $scope.issue_start_index += $scope.issue_page_size;
    //     }else
    //     {
    //         //获取上一页
    //         $scope.issue_start_index -= $scope.issue_page_size;
    //     }

    //     var url = "index.php?r=Issue/GetIssues&start="+$scope.issue_start_index+"&count=4";
    //     $http.get(url).success(function(data){
    //         $scope.issues = data.issue_list;
    //     });
        
    // }

    // $scope.get_next_issue = function() {
    //     issueReload(true);
    // }

    // $scope.get_prev_issue = function() {
    //     issueReload(false);
    // }


    $scope.get_next_articals = function(type) {
    if (type == 2) {
          kejiReload(true);
    } else if (type == 1) {
 			kexueReload(true);
        }  
    }

    $scope.get_prev_articals = function(type) {
    if (type == 2) {
          kejiReload(false);
    } else if (type == 1) {
 			kexueReload(false);
        }  
    }
    

    $scope.open_artical_view = function(articleId,type) {
    if (typeof(articleId) == "undefined" || typeof(type) == "undefined") {
           return;
        }

        var issueId=0;
    if (type == 1) {
            issueId = $scope.kexue_current_issueId;
    } else if (type == 2) {
            issueId = $scope.keji_current_issueId;
        }else{
            issueId = $scope.keji_current_issueId;
        }

        window.location.href = "#/onlinebook_view?articleId=" + articleId + "&issueId="+issueId;
    };


    $scope.open_news_view = function(newsid) {
    if (newsid == "undefined") {
           return;
        }

        window.location.href = "#/news_view?newsid=" + newsid;
    };

    $scope.open_issue_view = function(issueId) {
    if (issueId == "undefined") {
           return;
        }

        window.location.href = "#/onlinebook?issueId=" + issueId;
    }

}