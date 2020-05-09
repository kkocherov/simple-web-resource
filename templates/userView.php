<h1> User </h1>

<div> login: <?php echo $user["login"]; ?> </div>
<div> active: <?php echo $user["active"]; ?> </div>
<div> uuid: <?php echo $user["id"]; ?> </div>

<a href="/users/<?php echo $user["id"]; ?>/edit" class="btn btn-success">Edit</a>