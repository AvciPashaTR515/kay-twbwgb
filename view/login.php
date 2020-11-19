<?php require 'static/header.php' ?>

<?php if (isset($error)): ?>
    <div class="error">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="success">
        <?= $success ?>
    </div>
<?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
        <h4>Giriş yap</h4>
        <label for="username">Kullanıcı adınız</label>
        <input type="text" name="username" value="<?=post('username')?>" id="username">
        <br><br>
        <label for="password">Şifreniz</label>
        <input type="password" name="password" id="password"> <br><br>
        <input type="hidden" name="submit" value="1">
        <button type="submit">Giriş yap</button>
    </form>

<?php require 'static/footer.php' ?>