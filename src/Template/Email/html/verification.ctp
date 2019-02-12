<div style="padding: 5px 20px; border-top: 1px solid rgba(0,0,0,0.05);">
    <h3 style="margin-top: 10px;">Hi<?php echo !empty($name) ? ', ' . $name : ''; ?></h3>
    <p>&nbsp;</p>
    <div style="color: #636363; font-size: 14px;">
        <p>Kamu telah mendaftarkan email </p>
        <p><?= __d('MemberPanel', 'To reset your password, follow this link:'); ?></p>
        <p><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'reset',$code], true); ?>" style="padding:8px 20px;background-color:#4b72fa;color:#fff;font-weight:bolder;font-size:16px;display:inline-block;margin:20px 0px;text-decoration:none"><?= __d('MemberPanel', 'RESET PASSWORD'); ?></a> </p>
        <p><?= __d('MemberPanel', 'You received this email, because it was requested by a Nevix user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same'); ?>,</p>
        <p>&nbsp;</p>
        <p><?= __d('MemberPanel', 'Thank you'); ?>,</p>
        <p>Nevix Team</p>
        <p>&nbsp;</p>
    </div>
</div>