<div id="content">
    <hr>
    <h2>Login</h2>

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



    <?php echo form_open('auth/login'); ?>

    <?php if ($return_url): ?>
    <input type="hidden" value="<?php echo $return_url; ?>" id="return_url" name="return_url" />
    <?php endif; ?>
    <table>

        <thead>

            <tr>

                <th colspan="2">Required Fields</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>Email Address</td>

                <td><?php echo form_input('email', set_value('email')); ?></td>

            </tr>

            <tr>

                <td>Password</td>

                <td><?php echo form_password('password'); ?></td>

            </tr>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
                    <input type="submit" id="Login" value="Login" name="Login" class="ob_button" /></td>

            </tr>
            <tr><td><a href='<?php print base_url().'index.php/auth/register'; ?>'>Create an account</a></td></tr>
            <tr><td><a href='<?php print base_url().'index.php/auth/forgotten_password'; ?>'>Forgot your password?</a></td></tr>

        </tfoot>

    </table>

    <?php echo form_close(''); ?>
</div>