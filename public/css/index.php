<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

$this->title = 'My Yii Application';
?>

<div class="table">

		<h4 class="caption">Общий график отпусков</h4>
		<hr>
		<a href="/add"><button class='btn-primary' >Добавить отпуск</button></a>
		<table class="data">
		<tbody>
			<tr>
            <td  class='val-2'><h4>№</h4></td>
			<td  class='val-2'><h4>ФИО</h4></td>
			<td  class='val-2'><h4>Должность</h4></td>
			<td  class='val-2'><h4>Дата начала отпуска</h4></td>
			<td  class='val-2'><h4>Дата конца отпуска</h4></td>
			<?php if(isset($_SESSION['user'])): ?>
			<td  class='val-2'><h4>Изменение</h4></td>
			<?php endif; ?>
				<td  class='val-2'><h4>Утверждение</h4></td>
			<?php foreach($dataList as $val): ?>
				</tr>
				<?php $i++; ?>
				<tr>
                <td class='val'><?php echo $i?>	
				</td>
				<td class='val'><?php echo $val['fio']?>	
				</td>
				<td class='val'><?php echo $val['post'];?>	
				</td>
				<td class='val-2'><?php echo $val['start_vacation'];?>	
				</td>
				<td class='val-2'><?php echo $val['end_vacation'];?>	
				</td>
				<?php if(isset($_SESSION['user'])): ?>
					<td class='val-2'>
				<?php endif; ?>
					<?php if($val['user_name'] == $user and($val['fixed'] != 'true')): ?>
						<a href="/change?id=<?php echo $val['id']?>"><button class='btn-change' value=<?php echo $val['id'] ?>>Изменить</button></a>
					<?php endif; ?>
				<?php if(isset($_SESSION['user'])): ?>
					</td>
				<?php endif; ?>
				<td class='val-2'>
					<?php if($role == 'employer' and ($val['fixed'] != 'true')): ?>
						<?php
							ActiveForm::begin(['class'=>'form-horizontal']);
						?>
							<?= Html::submitButton('Утвердить', ['name' => 'approve', 'value' => $val['id'], 'class'=>'btn-success']) ?>
						<?php
							ActiveForm::end();
						?>

					<?php elseif($val['fixed'] == 'true'): ?>
						<p class='success'>Утвержден</p>
					<?php else: ?>
						<p class='fail'>Не утвержден</p>
					<?php endif; ?>
					
				</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	