<style>
    .magnify-modal {
        box-shadow: 0 0 6px 2px rgba(0, 0, 0, 0.3);
    }
    .magnify-header .magnify-toolbar {
        background-color: rgba(0, 0, 0, .5);
    }
    .magnify-stage {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-width: 0;
    }
    .magnify-footer .magnify-toolbar {
        background-color: rgba(0, 0, 0, .5);
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .magnify-header,
    .magnify-footer {
        pointer-events: none;
    }
    .magnify-button {
        pointer-events: auto;
    }

</style>
<div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
    <div class="col">
        <button type="submit" class="form-control" class="btn" onclick="javascript:reviewAdd()" style="font-size: small; margin-bottom: 5px">글쓰기</button>
    </div>
</div>
<div class="row bg-light">
    <div class="card-body">
        <div class="card-title">
            <div class="row">
                <div class="col"><h3>테스트</h3></div>
            </div>
            <div class="row">
                <div class="col col-6">
                    <i class="fa fa-user-astronaut" aria-hidden="true"></i>
                    &nbsp;&nbsp;하린&nbsp;&nbsp;
                </div>
                <div class="col col-6" style="text-align: right">
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                </div>
            </div>
            <div class="row">
                <div class="col">2021-02-11 13:44:58</div>
            </div>
        </div>
        <div class="card-text">
            <div class="row">
                <div class="col"><h5>ㅇㅁㅇㅁㅇ</h5></div>
            </div>
        </div>
    </div>
</div>
<div id="내용" class="bg-light">
    <div class="card-body">
        <div class="card-title">
            <div class="row">
                <div class="col"><h3>테스트</h3></div>
            </div>
            <div class="row">
                <div class="col"></div>
            </div>
            <div class="row" style="padding-top: 10px">
                <div class="col col-6">
                    <i class="fa fa-user-astronaut" aria-hidden="true"></i>
                    &nbsp;&nbsp;하린&nbsp;&nbsp;
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                    <i class="fas fa-star" style="color: #FF922B" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="card-text">
            <div class="row">
                <div class="col"><h5>ㅇㅁㅇㅁㅇ</h5></div>
            </div>
            <div class="col col-6"><div>
                    2021-02-11 13:44:58</div>
            </div>
            <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
                <div class="col col-4">
                    <i class="fas fa-user-circle" aria-hidden="true"></i> 노도시</div>
                <div class="col col-8">2020-01-01 01:00:00</div>
            </div>
            <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
                <div class="col " style="font-size: small">맛있게 드셨다니 다행입니다.</div>
            </div>
            <div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
                <div class="col"><input type="text" name="commend" id="commend" style="width: 75%;">
                    <button type="button" onclick="javascript:reviewComment()" id="commendBtn" class="btn" style="font-size: small; margin-bottom: 5px; border-color: #bac8f3; background-color: #fff; border-color: #bac8f3;">댓글 달기</button>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="scrollData">
</div>
<script>

    var page = 1;
    var pageingSize = 10;

    $('[data-magnify]').magnify({
        headToolbar: [
            'close'
        ],
        footToolbar: [
            'zoomIn',
            'zoomOut',
            'prev',
            'fullscreen',
            'next',
            'actualSize',
            'rotateRight'
        ],
        title: true,
        initMaximized: true
    });
    function reviewComment(){
        alert("댓글작성");
    }

    // $(function(){
    //     $('#reviewfrmbtn').on('click',function(){
    //         uploadFile();
    //     });
    // });
    // function uploadFile(){
    //     var formData = new FormData();
    //     var fileList = $('#Image').prop("files");
    //
    //     formData.append("Title",$(":text").val());
    //     formData.append("Count",$(":selected").val());
    //     formData.append("Content",$(":textarea").val());
    //
    //     jQuery.ajax({
    //         url: 'review/reviewWrite',
    //         // url:'.../public/pds/',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         type: 'POST',
    //         success: function () {
    //             for(i=0;i<fileList.length;i++){
    //                 formData.append("Image", fileList[i]);
    //             }
    //             alert("성공");
    //         },
    //         error:function(){
    //             alert("실패");
    //         }
    //     });
    // }

    function reviewAdd()
    {
        $('#reviewModal').modal('show');
    }
    function Cancel()
    {
        $('#reviewModal').modal('hide');
    }
    function loadData()
    {
        gfn_ajaxpost('/review/reviewload', { "page" : page , "pageingSize" : pageingSize} function (
        {

        }
    ))
    }
    function loadDate1()
    {
        $.ajax({
            url: "review/reviewload",
            type: "post",
            data : { "page" : page , "pageingSize" : pageingSize},
            dataType: 'json',
            success:function (data) {
                $.each(data,function(index,item) {
                    html = "<div class='card cardcolor1'>" +
                        '<div class="card-body">' +
                        '<div class="card-title">' +
                        '<div class="row">' +
                        '<div class="col">';
                    if(item['title'] != '')
                    {
                        html += '<h3>' + item['title'] + '</h3>';
                    } else if(item['title'] === '' || item['title'] === null){
                        html += '<h3>제목없음</h3>';
                    }
                    html += '<hr>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col">';
                    if(item['ImageName'] != null){
                        var ImageName = item['ImageName'];
                        var path = item['path'];
                        var ImageNameSplit = ImageName.split(',');
                        var pathSplit = path.split(',');
                        for(var i in ImageNameSplit) {
                            html += '<a data-magnify="gallery"  href="' + pathSplit[i] + '/' + ImageNameSplit[i] + '"><img src="' + pathSplit[i] + '/' + ImageNameSplit[i] + '" class="object-fit: fill"></a>';
                        }
                    } else {

                    }

                    html +=
                        '</div>' +
                        '</div>' +
                        '<div class="row" style="padding-top: 10px">' +
                        '<div class="col col-6" >' +
                        '<i class="fa fa-user-astronaut"></i>&nbsp;&nbsp;' + item['NickName'] + '&nbsp;&nbsp;';
                    for (i=0; i<item['Count'];i++)
                    {
                        html += '<i class="fas fa-star" style="color: #FF922B"></i>';
                    }
                    html += '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-text" >' +
                        '<div class="row">' +
                        '<div class="col"><h5>' + item['Content'] + '</h5></div>' +
                        '</div>' +
                        '<div class="col col-6">' +
                        '<div>' + item['RegDate'] + '</div>' +
                        '</div>' +
                        // 댓글창
                        '<div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">' +
                        '<div class="col col-4"><i class="fas fa-user-circle"></i> 노도시</div>' +
                        '<div class="col col-8">2020-01-01 01:00:00</div>' +
                        '</div>' +
                        '<div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">' +
                        '<div class="col " style="font-size: small">맛있게 드셨다니 다행입니다.</div>' +
                        '</div>' +
                        '<div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">' +
                        '<div class="col">' +
                        '<input type="text" name="commend" id="commend" style="width: 75%;">' +
                        // class="form-control"
                        '<button type="button" onclick="javascript:reviewComment()" id="commendBtn" class="btn" style="font-size: small; margin-bottom: 5px; border-color: #bac8f3; background-color: #fff; border-color: #bac8f3;">댓글 달기</button>' +
                        // class="form-control" class="btn"
                        '<br>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $("#main").height($(document).height());
                    $("#scrollData").append(html);
                })
                page++;

            },
            error:function(){
                alert("값이 없습니다.");
            }
        });
    }
    $( function() {
        loadDate();

    } );

    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            loadDate();
        }
    });
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
                            <input type="file" name="Image[]" multiple="multiple" id="Image" accept="image/png, image/jpeg" capture="gallery" onchange="setThumnail(event);">
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
