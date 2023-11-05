<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 11/3/2023
 */

defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#customer_group_modal">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        New Visa Type Category
                    </a>
                </div>

                <div class="panel_s">
                    <div class="panel-body panel-table-full">
                        <?php render_datatable([
                                '#',
                        _l('customer_group_name'),
                        _l('contact_active'),
                        'Created At',
                        ], 'visa-type-category'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="customer_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title">Visa type category</span>
                </h4>
            </div>
            <?php echo form_open('admin/clients/visa_type_category', ['id' => 'customer-group-modal']); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name', 'Visa Type Category name'); ?>
                        <?php render_yes_no_option('active', 'Active') ?>
                        <?php echo form_hidden('id'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load',function(){
        appValidateForm($('#customer-group-modal'), {
            name: 'required',
            active: 'required',
        }, manage_customer_groups);

        $('#customer_group_modal').on('show.bs.modal', function(e) {
            var invoker = $(e.relatedTarget);
            var group_id = $(invoker).data('id');
            $('#customer_group_modal input[name="id"]').val('');
            $('#customer_group_modal input[name="name"]').val('');
            $("[name='settings[active]']").attr('checked', false);

            let selectedColumnNameValue = $(invoker).parents('tr').find('td').eq(1).text();
            let selectedColumnBooleanValue = $(invoker).parents('tr').find('td').eq(2).text();
            let setSelectedRadio = (selectedColumnBooleanValue == 'Active') ? 1 : 2;
            let radioIdToChecked = "#y_opt_"+ setSelectedRadio +"_Active";

            console.log(selectedColumnBooleanValue)

            // is from the edit button
            if (typeof(group_id) !== 'undefined') {
                $('#customer_group_modal input[name="id"]').val(group_id);
                $('#customer_group_modal .add-title').addClass('hide');
                $('#customer_group_modal .edit-title').removeClass('hide');
                $('#customer_group_modal input[name="name"]').val(selectedColumnNameValue);
                $(radioIdToChecked).attr('checked', true);
            }
        });
    });
    function manage_customer_groups(form) {
        var data = $(form).serialize();
        var url = form.action;
        console.log({data,url})
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-visa-type-category')){
                    $('.table-visa-type-category').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#customer_group_modal').modal('hide');
        });
        return false;
    }

</script>





<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-visa-type-category', window.location.href, [1], [1]);
});
</script>
</body>

</html>