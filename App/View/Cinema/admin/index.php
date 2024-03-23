<header>
    <h1>Liste des cinémas</h1>
    <a href="<?= self::$_Router->getUrl('admin_cinema_add') ?>" class="btn btn-sm btn-warning">Ajouter un cinema</a>
</header>
<table class="table table-striped align-middle">
    <thead class="table-light">
    <tr>
        <th>Nom</th>
        <th>Ville</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody >

    <?php foreach($cinemas as $cinema): ?>

        <tr>
            <td><?= $cinema->nom ?></td>
            <td><?= $cinema->ville ?></td>
            <td>
                <nav class="action-menu">
                    <ul>
                        <li><a href="<?= self::$_Router->getUrl("admin_cinema_edit",['id' => $cinema->id]) ?>">Editer</a></li>
                        <li>Supp</li>
                    </ul>
                </nav>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>

    <tfoot>
    <tr>
        <td colspan="6">Pagination</td>
    </tr>
    </tfoot>
</table>
