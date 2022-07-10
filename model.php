<?php 

    require_once 'db.php';

    $name = $_POST['name'];
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);

    function addPerson($mysql, $name, $phone) {

        $sql = "INSERT INTO `Phones`(`name`, `phone`, `date`) VALUES ('$name', '$phone', CURRENT_DATE())";
        mysqli_query($mysql, $sql);

        echo json_encode(getPersones($mysql));
    }
    if (isset($_POST['name']) && isset($_POST['phone'])) addPerson($mysql, $name, $phone);


    function getPersones($mysql) {

        $sql = "SELECT `id`, `name`, `phone`, `date` FROM `Phones`";

        $query = mysqli_query($mysql, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        return $result;

    }
    $persons = getPersones($mysql);

    mysqli_close($mysql);