<?php
session_start();
if ($MM_UserGroup == '10') {
?>
<script>
window.location = "../admin/yonet.php";
</script>
<?php
} else if ($MM_UserGroup == '5') {
?>
<script>
window.location = "../mod/yonet.php";
</script>
<?php
} else {
?>
<script>
window.location = "../giris.php?hata=girisyap";
</script>
<?php
}
?>