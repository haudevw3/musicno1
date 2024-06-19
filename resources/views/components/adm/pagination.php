<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
            if (! empty($pagination)) {
                ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $pagination['prev_page_url'] ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php
                for ($i = 1; $i <= $pagination['last_page']; $i++) {
                    ?>
                        <li class="page-item <?php echo ($pagination['current_page'] == $i) ? 'active' : null ?>"><a class="page-link" href="<?php echo $pagination['path'].$i ?>"><?php echo $i ?></a></li>
                    <?php
                }
                ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $pagination['next_page_url'] ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php
            }
        ?>
    </ul>
</nav>