<?php
session_start();

echo '<script>
try {
  console.log("test");
} catch (error) {
  console.error(error);
}
</script>';

?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  try {
    console.log("test");
  } catch (error) {
    console.error(error);
  }
});
</script>