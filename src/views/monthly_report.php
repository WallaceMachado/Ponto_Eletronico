<main class="content">
	<?php
		renderTitle(
			'Relatório Mensal',
			'Acompanhe seu saldo de horas',
			'icofont-ui-calendar'
		);
	?>
	<div>

    <form class="mb-4" action="#" method="post">
			<select name="period" class="form-control" placeholder="Selecione o período...">
					<?php
						foreach($periods as $key => $month) {
							
							echo "<option value='{$key}'>{$month}</option>";
						}
					?>
				</select>
				<button class="btn btn-primary ml-2">
					<i class="icofont-search"></i>
				</button>
			</div>
		</form>
		

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<th>Dia</th>
				<th>Entrada 1</th>
				<th>Saída 1</th>
				<th>Entrada 2</th>
				<th>Saída 2</th>
				<th>Saldo</th>
			</thead>
			<tbody>
				<?php foreach($report as $registry): ?>
					<tr>
						<td><?= formatarDataComLocale($registry->work_date,'%A, %d de %B de %Y')?></td>
						<td><?= $registry->time1 ?></td>
						<td><?= $registry->time2 ?></td>
						<td><?= $registry->time3 ?></td>
						<td><?= $registry->time4 ?></td>
						<td><?= $registry->obterSaldo() ?></td>
					</tr>
				<?php endforeach ?>
				<tr class="bg-primary text-white">
					<td>Horas Trabalhadas</td>
					<td colspan="3"><?= $somadeHorasTrabalhadas ?></td>
					<td>Saldo Mensal</td>
					<td><?= $saldo ?></td>
				</tr>
			</tbody>	
		</table>
	</div>
</main>

