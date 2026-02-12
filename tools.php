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
    foreach($levels in $level){
        echo"<button> $level </button>";
    }
}
    
?>