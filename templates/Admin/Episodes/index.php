<?php $this->assign('title', 'Quản lý tập phim') ?>
<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-lg-12 col-md-12">
            <h2 class="sub-header mb-3" style="display:flex">Quản lý phim theo tập</h2>
            <div class="box-tools" style=" width:100%; display:flex; justify-content: center">
                <form action="<?php echo $this->Url->build(['_name' => 'admin_episodes_search']) ?>" method="get">
                    <div class="input-search input-group" style="width: 50vw;">
                        <input type="text" name="query" class="form-control pull-right" id="query" placeholder="Nhập nội dung tìm kiếm">
                        <div class="button-search input-group-btn">
                            <button type="submit" class="btn btn-primary search-icon" style="
                            border-top-right-radius: 7px 7px;
                            border-bottom-right-radius: 7px 7px;
                        "><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <div class="dropdown pull-left mb-2">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Danh sách hiển thị
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="<?php echo $this->Url->build(array('_name' => 'admin_episodes_home')) ?>" class="dropdown-item <?php echo count($episodes) == 10 ? 'active' : '' ?>">10</a>
                        <a href="?limit=25" class="dropdown-item <?php echo count($episodes) == 25 ? 'active' : '' ?>">25</a>
                        <a href="?limit=50" class="dropdown-item <?php echo count($episodes) == 50 ? 'active' : '' ?>">50</a>
                        <a href="?limit=100" class="dropdown-item <?php echo count($episodes) == 100 ? 'active' : '' ?>">100</a>
                    </div>
                </div>
                <div class="pull-right mb-2">
                    <a href="<?= $this->Url->build(array('_name' => 'admin_episodes_create')) ?>" class="btn btn-sm btn-outline-primary w-10 btn-add"><i class="fa-solid fa-plus"></i></a>
                    <a class="btn btn-sm btn-outline-primary w-10 btn-down"><i class="fa-solid fa-download"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Tên phim</th>
                            <th>Tập phim</th>
                            <th>Link phim</th>
                            <th>Khác</th>
                        </tr>
                    </thead>
                    <tbody id="sortTable">
                        <?php foreach ($episodes as $episode) : ?>
                            <tr>
                                <td><?= $episode->id ?></td>
                                <td style="width:300px"><?= @h($episode->movie->m_name) ?></td>
                                <td><?= !empty($episode->episode) ? $episode->episode : 'FULL' ?></td>
                                <td style="width:300px">
                                    <?= $episode->link_film ?>
                                    <iframe width="500" height="315" src="<?= $episode->link_film ?>" title="YouTube video player" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                                </td>
                                <td>
                                    <a href=<?= $this->URL->build(array("_name" => 'admin_episodes_edit', 'id' => $episode->id)) ?> class="btn btn-warning" id="edit-btn">Sửa</a>
                                    <?= $this->Form->postLink(
                                        __('Xóa'),
                                        ['_name' => 'admin_episodes_delete', 'id' => $episode->id],
                                        [
                                            'confirm' => __('Bạn có chắc muốn xóa tập "{0}" của bộ phim "{1}" hay không?', empty($episode->episode) ? '1' : $episode->episode, @h($episode->movie->m_name)),
                                            'class' => 'btn btn-danger',
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <ul class="pagination">
                <?php
                echo $this->Paginator->first();
                if ($this->Paginator->hasPrev()) {
                    echo $this->Paginator->prev();
                }
                echo $this->Paginator->numbers();
                if (!empty($this->Paginator->next())) {
                    echo $this->Paginator->next();
                }
                echo $this->Paginator->last();
                ?>
            </ul>
        </div>
    </div>
</div>

<?php $flash = $this->Flash->render();
if ($flash) :
?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: `success`,
                title: `Xóa thành công`,
                timer: 5000
            })
        })
    </script>
<?php endif; ?>
<?php if (isset($error)) : ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: `error`,
                title: `Vui lòng thử lại. Xóa không thành công!`,
                timer: 5000
            })
        })
    </script>
<?php endif; ?>
<script>
    var csrfToken = $('meta[name="csrfToken"]').attr('content');
    var id_arr = [];
    $("#sortTable").sortable({
        placeholder: 'ui-state-highlight',
        update: function(event, ui) {
            $('#sortTable tr').each(function() {
                id_arr.push($(this).attr('id'));
            })

            ajaxChange(id_arr);
        }
    });

    var ajaxChange = function(id_arr) {
        fetch("<?php echo $this->Url->build(['_name' => 'admin_change_number_category']); ?>", {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                method: "POST",
                body: JSON.stringify({
                    ids: id_arr
                })
            })
            .then(function(res) {
                Swal.fire({
                        icon: `success`,
                        title: `Sắp xếp thành công!`,
                        timer: 5000
                    })
                    .then(function() {
                        location.reload();
                    });
            })
            .catch(function(res) {
                console.log(res)
            })
    }
</script>
<?php echo $this->Html->script(['sweetalert2']) ?>