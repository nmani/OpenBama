<br/>
<br/>
<br/>
<a href="<?php echo base_url().'index.php'; ?>"><img border="0" src="<?php echo base_url().'img/Logo2.png'?>" title="OpenBama.org" alt="OpenBama.org" /></a>
<br>
<br>
<div>
    <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
</div>
<br>
<A HREF="javascript:window.print()">Click to Print This Page</A>
<br>
<br>
<?php
if($contact_info) {

    $previous_member = '';

    foreach($contact_info as $contact) {
        if($contact->full_name != $previous_member) {
            echo '<b><u>'.$contact->full_name.'['.$contact->party.', '.$contact->district.'] ('.$contact->role.')</u></b><br><br>';
            echo '<b>'.$contact->address_type.'</b><br>';
            echo $contact->address_street.'<br>';
            echo $contact->address_city.', '.$contact->address_state.' '.$contact->address_zip.'<br><br>';
            if ($contact->phone1) echo '<b>Phone:</b>'.$contact->phone1.'<br>';
            if ($contact->phone2) echo '<b>Phone:</b>'.$contact->phone2.'<br>';
            if ($contact->fax1) echo '<b>Fax:</b>'.$contact->fax1.'<br>';
            if ($contact->fax2) echo '<b>Fax:</b>'.$contact->fax2.'<br>';
            if ($contact->toll_free) echo '<b>Toll Free:</b>'.$contact->toll_free.'<br>';
            if ($contact->ttyd) echo '<b>TTYD:</b>'.$contact->ttyd.'<br>';
            echo '<br>';
        }else {
            echo '<b>'.$contact->address_type.'</b><br>';
            echo $contact->address_street.'<br>';
            echo $contact->address_city.', '.$contact->address_state.' '.$contact->address_zip.'<br><br>';
            if ($contact->phone1) echo '<b>Phone:</b>'.$contact->phone1.'<br>';
            if ($contact->phone2) echo '<b>Phone:</b>'.$contact->phone2.'<br>';
            if ($contact->fax1) echo '<b>Fax:</b>'.$contact->fax1.'<br>';
            if ($contact->fax2) echo '<b>Fax:</b>'.$contact->fax2.'<br>';
            if ($contact->toll_free) echo '<b>Toll Free:</b>'.$contact->toll_free.'<br>';
            if ($contact->ttyd) echo '<b>TTYD:</b>'.$contact->ttyd.'<br>';
            echo '<br>';
        }


        $previous_member = $contact->full_name;
    }

}
?>