<?php
echo "Admin Password: " . password_hash("123456", PASSWORD_DEFAULT) . "\n";
echo "Empleado Password: " . password_hash("empleado123", PASSWORD_DEFAULT) . "\n";
?>
