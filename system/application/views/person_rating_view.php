<br>

<?php

if ($person_rating){
    if($person_rating->num_rated == 0){
        echo '<b>Average rating:</b> Not rated yet';
    }else{
        echo '<b>Average rating:</b> '.round($person_rating->person_rating).'%';
    }
}

?>
<br>