<div id="content">
    <hr>
    <h2>Forgotten Password</h2>



    <?php if ($this->session->flashdata('message')): ?>

        <?php echo $this->session->flashdata('message'); ?>
    <?php else: ?>

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

        <?php echo form_open('auth/forgotten_password'); ?>

<p>Please enter your email address to reset your password.</p>

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

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
                    <input type="submit" id="reset_pass" value="Reset Password" name="reset_pass" class="ob_button" />
                </td>

            </tr>

        </tfoot>

    </table>



        <?php echo form_close(''); ?>

    <?php endif; ?>
</div>