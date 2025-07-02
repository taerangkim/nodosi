
<link rel="stylesheet" href="/css/jquery.fileupload.css">
<link rel="stylesheet" href="/css/jquery.fileupload-ui.css">
<style>
    .img-thumbnail1{
        background-color: #fff;max-width: 100%;  height: auto;
    }
</style>
<?php
if (isset($_SESSION['MemIdx']))
{
    $javaAction = "reviewAdd();";
}else
{
    $javaAction = "gotoLogin();";
}
?>
<style>
    #overlay{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 460px;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .is-hide{
        display:none;
    }
</style>
<div class="row" style="background-color:#e0e0e0;padding-top: 10px;padding-bottom: 5px">
    <div class="col">
        <button type="submit" class="form-control" class="btn" onclick="{{$javaAction}}" style="font-size: small; margin-bottom: 5px">글쓰기</button>
    </div>
</div>
<div id="overlay" class="row">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<div id="reviewMeta" style="display: none">
    <div class="col img-over bg-dark text-light" style="height: 138px">
        <a href="/review/reviewdetail?bidx=[url]" class="text-light" >[content]</a>
        <span class="rating">★[count]</span>
        <div class="afterNick">[nick]</div>
    </div>
</div>

<div class="row bg-light" >
    <div class="col-xl-12 col-lg-7">
        <div class="row row-cols-1 row-cols-sm-2 g-3"  id="reviewBody">
        </div>
    </div>
</div>



<div class="modal" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-toggle="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalTitle">리뷰 글쓰기</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="/review/reviewWrite" id="reviewFrm" name="reviewFrm">
                    <input type="hidden" name="reviewlistjson" id="reviewlistjson" value="">
                    <div class="row pb-2">
                        <div class="col">
                            <input type="text" name="Title" id="Title" class="form-control form-control-sm" placeholder="제목을 입력하세요.">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col">
                            <select class="form-control form-control-sm" id="Count" name="Count">
                                <option value="">평점 선택</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col">
                            <textarea class="form-control form-control-sm" id="Content" name="Content" cols="30" rows="5" placeholder="내용을 입력하세요"></textarea>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col">
                            <button type="button" class="btn btn-danger" id="btnImgUpload" onclick="fileUpload();">이미지 선택</button>
                        </div>
                    </div>
                    <div class="row" id="Image_container"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:Cancel()">취소</button>
                <button type="button" class="btn btn-primary" id="reviewfrmbtn" onclick="frmSubmit()">저장</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="fileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light" id="menuModalTitle">파일 업로드</h5>
            </div>
            <div class="modal-body">
                <form id="fileupload"  action="https://jquery-file-upload.appspot.com/"  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="uploadpath" id="uploadpath" value="/94">
                    <div class="row fileupload-buttonbar">
                        <div class="col">
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>파일 추가</span>
                                <input type="file" name="files[]" multiple />
                            </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>업로드 시작</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>업로드 취소</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>선택 파일 삭제</span>
                            </button>
                            <input type="checkbox" class="toggle" />
                            <span class="fileupload-process"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col fileupload-progress fade">
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width: 0%;"></div>
                            </div>
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <table role="presentation" class="table table-striped">
                        <tbody class="files"></tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="fileClose();">취소</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="fileComplete();">완료</button>
            </div>
        </div>
    </div>
</div>
<script id="template-upload" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
      <tr class="template-upload fade{%=o.options.loadImageFileTypes.test(file.type)?' image in':''%}">
          <td>
              <span class="preview"></span>
          </td>
          <td>
              <p class="name">{%=file.name%}</p>
              <strong class="error text-danger"></strong>
          </td>
          <td>
              <p class="size">Processing...</p>
              <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
          </td>
          <td>
              {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
                <button class="btn btn-success edit btn-sm" data-index="{%=i%}" disabled>
                    <i class="glyphicon glyphicon-edit "></i>
                    Edit
                </button>
              {% } %}
              {% if (!i && !o.options.autoUpload) { %}
                  <button class="btn btn-primary start btn-sm" disabled>
                      <i class="glyphicon glyphicon-upload"></i>
                      업로드
                  </button>
              {% } %}
              {% if (!i) { %}
                  <button class="btn btn-warning cancel btn-sm">
                      <i class="glyphicon glyphicon-ban-circle"></i>
                      취소
                  </button>
              {% } %}
          </td>
      </tr>
  {% } %}
