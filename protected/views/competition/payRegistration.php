<?php if ($registration->payable): ?>
<hr>
<h4><?php echo Yii::t('Registration', 'Pending Events'); ?></h4>
<p><?php echo $registration->getPendingEvents(); ?></p>
<h4><?php echo Yii::t('common', 'Fee'); ?></h4>
<p><?php echo $registration->getPendingFee(); ?></p>
<?php if (count(Yii::app()->params->payments) > 1): ?>
<h4><?php echo Yii::t('common', 'Please choose a payment channel.'); ?></h4>
<?php endif; ?>
<div class="pay-channels clearfix">
  <?php foreach (Yii::app()->params->payments as $channel=>$payment): ?>
  <div class="pay-channel pay-channel-<?php echo $channel; ?>" data-channel="<?php echo $channel; ?>">
    <img src="<?php echo $payment['img']; ?>">
  </div>
  <?php endforeach; ?>
  <?php if ($this->user->country_id > 1 && $competition->paypal_link): ?>
  <div class="pay-channel pay-channel-<?php echo $channel; ?>">
    <a href="<?php echo $competition->getPaypalLink($registration); ?>" target="_blank">
      <img src="/f/images/pay/paypal.png">
    </a>
    <p class="text-danger"><?php echo Yii::t('Registration', 'Payment via Paypal is not accepted automatically. Please wait patiently if you\'ve already paid. We will accept your registration soon.'); ?></p>
  </div>
  <?php endif; ?>
</div>
<p class="hide lead text-danger" id="redirect-tips">
  <?php echo Yii::t('common', 'Alipay has been blocked by wechat.'); ?><br>
  <?php echo Yii::t('common', 'Please open with browser!'); ?>
</p>
<p class="text-danger"><?php echo Yii::t('common', 'If you were unable to pay online, please contact the organizer.'); ?></p>
<div class="text-center">
  <button id="pay" class="btn btn-lg btn-primary"><?php echo Yii::t('common', 'Pay'); ?></button>
</div>
<div class="hide text-center" id="pay-tips">
  <?php echo CHtml::image('https://i.cubingchina.com/animatedcube.gif'); ?>
  <br>
  <?php echo Yii::t('common', 'You are being redirected to the payment, please wait patiently.'); ?>
</div>
<?php endif; ?>
