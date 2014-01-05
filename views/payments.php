<h2>Payments</h2>

<ul>
	<li><a href="<?=Config::SITE_PREFIX?>/account">Account</a></li>
	<li><a href="<?=Config::SITE_PREFIX?>/methods">Methods</a></li>
	<li><a href="<?=Config::SITE_PREFIX?>/payments">Payments</a></li>
</ul>

Pay:
<form method="post">
	<label>
		<div>Method:</div>
		<select name="method">
			<?php foreach($methods as $method) { ?>
				<option value="<?=$method["id_method"]?>" <?php if($formId == $method["id_method"]) echo "selected"; ?>><?=$method["name"]?>; comission - <?=$method["comission"]?>%</option>
			<?php } ?>
		</select>
	</label>
	<label>
		<div>Price:</div>
		<input type="text" name="price" value="<?=$formPrice?>" />
	</label>
	<label>
		<div>
			<input type="submit" name="add">
		</div>
	</label>
</form>

<a href="<?=Config::SITE_PREFIX?>/payments">All your payments</a>
<div class="methods">
	<h3>View all payments for method: </h3>
	<ul>
		<?php foreach($methods as $method) { ?>
			<li><a href="<?=Config::SITE_PREFIX?>/payments/<?=$method["id_method"]?>"><?=$method["name"]?></a></li>
		<?php } ?>
	</ul>
</div>

<table class="payments">
	<tr>
		<td>Price</td>
		<td>Original price</td>
		<td>Method</td>
	</tr>
	<?php foreach($payments as $payment) { ?>
		<tr>
			<td><?=$payment["price"]?></td>
			<td><?=$payment["originalPrice"]?></td>
			<td><?=$payment["name"]?></td>
		</tr>
	<?php } ?>
</table>