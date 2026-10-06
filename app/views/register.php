<div id="register-page">
    <h1>Create your account</h1>
    <form action="index.php?page=register" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <button>Register</button>
    </form>
    <div id="to-login">
        <p>Already have an account?</p>
        <a href="index.php?page=login">Log in</a>
    </div>
</div>