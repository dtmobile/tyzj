/**
 * Created by wuzhijun on 13-12-26.
 */

function PaperView($scope, $location,$http,$interval){
	var articleId = $location.search().articleId; //GetQueryString('taskid');
	
	$scope.name='';
	$scope.name_en='';
	$scope.author='';
	$scope.authorIntroduction='';
	$scope.summary='';
	$scope.keyword='';
	$scope.summary_en='';
	$scope.keyword_en='';
	$scope.query1='';
	$scope.attach_file_list='';

	var url = "index.php?r=Article/getArticleDetail&articleId="+articleId;
        $http.get(url).success(function(data){
        	$scope.name=data.name;
			$scope.name_en=data.name_en;
			$scope.author=data.author;
			$scope.authorIntroduction=data.authorIntroduction;
			$scope.summary=data.summary;
			$scope.keyword=data.keyword;
			$scope.summary_en=data.summary_en;
			$scope.keyword_en=data.keyword_en;
			$scope.query1=data.query1;
			$scope.attach_file_list=data.attach_file_list;
        });
}