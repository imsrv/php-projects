<select name="to[]" multiple="multiple" size="3">
    <option value="0" <?php checkSelected(0); ?>>Please select the recipients ...     </option>
<?php
// ********************************************************************************
// Add your selections here!  Entries must be in this format:
//  <option value="#" < ?php checkSelected(#); ? >>NAME</option>
?>
    <option value="1" <?php checkSelected(1); ?>>Mike's Email Address</option>
    <option value="2" <?php checkSelected(2); ?>>John Doe - Sales</option>
</select><?php
// ********************************************************************************
?>
