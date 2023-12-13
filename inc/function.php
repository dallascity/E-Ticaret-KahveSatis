<?php 
function errorAlert($error) {
    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
    echo "<script>Swal.fire({
        icon: 'error',
        title: '$error',  
    }) </script>";
}

function route($route){
    echo "<script>window.location.href = '$route';</script>";
}
?>