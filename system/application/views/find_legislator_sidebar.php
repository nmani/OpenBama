<h3>Find Your Representative/Senator</h3>
        <p>
            <?php echo form_open('person/find_legislator'); ?>
        <table>
            <tr><td><font color="red">The zip code is required.</font></td></tr>
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

        </p>