

<?php

if(count($subjects) > 0) {

    $subjectsArray = array('0' => '-- Select an issue --');

    foreach($subjects as $row) {
        $subjectsArray[$row->id] = $row->subject;
    }
}

$dateSearchTypeArray = array('0' => '-- Select Date Type --',
    'intro' => 'Introduced Date',
    'enact' => 'Enacted Date',
    'lastAction' => 'Last Action Date',
    'lastVote' => 'Last Vote Date',
    'sponsor' => 'Date Sponsor Added'
);

$sponsorSearchOptions = array ('id' => 'searchDateBTN');

?>
<div id="content">
    testing
</div>
<div id="sidebar">
    <div class="box">
        <h3>About OpenBama.org</h3>
        <p>
            Text here.
        </p>
    </div>
</div>