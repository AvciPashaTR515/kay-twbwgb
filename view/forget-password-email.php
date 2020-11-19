<div style="padding: 30px; border: 1px solid #ccc;">
    Sayın <strong><?=$user['user_name']?></strong>, <br>
    Şifrenizi sıfırlama talebinde bulundunuz. Eğer bunu siz yapmadıysanız, bu maili dikkate almayın.
    <br><br>
    Sıfırlama linkiniz aşağıdadır. <br><br>
    <a href="<?= site_url('forget-password/' . $token) ?>"><?= site_url('forget-password/' . $token) ?></a>
</div>