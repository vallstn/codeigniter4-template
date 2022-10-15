<td><a href="<?= $district->adminLink($district->dcode) ?>"><?= esc($district->ename) ?></a></td>
<td><?= $district->tname ?></a></td>
<td><?= $district->sname ?></a></td>
<td><?= $district->agricode ?></a></td>

<td class="d-flex justify-content-end">
    <?php if (auth()->user()->can('users.edit') || auth()->user()->can('users.delete')): ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button"  data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('users.edit')) : ?>
                    <li><a href="<?= $district->adminLink('edit') ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('users.delete')): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="<?= $district->adminLink('delete') ?>" class="dropdown-item"
                        onclick="return confirm(<?= lang('Bonfire.deleteResource', ['district']) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>
