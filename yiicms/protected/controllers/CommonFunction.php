<?php
/**
 *
 * 把数组按指定的个数分隔
 * @param array $array 要分割的数组
 * @param int $groupNum 分的组数
 */
function splitArray($array, $groupNum){
    if(empty($array)) return array();

    //数组的总长度
    $allLength = count($array);

    //个数
    $groupNum = intval($groupNum);

    //开始位置
    $start = 0;

    //分成的数组中元素的个数
    $enum = (int)($allLength/$groupNum);

    //结果集
    $result = array();

    if($enum > 0){
        //被分数组中 能整除 分成数组中元素个数 的部分
        $firstLength = $enum * $groupNum;
        $firstArray = array();
        for($i=0; $i<$firstLength; $i++){
            array_push($firstArray, $array[$i]);
            unset($array[$i]);
        }
        for($i=0; $i<$groupNum; $i++){

            //从原数组中的指定开始位置和长度 截取元素放到新的数组中
            $result[] = array_slice($firstArray, $start, $enum);

            //开始位置加上累加元素的个数
            $start += $enum;
        }
        //数组剩余部分分别加到结果集的前几项中
        $secondLength = $allLength - $firstLength;
        for($i=0; $i<$secondLength; $i++){
            array_push($result[$i], $array[$i + $firstLength]);
        }
    }else{
        for($i=0; $i<$allLength; $i++){
            $result[] = array_slice($array, $i, 1);
        }
    }
    return $result;
}