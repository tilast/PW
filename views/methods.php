<div>
	<ul>
		<li><a href="<?=Config::SITE_PREFIX?>/account">Account</a></li>
		<li><a href="<?=Config::SITE_PREFIX?>/methods">Methods</a></li>
		<li><a href="<?=Config::SITE_PREFIX?>/payments">Payments</a></li>
	</ul>
</div>

<h3><?php echo $formId ? 'Edit' : 'Add' ?> method</h3>
<div class="addMethod">
	<form method="post">
		<label>
			<div>Type:</div>
			<select name="type">
				<option value="1" <?php if($formType == 1) echo "selected"; ?>>Credit card</option>
				<option value="2" <?php if($formType == 2) echo "selected"; ?>>Bank account</option>
			</select>
		</label>
		<label>
			<div>Name:</div>
			<input type="text" name="name" value="<?=$formName?>" />
		</label>
		<label>
			<div>Comission:</div>
			<select name="comission">
				<?php for($i = 0; $i < 100; $i += 5) { ?>
					<option value="<?=$i?>" <?php if($formComission == $i) echo "selected"; ?> >
						<?=$i?>%
					</option>
				<?php } ?>
			</select>
		</label>		
		<label>
			<div>
				<input type="submit" name="method" value="<?php echo $formId ? 'Edit' : 'Add' ?>">
			</div>
		</label>
		<input type="hidden" name="id" value="<?=$formId?>">
	</form>
</div>

<?php if($showMethods) { ?>
	<h3>Your methods</h3>
	<div class="methods">
		<table>
			<tr>
				<td>ID</td>
				<td>Type</td>
				<td>Name</td>
				<td>Comission</td>
				<td></td>
				<td></td>
			</tr>
			<?php foreach($methods as $method) { ?>
				<tr>
					<td><?=$method["id_method"]?></td>
					<td>
						<?php if($method["type"] == 1) { ?>
							Credit Card
						<?php } else { ?>
							Bank Account
						<?php } ?>
					</td>
					<td><?=$method["name"]?></td>
					<td><?=$method["comission"]?>%</td>
					<td><button><a href="<?=Config::SITE_PREFIX?>/methods/<?=$method["id_method"]?>">Edit</a></button></td>
					<td>
						<form method="post">
							<input type="submit" value="Delete" name="delete">
							<input type="hidden" name="id" value="<?=$method["id"]?>">
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>