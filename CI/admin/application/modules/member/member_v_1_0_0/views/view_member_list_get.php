<div class="row table_title">
	<div class="col-lg-6"> &nbsp;<i class="fa fa-check" aria-hidden="true"></i> &nbsp;검색결과 : <strong><?=$result_list_count?></strong> 명</div>
	<div class="col-lg-6 text-right" style="margin-bottom:10px">
		</div>

</div>

<table class="table table-bordered">
	<thead>
    <tr>		
		<th width="50">No</th>
		<th width="100">아이디(이메일)</th>
		<th width="110">이름</th>
		<th width="80">전화번호</th>
		<th width="100">가입일</th>
		<th width="100">탈퇴일</th>
		<th width="80">회원상태</th>
		</tr>
	</thead>
	<tbody>
    <?php
			if(!empty($result_list)){
    		foreach ($result_list as $row){
    ?>
					<tr>
						<td><?=$no--?></td>
						<td class="td_left"><a href="/<?=mapping('member')?>/member_detail?member_idx=<?=$row->member_idx?>&history_data=<?=$history_data?>"><?=$row->member_id?></a></td>
						<td><?=$row->member_name?></td>
						<td><?=$this->global_function->format_phone($row->member_phone);?></td>
						<td><?=$row->ins_date?></td>
						<td>
							<?=($row->member_state ==3)?$row->member_leave_date:'-'?>
						</td>
						<td>
							<?php if($row->member_state == '0'){ echo "이용중"; }
							else if($row->member_state == '1'){ echo "이용정지"; }
							else if($row->member_state == '3'){echo "탈퇴";} 
							?>
						</td>
					</tr>
		<?php
		    }
			}else{
		?>
		<tr>
      <td colspan="15">
        <?=no_contents('0')?>
      </td>
    </tr>
		<?php
			}
	  ?>
	</tbody>
</table>

<?=$paging?>