</script>
<script id="template-download" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
      <tr class="template-download fade{%=file.thumbnailUrl?' image':''%}">
          <td>
              <span class="preview">
                  {% if (file.thumbnailUrl) { %}
                      <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                  {% } %}
              </span>
          </td>
          <td>
              <p class="name">
                  {% if (file.url) { %}
                      <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                  {% } else { %}
                      <span>{%=file.name%}</span>
                  {% } %}
              </p>
              {% if (file.error) { %}
                  <div><span class="label label-danger">Error</span> {%=file.error%}</div>
              {% } %}
          </td>
          <td>
              <span class="size">{%=o.formatFileSize(file.size)%}</span>
          </td>
          <td>
              {% if (file.deleteUrl) { %}
                  <button class="btn btn-danger btn-sm delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                      <i class="glyphicon glyphicon-trash"></i>
                      삭제
                  </button>
                  <input type="checkbox" name="delete" value="1" class="toggle">
              {% } else { %}
                  <button class="btn btn-warning cancel btn-sm">
                      <i class="glyphicon glyphicon-ban-circle"></i>
                      Cancel
                  </button>
              {% } %}
          </td>
      </tr>
  {% } %}
</script>

<script src="/js/upload/jquery.ui.widget.js"></script>
<script src="/js/upload/tmpl.min.js"></script>
<script src="/js/upload/load-image.all.min.js"></script>
<script src="/js/upload/canvas-to-blob.min.js"></script>
<script src="/js/upload/jquery.blueimp-gallery.min.js"></script>
<script src="/js/upload/jquery.fileupload.js?c=<?=date('Ymdmsi')?>"></script>
<script src="/js/upload/jquery.fileupload-process.js"></script>
<script src="/js/upload/jquery.fileupload-image.js"></script>
<script src="/js/upload/jquery.fileupload-validate.js"></script>
<script src="/js/upload/jquery.fileupload-ui.js?c=<?=date('Ymdmsi')?>"></script>
<script>
    var uploadFile = [];
    var page = 1;
    var pageingSize = 21;

    function frmSubmit()
    {
        if ($("#Title").val() == '')
        {
            alert('제목을 입력하여 주시기 바랍니다.')
            return false;
        }
        if ($("#Content").val() == '')
        {
            alert('내용을 입력하여 주시기 바랍니다.');
            return false;
        }
        if($("#Count").val()=='')
        {
            alert('평점을 선택하여 주시기 바랍니다.');
            return false;
        }
        var  obj = new Object();
        obj.value = uploadFile;
        var values = JSON.stringify(obj);
        $("#reviewlistjson").val(values);
        $("#reviewFrm").submit();
    }
    function fileUpload()
    {
        $("#fileModal").modal('show');
    }
    function fileClose()
    {
        $("#fileModal").modal('hide');
    }

    // 이미지 썸네일
    function fileComplete()
    {
        $("#Image_container").empty();
        $.each(uploadFile, function (index, item) {
            console.log(item.url);
            html = '<div class="col col-3 pb-2"><img src="' + item.thumbnailUrl + '" class="img-thumbnail"></div>';
            $("#Image_container").append(html)
        });
        $("#fileModal").modal('hide');
    }

    $('#fileupload').fileupload({
        url: '/review/file',
        done: function (e, data) {
            console.log(data.result.files[0]['ImgIdx']);
            uploadFile.push(data.result.files[0]);
        },
    });


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
        gfn_ajaxpost(
            '/review/reviewImgLoad',
            {"page": page, "pageingSize": pageingSize},
            function (data) {
                console.log(data);
                html = $("#reviewMeta").html();
                $.each(data, function (index, item) {
                    appendHtml = html
                        .replace('[url]', item['BIdx'])
                        .replace('[count]', item['Count'])
                        .replace('[nick]', item['NickName'])

                    if (item['ImageName'] == '') {
                        appendHtml = appendHtml.replace('[content]', item['title']);
                    } else {
                        imghtml = '<img src="' + item['path'] + '/' + item['ImageName'] + '" class="w-100 img-thumbnail1 zoom" style="height: 138px">';
                        appendHtml = appendHtml.replace('[content]', imghtml);
                        //이미지 처리
                    }
                    $("#reviewBody").append(appendHtml);
                });
                page++;
            });
    }
    $( function() {
        loadData();
    } );

    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            loadData();
        }
    });
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