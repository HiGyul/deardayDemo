<!-- container-fluid : s -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="page-header">
    <h1>운동 등록</span></h1>
  </div>

  <!-- body : s -->
  <div class="bg_wh mt20">
    <div class="table-responsive">
      <section>
        <table class="table table-bordered td_left">
          <colgroup>
            <col style="width:15%">
            <col style="width:35%">
            <col style="width:15%">
            <col style="width:35%">
          </colgroup>
          <tbody>
            <tr>
              <th><span class="text-danger">* </span>운동명</th>
              <td colspan="3">
                <input type="text" name="title" id="title" value="" class="form-control">
              </td>
            </tr>
            <tr>
              <th style="height:200px;">
                <span class="text-danger">* </span>
                대표 이미지<br />(000x000)<br />
                <p><input type="button" class="btn btn-xs btn-default" value="등록" onclick="file_upload_click('img','image','1','150');" style="margin-bottom:10px"></p>
              </th>
              <td colspan="3">
                <div class="view_img mg_btm_20">
                  <ul class="img_hz" id="img"></ul>
                </div>
              </td>
            </tr>
            <tr>
              <th>영상 url</th>
              <td colspan="3">
                <input type="text" name="url_link" id="url_link" value="" class="form-control">
              </td>
            </tr>
            <tr>
              <th>운동기구</th>
              <td>
                <input type="text" name="sports_equipment" id="sports_equipment" value="" class="form-control">
              </td>
              <th><span class="text-danger">* </span>운동 시간</th>
              <td>
              <select name="min" id="min" class="form-control " style="width: 40%;">
                  <option value="">분</option>
                  <?for($i=0;$i<11;$i++){?>
                    <option value="<?=$i?>"> <?=$i?>분</option>
                  <?}?>
                </select>&nbsp;&nbsp;
              <select name="sec" id="sec" class="form-control " style="width: 40%;">
                  <option value="00">0초</option>
                  <option value="10">10초</option>
                  <option value="20">20초</option>
                  <option value="30">30초</option>
                  <option value="40">40초</option>
                  <option value="50">50초</option>
                </select>
              </td>
            </tr>
            <tr>
              <th><span class="text-danger">* </span>내용</th>
              <td class="td_left" colspan="3">
                <div class="editor_area btn-editor" style="width:100%">                
                  <textarea class="input-block-level" id = "contents" name="contents"></textarea>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </section>

      <div class="row">
        <div class="col-lg-12 text-right">
          <a href="javascript:void(0)"  onClick="default_list()" class="btn btn-gray">목록</a>
          <a href="javascript:void(0)"  onClick="default_reg()" class="btn btn-success">등록</a>
        </div>
      </div>
    </div>
  </div>
  <!-- body : e -->
</div>
<!-- container-fluid : e -->

<script>
  // post관리 목록
  function default_list(){
    history.back(<?=$history_data?>);
  }

  // 써머노트 셋팅
  var summernote_id = 'contents';

  // 이미지 업로드시 사용
  $(function() {
  $('#'+summernote_id).summernote({
    height:443,
    fontNames: [ 'NotoSansKR-Regular'],
    lang: 'ko-KR',
    dialogsInBody: false,
    callbacks: {
          onImageUpload: function(files, editor, welEditable) {
            for (var i = files.length - 1; i >= 0; i--) {
              sendFile(files[i], editor, welEditable);
            }
          }
        }
  });
  });

  //에디터 데이터 contents name에 전송
  var postForm = function() {
   var content = $('textarea[name="contents"]').html($('#contents').code());
  }

  //에디터 이미지 등록
  function sendFile(file,editor, welEditable) {
      var form_data = new FormData();
      form_data.append('file', file);
      form_data.append('id', 'id');
      form_data.append('device', 'image');
      $.ajax({
        data: form_data,
        dataType:'json',
        type: "POST",
        url: '/common/upload_file_json',
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function(result) {
          $('textarea[name="contents"]').summernote('insertImage',  result.path2);
        }
      });
  }

  // post관리 등록하기
  function default_reg(){

    var form_data = {
      "title" : $("#title").val(),
      "url_link" : $("#url_link").val(),
      "sports_equipment" : $("#sports_equipment").val(),
      "min" : $("select[name='min']").val(),
      "sec" : $("select[name='sec']").val(),
      "img_path" : $("input[name='img']:checked").val(),
      "contents" : $("#contents").val()
    };

    console.log(form_data);

    $.ajax({
      url      : "/<?=mapping('exercise')?>/exercise_reg_in",
      type     : 'POST',
      dataType : 'json',
      async    : true,
      data     : form_data,
      success: function(result){
        if(result.code == '-1'){
          alert(result.code_msg);
          $("#"+result.focus_id).focus();
          return;
        }
        // 0:실패 1:성공
        if(result.code == 0) {
          alert("등록 실패!");
        } else {
          alert("등록 되었습니다.");
          location.href ='/<?=mapping('exercise')?>/exercise_list';
        }
      }
    });
  }

</script>
