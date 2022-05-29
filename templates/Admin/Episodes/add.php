<?php $this->assign('title', 'Thêm tập phim'); ?>
<style>
    .hidden {
        display: none;
    }
</style>
<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-md-6 col-lg-6">
            <h2 class="sub-header">Thêm tập phim</h2>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="pull-right">
                <?= $this->Form->button('Thêm', ['class' => 'btn btn-md btn-outline-success', 'style' => 'cursor: pointer', 'form' => 'frmAdd']) ?>
                <?= $this->Html->link('Hủy bỏ', array('_name' => 'admin_episodes_home'), array('class' => 'btn btn-md btn-outline-primary')) ?>
            </div>
        </div>
        <hr class="w-95">
        <?= $this->Form->create($episode, ['id' => 'frmAdd', 'type' => 'file', 'style' => 'width:100%']) ?>
        <div class="row ml-3 mr-3">
            <div class="form-group col-md-12">
                <?= $this->Form->control('movie_id', array(
                    'label' => 'Chọn phim',
                    'id' => 'movie_id',
                    'class' => 'form-control form-select',
                    'options' => $movie_lists,
                    'style' => 'text-align: center;',
                    'required' => false,
                    'autofocus',
                    'empty' => 'Vui lòng chọn phim',
                    // 'multiple'=>"multiple"
                )) ?>
            </div>
            <div class="form-group col-md-12">
                <?= $this->Form->control('link_film', array(
                    'label' => 'Link phim',
                    'id' => 'link-film',
                    'class' => 'form-control',
                    'type' => 'text',
                    'required' => false
                )) ?>
            </div>
            <div class="form-group col-md-12 hidden" id="episodes">
                <label for="episode">Tập phim (số tập / Tổng số)</label><br>
                <?= $this->Form->input('episode', array(
                    'id' => 'episode',
                    // 'class' => 'form-control',
                    'readonly' => true,
                    'required' => false,
                    'style' => 'width:50px; text-align: center',
                )) ?>
                / <span id="total_epi"></span>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php $flash = $this->Flash->render();
if ($flash) :
?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: `success`,
                title: `Thêm dữ liệu thành công`,
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
                title: `Vui lòng thử lại. Thêm không thành công!`,
                timer: 5000
            })
        })
    </script>
<?php endif; ?>
<script>
    $(document).ready(function() {
        $('#movie_id').select2();

        $('#movie_id').change(function() {
            val = $(this).val();

            $.ajax({
                url: '<?php echo $this->Url->build(['_name' => 'admin_episodes_total']) ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    _csrfToken: $("meta[name=csrfToken]").attr('content'),
                    id: val
                },
                success: function(response) {
                    if (response.data['category_id'] == 3 || response.data['category_id'] == 9) {
                        $('#episodes').removeClass('hidden');
                        if (response.data['category_id'] == 9) {
                            $('#total_epi').html('???');
                        } else {
                            $('#total_epi').html(response.data['total_episode']);
                        }
                        $('#episode').val(response.data['episode_next'])
                    } else {
                        $('#episodes').addClass('hidden');
                        $('#episode').val('')
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        })
    });
</script>
<?php echo $this->Html->script(['sweetalert2']) ?>