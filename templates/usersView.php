<div class="container">
    <a href="/users/create" class="btn btn-success">Create new User</a>

    <nav aria-label="Page navigation example">
        <ul class="pagination">

            <?php if ($page >= 1): ?>
                <li class="page-item">
                    <span
                        class="page-link"
                        data-page="<?= $page ?>"
                        data-limit="<?= $limit ?>">
                        Previous
                    </span>
                </li>
            <?php endif ?>

            <?php for ($i = $page - 5; $i < $page + 5; $i++): ?>
                <?php if ($i >= 0): ?>
                    <li class="page-item">
                        <span class="page-link"
                            data-page="<?= $i ?>"
                            data-limit="<?= $limit ?>"
                        >
                            <?= $i + 1 ?>
                        </span>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>

            <li class="page-item">
                <span
                    class="page-link"
                    data-page="<?= $page ?>"
                    data-limit="<?= $limit ?>">
                    Next
                </span>
            </li>
        </ul>
    </nav>
</div>

<div id='users-list' class='row'></div>
