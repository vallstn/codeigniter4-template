<table class="table table-hover">
    <?= $this->include('_table_head') ?>
    <tbody>
    <?php if (isset($districts) && count($districts)) : ?>
		<?php $slno = ($pager->getcurrentPage() - 1)*$pager->getperPage() + 1; ?>
        <?php foreach ($districts as $district) : ?>
            <tr>
                <?php if (auth()->user()->can('users.delete')): ?>
                    <td>
                        <input type="checkbox" name="selects[<?= $district->DistrictCode ?>]" class="form-check">
                    </td>
					<td><?php echo $slno; $slno++; ?></td>
                <?php endif ?>
                <?= view('Dashboard\RevDB\Views\_row_info', ['district' => $district]) ?>
            </tr>
        <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>

<?php if (auth()->user()->can('users.delete')) : ?>
    <input type="submit" value="Delete Selected" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
	<p> Total Number of Records = <?php echo $pager->gettotal(); ?></p>
    <?= $pager->links('default', 'bonfire_full') ?>
</div>
