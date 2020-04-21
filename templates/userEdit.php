<div class="container">
    <h1>User</h1>
    <form id="user-edit-form" data-user-exists="<?php echo $userExists; ?>">

        <?php if ($userExists): ?>
        <div class="form-group">
            <label for="user-uuid">uuid</label>
            <input type="text" name="uuid" class="form-control" disabled id="user-uuid" value="<?php echo $user["uuid"]; ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="exampleInputEmail1">Login</label>
            <input type="email" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $user["login"]; ?>"  >
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>

        <?php if ($userExists): ?>
        <div class="form-group form-check">
            <input type="checkbox" name="active" class="form-check-input" id="exampleCheck1" <?php if ($user["active"]) echo "checked" ?>>
            <label class="form-check-label" for="exampleCheck1">Active</label>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
