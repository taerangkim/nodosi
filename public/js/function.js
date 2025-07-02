function gfn_ajaxpost(url, data, callback)
{
    $( function() {
        jQuery.ajax({
            type:"POST",
            //data: {data:"1", data1:"2"},
            data: data,
            dataType:"json",
            url:url,
            success : function(data) {
                callback(data);
            },
            complete : function(data) {
                // TODO
            },
            error : function(xhr, status, error) {
                alert("에러발생");
            }
        });
    } );
}