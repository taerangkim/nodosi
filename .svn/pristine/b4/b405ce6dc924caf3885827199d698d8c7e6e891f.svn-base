@foreach($result as $item)
<div class="row bg-light">
    <div class="card-body">
        <div class="card-title">
            <div class="row">
                <div class="col"><h5>{{$item['title']}}</h5></div>
                <hr class="sidebar-divider d-none d-md-block">
            </div>
            <div class="row">
                <div class="col col-6">
                    <i class="fa fa-user-astronaut" aria-hidden="true"></i>
                    &nbsp;&nbsp;{{$item['NickName']}}&nbsp;&nbsp;
                </div>
                <div class="col col-6" style="text-align: right">
                    @for($i=0;$i<$item['Count']; $i++)
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    @endfor
                </div>
            </div>
            <div class="row">

                <div class="col">{{$item['RegDate']}}</div>
            </div>
        </div>
        <div class="card-text">
            <div class="row pb-3">
                <hr class="sidebar-divider d-none d-md-block">
                <div class="col"><?php echo nl2br($item['Content']);?></div>
            </div>
            <div id="link" class="link">
                <div class="row pb-3">
                <hr class="sidebar-divider d-none d-md-block">
                    <?php
                        if($item['ImageName'] != NULL){
                            $ImageName = $item['ImageName'];
                            $path = $item['path'];
                            $ImageNameSplit = explode(",",$ImageName);
                            $pathSplit = explode(",",$path);
                            for($i=0;$i<count($ImageNameSplit);$i++){
                                echo '<div class="col col-4 pb-2">
                                        <a data-gallery  href="' . $pathSplit[$i] . '/' . $ImageNameSplit[$i] . '">
                                            <img src="' . $pathSplit[$i] . '/' . $ImageNameSplit[$i] . '" class="img-thumbnail">
                                        </a>
                                    </div>';
                            }
                        }
                    ?>
                </div>
                <div id="blueimp-gallery" class="blueimp-gallery" aria-label="image gallery" aria-modal="true" role="dialog">
                    <div class="slides" aria-live="polite"></div>
                    <h3 class="title"></h3>
                    <a class="prev" aria-controls="blueimp-gallery" aria-label="previous slide" aria-keyshortcuts="ArrowLeft"></a>
                    <a class="next" aria-controls="blueimp-gallery" aria-label="next slide" aria-keyshortcuts="ArrowRight"></a>
                    <a class="close" aria-controls="blueimp-gallery" aria-label="close" aria-keyshortcuts="Escape"></a>
                    <a class="play-pause" aria-controls="blueimp-gallery" aria-label="play slideshow" aria-keyshortcuts="Space" aria-pressed="false" role="button"></a>
                </div>
            </div>
            <!--
            <div class="col">
                <?php if(isset($_SESSION['MemIdx'])) { ?>
                    <?php if($_SESSION['MemIdx'] == $item['MemIdx']){ ?>
                        <button type="button" class="btn btn-primary" onclick="reviewupdateAdd();" style="font-size: small; margin-bottom: 5px">수정</button>
                        <button type="button" class="btn btn-primary" onclick="reviewDelete({{$item['BIdx']}})" style="font-size: small; margin-bottom: 5px">삭제</button>
                    <?php } ?>
                <?php } ?>
            </div>
            -->

<!-- 댓글 -->
            @foreach($resultReply as $comment)
                <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
                    <div class="col col-4">
                        <i class="fas fa-user-circle" aria-hidden="true"></i> {{$comment['NickName']}}</div>
                    <div class="col col-8">{{$comment['RegDate']}}</div>
                </div>
                <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
                    <div class="col " style="font-size: small">{{$comment['Contents']}}</div>
                </div>

            @endforeach
            <?php
                if (isset($_SESSION['MemIdx']))
                {
                $javaAction = "commentAdd();";
                }else
                {
                $javaAction = "gotoLogin();";
                }
            ?>
            <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px" id="commentshow" >
                <div class="col">
                    <form action="/review/comment" method="post">
                        <input type="hidden" name="bidx" id="bidx" value="{{$item['BIdx']}}">
                        <input type="text" name="comment" id="comment" style="width: 75%;" autocomplete="off">
                        <button type="submit" onclick="{{$javaAction}}" id="commendBtn" class="btn" style="font-size: small; margin-bottom: 5px; border-color: #bac8f3; background-color: #fff; border-color: #bac8f3;">댓글 달기</button>

                        <br>
                    </form>
                </div>
            </div>
            <div class="row pt-3">
                <a href="/review" class="btn btn-sm btn-outline-primary">목록으로</a>
            </div>
<!-- 댓글 -->
        </div>
    </div>

</div>
@endforeach
<form method="post" id="revidefrm" name="revidefrm">
    <input type="hidden" name="revideidx" id="revideidx" value="">
    <input type="hidden" name="revideidx2" id="revideidx2" value="">
