<h1>Login</h1>

<?php echo $this->validation->error_string; ?>

<?php echo form_open('user/forgotten_begin'); ?>

<label for="username">Email : </label>
<?php echo form_input('email'); ?>

<label for="submit"> </label>
<?php echo form_submit('submit', 'Start Forgotten Password Procedure'); ?>

<?php echo form_close(); ?>