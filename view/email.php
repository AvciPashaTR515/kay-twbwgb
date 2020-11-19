<div style="padding: 30px; border: 1px solid #ccc;">
    Sayın <strong><?=$username?></strong>, <br>
    Sitemize kayıt olduğunuz için teşekkür ederiz. Lütfen hesabınızı aşağıdaki linke girerek onaylayın.
    <br><br>
    <a href="<?= site_url('activation/' . $activation) ?>"><?= site_url('activation/' . $activation) ?></a>
</div>