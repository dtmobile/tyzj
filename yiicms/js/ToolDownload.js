/**
 * Created by wuzhijun on 13-12-26.
 */

function ToolDownload($scope, $http){

var tiyukexue = new Object();
tiyukexue.title='体育科学';
tiyukexue.zhubian='田野';
tiyukexue.fuzhubian='田麦久  杨桦  杜利军  王清  李晓宪';
tiyukexue.bianwei='王进  王家宏  丛湖平  冯连世  吕万刚  任海  江崇民  刘大庆  刘宇  刘兴  李国平  李鸿江';

var tiyukeji = new Object();
tiyukeji.title='中国体育科技';
tiyukeji.zhubian='田野';
tiyukeji.fuzhubian='王清  张良  李晓宪';
tiyukeji.bianwei='于芬  白玲  兰燕生  卢元镇  丛湖平  冯连世  冯树勇  任海  吕树庭  孙大光  李元伟  肖学林  杨有为  罗超毅';


    $scope.magazine_list = new Array();
    $scope.magazine_list[0]=tiyukexue;
    $scope.magazine_list[1]=tiyukeji;          
}