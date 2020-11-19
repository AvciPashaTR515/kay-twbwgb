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

    <form action="" method="post">
        <h4>Şifreni Sıfırla</h4>
        <p>
            Merhaba <?=$row['user_name']?>, yeni şifreni artık belirleyebilirsin.
        </p>
        <label for="password">Yeni Şifreniz</label>
        <input type="password" name="password" id="password"> <br><br>
        <label for="repassword">Yeni Şifreniz (Tekrar)</label>
        <input type="password" name="repassword" id="repassword"> <br><br>
        <input type="hidden" name="submit" value="1">
        <button type="submit">Sıfırla</button>
    </form>

<?php require 'static/footer.php' ?>