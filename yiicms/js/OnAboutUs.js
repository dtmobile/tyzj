/**
 * Created by wuzhijun on 13-12-26.
 */

function OnAboutUs($scope, $http, $compile, $rootScope, $document) {


    $scope.us_image = 'img/image_miss.png';
    $scope.us_content = '待补充';
    function reload() {
        // var url = "index.php?r=question/getQuestions";
        // $http.get(url).success(function (data) {
        //     $scope.question_list = data.question_answer;
        // });
    }
    reload();

    
}
