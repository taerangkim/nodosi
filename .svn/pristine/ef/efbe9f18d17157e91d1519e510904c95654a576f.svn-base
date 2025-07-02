<div id="stockMeta" style="display: none">
    <div class="row p-1">
        <div class="col col-3 col-form-label-sm">[RegDate]</div>
        <div class="col col-8 col-form-label-sm"><a href="javascript:;" onclick="readBoard([BIdx])">[title]</a></div>
    </div>

</div>

<div class="row bg-light pt-3" id="stockBody">
</div>

<div class="modal" id="NoticModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <div class="row"><h5 class="modal-title text-light" id="ModalTitle">재고현황</h5></div>
            </div>
            <div class="modal-body">
                <div class="row py-2">
                    <div class="col col-6" id="BoardTitle"></div>
                    <div class="col col-6 text-right" id="BoardRegDate"></div>
                </div>
                <hr class="sidebar-divider">
                <div class="row">
                    <div class="col" id="BoardContent">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#NoticModal').modal('hide');">닫기</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadData()
    {
        gfn_ajaxpost(
            '/stock/stockLoad',
            {},
            function (data) {
                console.log(data);
                html = $("#stockMeta").html();
                $.each(data, function (index, item) {
                    appendHtml = html
                        .replace('[title]', item['title'])
                        .replace('[RegDate]', item['RegDate'])
                        .replace('[BIdx]', item['BIdx'])
                    $("#stockBody").append(appendHtml);
                });
            });
    }
    $( function() {
        loadData();
    } );
/*
    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            loadData();
        }
    });
*/
    function readBoard(bidx)
    {
        gfn_ajaxpost('/ajax/ajaxBoardRead', {bidx: bidx}, function (data){
            $("#BoardTitle").html(data[0]['Title'])
            $("#BoardRegDate").html(data[0]['RegDate'])
            $("#BoardContent").html(data[0]['Content'])
            $("#NoticModal").modal('show');
        });
    }
</script>
