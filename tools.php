<?php
function showLevel(){
    if(!is_dir("livelli")){
        return;
    }
    $d = dir("livelli");
    $levels = [];
    while (false !== ($entry = $d->read())) {
        if($entry == "." || $entry ==".."){
            continue;
        }
        $position = strpos($entry,".");
        $levels[] = substr($entry,0,$position);
    }
    $d->close();
    foreach($levels as $level){
        echo"<button> livello $level </button> <br> <br>";
    }
}



function getWord($level){
    $path = "/livelli/" . $level . ".csv";
    if(file_exist($path){
        $file = fopen($path,"r");
    }else{
        return;
    }
    $allWords = [];
    while(($word = fgetcsv($file,1000,",")) !== false){
        foreach ($data as $word) {
            $cleanedWord = trim($word);
            if (!empty($cleanedWord)) {
                $allWords[] = $cleanedWord;
            }
        }
    }   
}





showLevel();
getWord("1");
?>