<div id="content">
    <hr>
    <h2>Manage Committee Members</h2>
    <?php echo form_open('admin/add_committee_member'); ?>
    <table>

        <tr>
            <td>
                Commitee:
            </td>
            <td>
                <select name="committees" id="committees">
                    <?php foreach($committees as $committee) : ?>
                    <option value="<?php echo $committee->committee_id; ?>"><?php echo $committee->committee_name; ?></option>
                    <?php endforeach; ?>
                </select>

            </td>
        </tr>
        <tr>
            <td>
                Member:
            </td>
            <td>
                <select name="people" id="people">
                    <?php foreach($people as $person) : ?>
                    <option value="<?php echo $person->person_id; ?>"><?php echo $person->full_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Role:
            </td>
            <td>
                <input type="text" id="role" name="role" />

            </td>
        </tr>
        <tr><td colspan="2"><input type="submit" value="Add" /></td></tr>
    </table>
    <?php echo form_close(); ?>

    <table width="100%">
        <?php foreach($committee_members as $member) : ?>
        <tr>
            <td><a href="<?php echo base_url().'index.php/person/display/'.$member->person_id; ?>" target="_blank"><?php echo $member->full_name; ?></a></td>
            <td><?php echo $member->committee_name; ?></td>
            <td><?php echo $member->subcommittee_name; ?></td>
            <td><?php echo $member->role; ?></td>
            <td><a href="<?php echo base_url().'index.php/admin/delete_committee_member/'.$member->id; ?>">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>