/**
 * Created by wuzhijun on 13-12-26.
 */

function SeniorSearch($scope, $location,$http, NgTableParams){

    $scope.magazineTypes=[{type:1, name:'体育科学'},{type:2,name:'中国体育科技'}];
    
    var type = $location.search().type;
    if( typeof(type) == "undefined")
    {
        type=0;
    }
    $scope.search_type = type; 

    var author_name = $location.search().author_name;
    if(typeof(author_name) == "undefined")
    {
        author_name='';
    }
    $scope.search_author_name = author_name; 


    var author_company = $location.search().author_company;
    if(typeof(author_company) == "undefined")
    {
        author_company='';
    }
    $scope.search_author_company = author_company; 
    
    var name = $location.search().name;
    if(typeof(name) == "undefined")
    {
    	name='';
    }
    $scope.search_name = name;  

    var summary = $location.search().summary;
    if(typeof(summary) == "undefined")
    {
    	summary='';
    }
    $scope.search_summary = summary; 


    var keywords = $location.search().keywords;
    if(typeof(keywords) == "undefined")
	{
    	keywords="";
	}
    $scope.search_keywords = keywords; 


    var pacs = $location.search().pacs;
    if(typeof(pacs) == "undefined")
    {
        pacs="";
    }
    $scope.search_pacs = pacs; 

    
    function start_serarch()
    {
        var url = "index.php?r=Article/seniorsearch&type="+$scope.search_type
        +"&author_name="+$scope.search_author_name+"&author_company="+$scope.search_author_company
        +"&name="+$scope.search_name+"&summary="+$scope.search_summary        
        +"&keywords="+$scope.search_keywords+"&pacs="+$scope.search_pacs;
        
        $http.get(url + "&t=" + (new Date()).getTime()).success(function(data){
            // $scope.search_results = data.search_results;
            $scope.search_results = new NgTableParams({}, { dataset: data.search_results});
        });
    }

    start_serarch();


    $scope.commit_search=function()
    {
        $scope.search_results = new NgTableParams({}, { dataset: ''});
        start_serarch();
    }

    $scope.open_article_view = function(articleId,issueId) {
        if(articleId == "undefined")
        {
           alert('articleId不可以为空');
           return;
        }

        if(issueId == "undefined")
        {
           alert('issueId不可以为空');
           return;;
        }
        

        window.location.href = "#/onlinebook_view?articleId=" + articleId  + "&issueId="+issueId
        ;
    }
}