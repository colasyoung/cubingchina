<?php $this->renderPartial('operation', $_data_); ?>
<div class="col-lg-12 competition-<?php echo strtolower($competition->type); ?>">
	<dl>
		<?php if ($competition->type == Competition::TYPE_WCA): ?>
		<dt><?php echo Yii::t('Competition', 'WCA Competition'); ?></dt>
		<dd>
			<?php echo Yii::t('Competition', 'This competition is recognized as an official World Cube Association competition. Therefore, all competitors should be familiar with the {regulations}.', array(
			'{regulations}'=>CHtml::link(Yii::t('Competition', 'WCA regulations'), $competition->getWcaRegulationUrl(), array('target'=>'_blank')),
		));?>
		</dd>
		<?php endif; ?>
		<?php if ($competition->wca_competition_id != ''): ?>
		<dt><?php echo Yii::t('Competition', 'WCA Official Page'); ?></dt>
		<dd><?php echo CHtml::link($competition->getWcaUrl(), $competition->getWcaUrl(), array('target'=>'_blank')); ?>
		<?php endif; ?>
		<dt><?php echo Yii::t('Competition', 'Date'); ?></dt>
		<dd><?php echo $competition->getDisplayDate(); ?></dd>
		<dt><?php echo Yii::t('Competition', 'Location'); ?></dt>
		<dd>
			<?php $this->renderPartial('locations', $_data_); ?>
		</dd>
		<dt><?php echo Yii::t('Competition', 'Organizers'); ?></dt>
		<dd>
			<?php if ($competition->isOld()): ?>
			<?php echo OldCompetition::formatInfo($competition->old->getAttributeValue('organizer')); ?>
			<?php else: ?>
			<?php foreach ($competition->organizer as $key=>$organizer): ?>
			<?php if ($key > 0) echo Yii::t('common', ', '); ?>
			<?php echo CHtml::mailto(Html::fontAwesome('envelope', 'a') . $organizer->user->getAttributeValue('name', true), $organizer->user->email); ?>
			<?php endforeach; ?>
			<?php endif; ?>
		</dd>
		<?php if ($competition->delegate !== array() && !$competition->multi_countries): ?>
		<dt><?php echo Yii::t('Competition', $competition->type == Competition::TYPE_WCA ? 'Delegates' : 'Main Judge'); ?></dt>
		<dd>
			<?php foreach ($competition->delegate as $key=>$delegate): ?>
			<?php if ($key > 0) echo Yii::t('common', ', '); ?>
			<?php echo CHtml::mailto(Html::fontAwesome('envelope', 'a') . $delegate->user->getAttributeValue('name', true), $delegate->user->email); ?>
			<?php endforeach; ?>
		</dd>
		<?php elseif ($competition->isOld() && $competition->old->getAttributeValue('delegate')): ?>
		<dt><?php echo Yii::t('Competition', $competition->type == Competition::TYPE_WCA ? 'Delegates' : 'Main Judge'); ?></dt>
		<dd>
			<?php echo OldCompetition::formatInfo($competition->old->getAttributeValue('delegate')); ?>
		</dd>
		<?php endif; ?>
		<dt><?php echo Yii::t('Competition', 'Events'); ?></dt>
		<dd>
			<?php echo implode(Yii::t('common', ', '), array_map(function($event) use ($competition) {
				return Yii::t('event', $competition->getFullEventName($event));
			}, array_keys($competition->getRegistrationEvents()))); ?>
		</dd>
		<?php if (!$competition->multi_countries): ?>
		<dt><?php echo Yii::t('Competition', 'Entry Fee'); ?>
			<?php if ($competition->tba == Competition::NO): ?>
			<?php echo CHtml::tag('span', array(
				'class'=>'btn btn-xs btn-primary',
				'id'=>'expand-fee',
			), Html::fontAwesome('plus') . 'more'); ?>
			<?php endif; ?>
		</dt>
		<dd style="height:104px;overflow-y:hidden">
			<?php if ($competition->tba == Competition::YES): ?>
			<?php echo Yii::t('common', 'To be announced'); ?>
			<?php else: ?>
			<table>
				<thead>
					<tr>
						<th><?php echo Yii::t('Competition', 'Events'); ?></th>
						<th><?php echo $competition->firstStage; ?></th>
						<?php if ($competition->hasSecondStage): ?>
						<th><?php echo $competition->secondStage; ?></th>
						<?php endif; ?>
						<?php if ($competition->hasThirdStage): ?>
						<th><?php echo $competition->thirdStage; ?></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo Yii::t('Competition', 'Base Entry Fee'); ?></td>
						<td>　<i class="fa fa-rmb"></i><?php echo $competition->entry_fee; ?></td>
						<?php if ($competition->hasSecondStage): ?>
						<td>　<i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry', Competition::STAGE_SECOND); ?></td>
						<?php endif; ?>
						<?php if ($competition->hasThirdStage): ?>
						<td>　<i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry', Competition::STAGE_THIRD); ?></td>
						<?php endif; ?>
					</tr>
					<?php foreach ($competition->events as $key=>$value): ?>
					<?php if ($value['round'] > 0): ?>
					<tr>
						<td><?php echo Events::getFullEventName($key); ?></td>
						<td>&nbsp;+<i class="fa fa-rmb"></i><?php echo $value['fee']; ?></td>
						<?php if ($competition->hasSecondStage): ?>
						<td>&nbsp;+<i class="fa fa-rmb"></i><?php echo $competition->getEventFee($key, Competition::STAGE_SECOND); ?></td>
						<?php endif; ?>
						<?php if ($competition->hasThirdStage): ?>
						<td>&nbsp;+<i class="fa fa-rmb"></i><?php echo $competition->getEventFee($key, Competition::STAGE_THIRD); ?></td>
						<?php endif; ?>
					</tr>
					<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
		<?php if ($competition->person_num > 0): ?>
		<dt><?php echo Yii::t('Competition', 'Limited Number of Competitor'); ?></dt>
		<dd><?php echo $competition->person_num; ?></dd>
		<?php endif; ?>
		<?php if ($competition->reg_start > 0 && $competition->tba == Competition::NO): ?>
		<dt><?php echo Yii::t('Competition', 'Registration Starting Time'); ?></dt>
		<dd>
			<?php echo date('Y-m-d H:i:s', $competition->reg_start); ?>
			<?php if (time() < $competition->reg_start): ?>
			<?php echo Html::countdown($competition->reg_start); ?>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
		<?php if ($competition->tba == Competition::NO): ?>
		<dt><?php echo Yii::t('Competition', 'Registration Ending Time'); ?></dt>
		<dd>
			<?php echo date('Y-m-d H:i:s', $competition->reg_end); ?>
			<?php if (time() > $competition->reg_start && !$competition->isRegistrationFull() && !$competition->isRegistrationEnded()): ?>
			<?php echo Html::countdown($competition->reg_end, [
				'data-total-days'=>$competition->reg_start > 0 ? floor(($competition->reg_end - $competition->reg_start) / 86400) : 30,
			]); ?>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
		<?php if (trim(strip_tags($competition->getAttributeValue('information'), '<img>')) != ''): ?>
		<dt><?php echo Yii::t('Competition', 'About the Competition'); ?></dt>
		<dd>
			<?php echo $competition->getAttributeValue('information'); ?>
		</dd>
		<?php endif; ?>
	</dl>
	<?php $this->renderPartial('disclaimer'); ?>
</div>
