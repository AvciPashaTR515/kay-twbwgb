<?php require 'static/header.php' ?>

<?php if (session('login')): ?>
    <p>
        Hoşgeldin, <strong><?= session('username') ?></strong>
        <a href="<?= site_url('logout') ?>">[Çıkış yap]</a>
    </p>

    <?php if (get('msg') == 'activation_success'): ?>
    <div class="success">
        Hesabınız başarıyla aktifleştirildi. Bizi kullanmaya başlayabilirsiniz :)
    </div>
    <?php endif; ?>

    <?php if (session('activation') == 0): ?>
        <div class="info">
            Aktivasyon mailini tekrar almak için <a href="<?= site_url('resend-activation/send') ?>">tıklayın</a>
        </div>
    <?php endif; ?>

<?php else: ?>
    <a href="<?= site_url('register') ?>">Kayıt ol</a> | <a href="<?= site_url('login') ?>">Giriş yap</a> | <a href="<?= site_url('forget-password') ?>">Şifremi Unuttum</a>
<?php endif; ?>

<?php require 'static/footer.php' ?>