</form>
<script>
    function reviewupdateAdd()
    {
        $('#reviewUpDateModal').modal('show');
    }
    function Cancel()
    {
        $('#reviewUpDateModal').modal('hide');
    }

    function reviewDelete(BIdx){
        if (confirm('해당 리뷰를 삭제 하시겠습니까?')) {
            $("#revidefrm").attr('action', '/review/reviewDelete');
            $("#revideidx").val(BIdx);
            $("#revidefrm").submit();
        }
    }

    function reviewImgDelete(BIIdx,BIdx){
        if (confirm('해당 이미지를 삭제 하시겠습니까?')) {
            $("#revidefrm").attr('action', '/review/reviewImgDelete');
            $("#revideidx").val(BIIdx);
            $("#revideidx2").val(BIdx);
            $("#revidefrm").submit();
        }
    }

    $(function(){
        $('#reviewupdatefrmbtn').on('click',function(){
            reviewUpDate();
        });

    });
    function reviewUpDate(){
        $('#reviewUpDateModal').modal('hide');

        var formData = new FormData();
        var fileList = $('#Image').prop("files");

        formData.append("Title",$("#Title").val());
        formData.append("Count",$("#Count").val());
        formData.append("Content",$("#Content").val());
        formData.append("bidx",$("#BIdx").val());

        formData.append("Image[]", $('input[id=Image1]')[0].files[0]);
        formData.append("Image[]", $('input[id=Image2]')[0].files[0]);
        formData.append("Image[]", $('input[id=Image3]')[0].files[0]);
        formData.append("Image[]", $('input[id=Image4]')[0].files[0]);


        jQuery.ajax({
            url: 'review/reviewUpDate',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
                // alert("성공");
            },
            error: function () {
                alert("실패");
            }
        });
    }

    function commentAdd() {
        $(function () {
            reviewComment();
        });
    }
    function reviewComment() {
        var formData = new FormData();
        formData.append("comment", $(":text").val());
        formData.append("bidx", $("#bidx").val());

        jQuery.ajax({
            url: 'review/comment',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
                // alert("성공");
            },
            error: function () {
                alert("실패");
            }
        });
    }
    function gotoLogin()
    {
        document.location.href="/login?ret=review";
    }
    function setThumnail(event){
        for(let i=0; i<event.target.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var img = document.createElement("img");
                img.setAttribute("src", event.target.result);
                document.querySelector("div#Image_container").appendChild(img);
                $(function () {
                    $(img).css({
                        "width": "100px",
                        "height": "100px"
                    });
                });
            };
            reader.readAsDataURL(event.target.files[i]);
        }
    }

</script>
@foreach($result as $item)
<div class="modal" id="reviewUpDateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">리뷰 수정</h5>
            </div>
            <div class="modal-body">
                <form name="reviewUpDatefrm" id="reviewUpDatefrm" enctype="multipart/form-data" method="post" action="/review/reviewUpDate">
                    <input type="hidden" value="{{$item['BIdx']}}" id="BIdx" name="bidx">
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px;padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">이름</label>
                        <div class="col-sm-9">
                            <input type="text" name="NickName" id="NickName" value="{{$_SESSION['NickName']}}" class="form-control form-control-sm" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">제목</label>
                        <div class="col-sm-9">
                            <input type="text" name="Title" id="Title" class="form-control form-control-sm" value="{{$item['title']}}" autocomplete="off">
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
                            <textarea class="form-control form-control-sm" id="Content" name="Content" cols="30" rows="10">{{$item['Content']}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                        <label class="col-sm-3 col-form-label">파일</label>
                        <div class="col-sm-9">
                            <?php
                                $path = $item['path'];
                                $pathSplit = explode(",",$path);
                                if(count($pathSplit) != ''){
                                    for($i=0;$i<4-count($pathSplit); $i++){
                                        echo '<input type="file" name="Image[]" id="Image'. $i .'" accept="image/png, image/jpeg" onchange="setThumnail(event);" class="form-control form-control-sm">';
                                    }
                                } else {

                                }
                            ?>
                            <div id="Image_container">
                                {{-- 업로드할 이미지 썸네일 --}}
                            </div>
                            <div id="link" class="link">
                                <div class="row pb-3">
                                    <hr class="sidebar-divider d-none d-md-block">
                                    <?php
                                    if($item['ImageName'] != NULL){
                                        $ImageName = $item['ImageName'];
                                        $path = $item['path'];
                                        $BIIdx = $item['BIIdx'];
                                        $BIdx = $item['BIdx'];
                                        $BIIdxSplit = explode(",",$BIIdx);
                                        $ImageNameSplit = explode(",",$ImageName);
                                        $pathSplit = explode(",",$path);
                                        for($i=0;$i<count($ImageNameSplit);$i++){
                                            echo '<div class="col col-4 pb-2" style="padding-top: 12px; ">
                                                    <a data-gallery  href="' . $pathSplit[$i] . '/' . $ImageNameSplit[$i] . '">
                                                        <img src="' . $pathSplit[$i] . '/' . $ImageNameSplit[$i] . '" class="img-thumbnail">
                                                    </a>
                                                    <button type="button" class="btn btn-primary" onclick="reviewImgDelete(' . $BIIdxSplit[$i] . ',' . $BIdx . ')" style="font-size: small; margin-top: 7px;">삭제</button>
                                                </div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div id="blueimp-gallery" class="blueimp-gallery" aria-label="image gallery" aria-modal="true" role="dialog">
                                    <div class="slides" aria-live="polite"></div>
                                    <h3 class="title"></h3>
                                    <a class="prev" aria-controls="blueimp-gallery" aria-label="previous slide" aria-keyshortcuts="ArrowLeft"></a>
                                    <a class="next" aria-controls="blueimp-gallery" aria-label="next slide" aria-keyshortcuts="ArrowRight"></a>
                                    <a class="close" aria-controls="blueimp-gallery" aria-label="close" aria-keyshortcuts="Escape"></a>
                                    <a class="play-pause" aria-controls="blueimp-gallery" aria-label="play slideshow" aria-keyshortcuts="Space" aria-pressed="false" role="button">삭제</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:Cancel()">취소</button>
                <button type="submit" class="btn btn-primary" id="reviewupdatefrmbtn">저장</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach
