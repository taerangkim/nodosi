<script>
    function loadfrm()
    {
        $('#reviewModal').modal('show');
    }
</script>
<button type="button" onclick="loadfrm()">사진폼</button>

<div class="modal" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">리뷰 글쓰기</h5>
            </div>
            <div class="modal-body">
                <form name="reviewfrm" id="reviewfrm" enctype="multipart/form-data" method="post" action="/review/reviewWrite">
                    <input type="hidden" name="reviewlistjson" id="reviewlistjson" value="">
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px;padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">이름</label>
                        <div class="col-sm-9">
                            <input type="text" name="NickName" id="NickName" value="" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">제목</label>
                        <div class="col-sm-9">
                            <input type="text" name="Title" id="Title" class="form-control form-control-sm" placeholder="제목을 입력하세요.">
                        </div>
                    </div>
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">평점</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm" id="Count" name="Count">
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">내용</label>
                        <div class="col-sm-9">
                            <textarea class="form-control form-control-sm" id="Content" name="Content" cols="30" rows="10" placeholder="내용을 입력하세요"></textarea>
                        </div>
                    </div>
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">파일</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="fileNum" id="fileNum">
                            <input type="file" name="Image[]" multiple="multiple" id="Image" accept="image/png, image/jpeg" onchange="setThumnail(event);">
                            <div id="Image_container">
                            </div>
                            <script>

                            </script>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:Cancel()">취소</button>
                <button type="submit" class="btn btn-primary" id="reviewfrmbtn">저장</button>
            </div>
            </form>
        </div>
    </div>
</div>