<?php

namespace App\Admin\Extensions\Tools;
 
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;

class CsvImport extends AbstractTool
{
    /**
     * Set up script for import button.
     */
    protected function script()
    {
        return <<< SCRIPT

        // ボタン押下でCSVインポート
        $('.csv-import').click(function() {
            var select = document.getElementById('files');
            document.getElementById("files").click();
            select.addEventListener('change',function() {
                var fd = new FormData();
                fd.append( "file", $("input[name='user']").prop("files")[0] );
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type : "POST",
                    url : "/admin/users/import",
                    data : fd,
                    processData : false,
                    contentType : false,
                    success: function (response) {
                        $.pjax.reload("#pjax-container");
                        toastr.success('アップロード成功');
                    }
                });
            });
        });

        SCRIPT;
    }
     
    /**
     * Render Import button.
     *
     * @return string
     */
    public function render()
    {
            Admin::script($this->script());

            return view('csv_upload');
    }
}