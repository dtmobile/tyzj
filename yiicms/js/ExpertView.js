/**
 * Created by wuzhijun on 13-12-26.
 */

function ExpertView($scope, $http){
  

    $scope.tiyukexue = new Array();
    $scope.tiyukeji = new Array();  


	function reload()
	{
			var url = "index.php?r=expert/getExperts";
			$http.get(url).success(function(data){
				$scope.tiyukexue = data.tiyukexue;
				$scope.tiyukeji = data.tiyukeji;
			});    
	} 
	reload();
  
}