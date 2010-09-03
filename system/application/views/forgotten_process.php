<h1>Forgotten Process</h1>

<?php echo $this->validation->error_string; ?>

<?php echo form_open('forgotten_process'); ?>

<label for="username">Forgotten Password Validation Code : </label>
<?php echo form_input('forgotten_code'); ?>

<label for="submit"> </label>
<?php echo form_submit('submit', 'Validate'); ?>

<?php echo form_close(); ?>