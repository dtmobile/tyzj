/**
 * Created by wuzhijun on 13-12-26.
 */

function NewsView($scope, $http,$location){


	var newsid = $location.search().newsid;
	if(typeof(newsid)== 'undefined')
	{
		alert('新闻编号不存在');
		return;
	}

	$scope.newsid = newsid;
	$scope.title = '';
	$scope.createDate = '';
	$scope.image = '';

	function getNewsContent() {
		var url = "index.php?r=News/getNewsById&newsid="+newsid;
		$http.get(url + "?t=" + (new Date()).getTime()).success(function (data) {
			$scope.title = data.title;
			$scope.createDate = data.createDate;
			$scope.image = data.image;
			$('#summernote').summernote('code', data.content);
			$('#summernote').summernote('destroy');
		});
	}

	$scope.$on('$viewContentLoaded', function() {
		getNewsContent();
	});
}