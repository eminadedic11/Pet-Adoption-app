<?php
require_once __DIR__ . '/UserDao.php';
require_once __DIR__ . '/PetDao.php';
require_once __DIR__ . '/AdoptionDao.php';

$userDao = new UserDao();
$petDao = new PetDao();
$adoptionDao = new AdoptionDao();

$users = $userDao->getAllUsers();
$pets  = $petDao->getAllPets();

if (empty($users) || empty($pets)) {
    die("Please ensure there is at least one user and one pet in the database to test adoptions.\n");
}

$testUserId = $users[0]['user_id'];
$testPetId  = $pets[0]['pet_id'];


$deleteResult = $adoptionDao->deleteAdoption(14);
echo $deleteResult ? "Adoption deleted successfully\n" : "Adoption deletion failed\n";
?>
