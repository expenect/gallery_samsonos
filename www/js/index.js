/** Handler will be called when DOM will load and body will be available */
s(document.body).pageInit(function(body){
    s('.btn_update').ajaxClick(function(response){
        console.log(response.status);
        console.log(response.list);
    });
});

function edit(btn){
    btn.tinyboxAjax({
        // Set the response container name
        html : 'form',
        // Close tinybox on click elsewhere besides the box
        oneClickClose : true,
        renderedHandler : function(form, tb) {
            var uploadForm = s('form', form);
            uploadForm.ajaxSubmit(function(response){
                // Call load function after uploading the file
                load(response);
                // Close tinybox
                tb.close();
            });
        }
    });

}

var load = function(response)
{
    if (response && response.list) {
        s('.gallery-container').html(response.list);
        s('#pager').html(response.pager);
        s('#line1').html(response.sorter);
    }
    s('li a', pager).ajaxClick(load);
    s('.sorter').ajaxClick(load);
    s('.delete').ajaxClick(load, function(btn){
        return confirm(s('.delete_message', btn.parent()).val());
    });
    edit(s('.upload_btn'));
    edit(s('.edit'));
};

//Call this function when page is loaded for the firs time
s('#pager').pageInit(load);

