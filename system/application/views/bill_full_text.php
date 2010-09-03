<style type="text/css">
    #bill_text_div strike{
        color: red;
    }
    #bill_text_div u{
        /*color: blue;*/
        background-color:yellow;
    }
    #bill_text_div center u{
        color: black;
        background-color:transparent;
    }
    #legend strike{
        color: red;

    }
    #legend u{
        background-color:yellow;
    }
</style>
<div id="content">
    <div id="leftdiv">
    <hr>
    <h2>Bill Text for <?php echo strtoupper($bill->bill_type).$bill->number; ?></h2>
    <p>
        <?php
        if($bill_version_types) {
            echo '<h3>Bill Versions In PDF</h3>';
            foreach($bill_version_types as $type) {
                echo '<a href="'.base_url().'bills/'.$bill->session_identifier.'/'.strtoupper($bill->bill_type).$bill->number.'-'.$type->version_type.'.pdf" target="_blank"><img border="0" src="'.base_url().'img/pdf_icon.png"></img>'.$type->version_type_desc.'</a><br>';
            }
        }
        ?>
    </p>

    <h3>Currently Proposed Text</h3>
    <p>
    <div class="summary_content_div">
    <div id="bill_text_div">
        <?php echo $bill_text; ?>
    </div>
    </div>


</div>
<div id="rightdiv">
    <div class="summary_content_div">
        <h3>Bill Text Legend</h3>
        <div id="legend">
            Text <u>highlighted in yellow</u> are proposed additions to the bill.<br>
            Text <strike>stricken and in red</strike> are proposed deletions from the bill.
        </div>
    </div>
</div>
</div>