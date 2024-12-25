<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses data form
    echo "Data diterima!";
} else {
    echo "Form belum disubmit.";
}
?>