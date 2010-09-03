<div id="content">
    <h2>Find Your Legislator</h2>
    <?php if (validation_errors()): ?>
    <div class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <?php
                    
                    echo validation_errors();
                    
                    ?>
            </p>
        </div>
    
    </div>
    <?php endif; ?>

    <?php echo form_open('person/find_legislator'); ?>

    <table>
        
        <tr><td>
                <strong>Address</strong></td></tr>
        <tr><td><input size="30" id="address_text_box" name="address_text_box" type="text" value=""/></td></tr>
        <tr><td><strong>City</strong></td></tr>
        <tr><td><input size="25" id="city_text_box" name="city_text_box" type="text" value="" />
                , AL</td></tr>
        <tr><td><strong>Zip</strong></td></tr>
        <tr><td><input size="5" id="zippart1_text_box" name="zippart1_text_box" type="text" value="" />-<input size="4" id="zippart2_text_box" name="zippart2_text_box" type="text" value="" /></td></tr>
        <tr><td><input type="submit" id="submit_inquiry" name="submit_inquiry" value="Search" /></td></tr>
    </table>
    <?php echo form_close(); ?>
</div>