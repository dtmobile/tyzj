/**
 * Created by wuzhijun on 13-12-26.
 */

function OnlineBookView($scope, $http,$location){

	var articleId = $location.search().articleId;
	if(typeof(articleId)== 'undefined')
	{
		alert('文章编号不存在');
		return;
	}
    
	$scope.name='';
	$scope.name_en='';
	$scope.author='';
	$scope.authorIntroduction='';
	$scope.summary='';
	$scope.query1='';
	$scope.attach_file_list='';


	$scope.magazineTypes=[{type:0, name:'体育科学'},{type:1,name:'中国体育科技'}];
    $scope.search_type = ""; 
    $scope.search_author_name = ""; 
    $scope.search_author_company = ""; 
    $scope.search_name = "";  
    $scope.search_summary = ""; 
	$scope.search_keywords="";
	$scope.search_pacs="";




	function getBookContInfo()
	{
		var url = "index.php?r=Article/getArticleDetail&articleId="+articleId;
		$http.get(url).success(function(data){
			$scope.name=data.name;
			$scope.name_en=data.name_en;
			$scope.author=data.author;
			$scope.authorIntroduction=data.authorIntroduction;
			$scope.summary=data.summary;
			$scope.query1=data.query1;
			$scope.attach_file_list=data.attach_file_list;

			$('#summernote_keyword').summernote('code', data.keyword);
			$('#summernote_keyword').summernote('destroy');

			$('#summernote_summary_en').summernote('code', data.summary_en);
			$('#summernote_summary_en').summernote('destroy');
			$('#summernote_keyword_en').summernote('code', data.keyword_en);
			$('#summernote_keyword_en').summernote('destroy');
		});
	}

	var issueId = $location.search().issueId;
	if(typeof(issueId)== 'undefined')
	{
		alert('期刊编号不存在');
		return;
	}
	
    var url = "index.php?r=Issue/getIssueById&issueId="+issueId;
    $http.get(url + "&t=" + (new Date()).getTime()).success(function(data){

			$scope.issue_zb = data.issue_zb;
			$scope.issue_fzb = data.issue_fzb;
			$scope.issue_bw = data.issue_bw;
    });     

    $scope.commit_search=function()
    {
    	window.location.href = "#/senior_search?type="+$scope.search_type
        +"&author_name="+$scope.search_author_name+"&author_company="+$scope.search_author_company
        +"&name="+$scope.search_name+"&summary="+$scope.search_summary        
        +"&keywords="+$scope.search_keywords+"&pacs="+$scope.search_pacs;
    };

	$scope.$on('$viewContentLoaded', function() {
		getBookContInfo();
	});
}