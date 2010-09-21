<div id="content">
    <hr>
    <h2>Register</h2>


    <?php if($this->session->flashdata('message')): ?>
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



        <?php echo form_open('auth/register'); ?>



    <table>

        <thead>

            <tr>

                <th colspan="2">Required Fields</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>Username</td>

                <td><?php echo form_input('username', set_value('username')); ?></td>

            </tr>

            <tr>

                <td>Email Address</td>

                <td><?php echo form_input('email', set_value('email')); ?></td>

            </tr>

            <tr>

                <td>Confirm Email Address</td>

                <td><?php echo form_input('confirmEmail', set_value('confirmEmail')); ?></td>

            </tr>

            <tr>

                <td>Password</td>

                <td><?php echo form_password('password'); ?></td>

            </tr>

            <tr>

                <td>Confirm Password</td>

                <td><?php echo form_password('confirmPassword'); ?></td>

            </tr>

        </tbody>

    </table>



    <table>

        <thead>

            <tr>

                <th colspan="2">Optional Fields</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>First Name</td>

                <td><?php echo form_input('first_name', set_value('first_name')); ?></td>

            </tr>

            <tr>

                <td>Last Name</td>

                <td><?php echo form_input('last_name', set_value('last_name')); ?></td>

            </tr>
            <tr>

                <td>Your Senate District</td>
                <td><select name="senate_district">
                        <option value="0">-- Select a district --</option>
                            <?php
                            for ( $counter = 1; $counter <= 35; $counter += 1) {
                                echo '<option value="'.$counter.'">'.$counter.'</option>';
                            }

                            ?>
                    </select>
                </td>
            </tr>
            <tr>

                <td>Your House District</td>
                <td>
                    <select name="house_district">
                        <option value="0">-- Select a district --</option>
                            <?php
                            for ( $counter = 1; $counter <= 105; $counter += 1) {
                                echo '<option value="'.$counter.'">'.$counter.'</option>';
                            }

                            ?>
                    </select>

                </td>
            </tr>
            <tr>

                <td colspan="2">
                    <?php echo '<a target="_blank" href="'.base_url().INDEX_TO_INCLUDE.'person/find_legislator">Not sure what districts you are in?</a>';
                    ?>
                </td>
            </tr>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
                    <input type="submit" id="register" value="Register" name="register" class="ob_button" />
                </td>

            </tr>

        </tfoot>

    </table>



        <?php echo form_close(''); ?>
    <?php endif; ?>
</div>