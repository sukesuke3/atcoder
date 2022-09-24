<?php 
/* 
AtCoder Beginners Selection
ABC086C - Traveling
ランダムテスト
*/

//trueの割合確認用
$true_cnt = 0;

//ランダム入力生成
function random_generate(){
    $N = random_int(1,10**3);
    for ($i=1; $i <= $N; $i++) { 
        $data[$i-1][0] = $i*3+1; //t
        $data[$i-1][1] = random_int(0,8); //x
        $data[$i-1][2] = random_int(0,8); //y
    }
    return [$N,$data];
}

//バグが存在する可能性あり
function solve($N,$data){
    $pt = $px = $py = 0;
    for ($i=0; $i < $N; $i++) { 
        list($t,$x,$y) = $data[$i];
        $diff_t = $t-$pt;
        $diff_d = abs($x-$px) + abs($y-$py);
        if($diff_t < $diff_d || $diff_t %2 !== $diff_d % 2){
            return "No\n";
        }
        
        //★★バグ
        /* $pt = $t;
        $px = $x;
        $py = $y; */
    }

    return "Yes\n";
}

//正しい解法
function solve_judge($N,$data){
    $pt=$px=$py=0;
    for ($i=0; $i < $N; $i++) { 
        list($t,$x,$y) = $data[$i];
        $diff_t = $t-$pt;
        
        //変化値を導出
        $diff_t -= (abs($x-$px) + abs($y-$py));
        if($diff_t %2 === 1 || $diff_t < 0){
            return "No\n";
        }

        $pt = $t;
        $px = $x;
        $py = $y;
    }

    global $true_cnt;
    $true_cnt++;
    return "Yes\n";
}


define("TRYNUM",10**5);//試行回数
for ($i=0; $i < TRYNUM; $i++) { 
    list($N,$data) = random_generate();
    //xdiffでなく、出力文字列の比較でもよい
    $diff = xdiff_string_diff(solve($N,$data),solve_judge($N,$data));
    echo strlen($diff) ? "============\n" . print_r($data,true) . $diff : "";
}

//true割合表示
printf("result : %f%%\n",($true_cnt/TRYNUM)*100);