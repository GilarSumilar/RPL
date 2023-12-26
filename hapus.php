<?php
require 'functions.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    echo "
            <script>
                alert('data berhasil di hapus');
                document.location.href = 'warga.php';
            </script> 
        ";
    exit();
} else {
    echo "Error adding record: " . mysqli_error($conn);
}
