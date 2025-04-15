<?php
session_start();
session_unset();     // Sabhi session variables ko remove karta hai
session_destroy();   // Session ko destroy karta hai

echo "<script>
    alert('You have been logged out successfully!');
    window.location.href = 'index.php';
</script>";
?>
