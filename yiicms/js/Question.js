/**
 * Created by wuzhijun on 13-12-26.
 */

function Question($scope, $http, $compile, $rootScope, $document) {
     $scope.options = {
     	  focus: false,
          toolbar: false,
          shortcuts: false,
          disableDragAndDrop: true,
          placeholder: '请输入内容',
    };

    $scope.question_list = new Array();
    function reload() {
        var url = "index.php?r=question/getQuestions";
        $http.get(url).success(function (data) {
            $scope.question_list = data.question_answer;
        });
    }
    reload();

    $scope.inint_sn = function() {
        $('.myanswer:first').summernote('destroy');
        $('.myanswer:first').removeClass("myanswer");
    }
}
