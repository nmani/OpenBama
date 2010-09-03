<div id="content">
    <hr>
    <h2>Change Password</h2>



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



    <?php echo form_open('auth/change_password'); ?>

    <table>

        <thead>

            <tr>

                <th colspan="2">Required Fields</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>Old Password</td>

                <td><?php echo form_password('old', set_value('old')) ?></td>

            </tr>

            <tr>

                <td>New Password</td>

                <td><?php echo form_password('new', set_value('new')) ?></td>

            </tr>

            <tr>

                <td>Repeat New Password</td>

                <td><?php echo form_password('new_repeat', set_value('new_repeat')) ?></td>

            </tr>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
                    <input type="submit" id="change_pass" value="Change Password" name="change_pass" class="ob_button" />
                </td>

            </tr>

        </tfoot>

    </table>

    <?php echo form_close(); ?>
</div>