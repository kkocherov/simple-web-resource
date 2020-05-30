<?php
use pomidorki\User;
/** @var User $user */
?>

<h1> User </h1>

<div> login: <?php echo $user->getLogin(); ?> </div>
<div> active: <?php echo $user->getActive(); ?> </div>
<div> uuid: <?php echo $user->getId(); ?> </div>

<a href="/users/<?php echo $user->getId(); ?>/edit" class="btn btn-success">Edit</a>