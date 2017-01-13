<h2>Login</h2>
<form action="login.php" method="POST">
    <p>
        <label class="label" for="email">Email address:*</label>
        <input id="email" type="email" name="email" size="30" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required>
    </p>

    <p>
        <label class="label" for="psword">Password:*</label>
        <input id="psword" type="password" name="psword" size="12" maxlength="12" value="" required>
        <span>&nbsp;Between 6 and 12 characters.</span> 
    </p>
    
    <p>
        <input id="submit" type="submit" name="submit" value="Login">
    </p>
</form>
<br />