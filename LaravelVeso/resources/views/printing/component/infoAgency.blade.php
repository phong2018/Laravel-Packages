<div style="overflow:hidden;font-weight:bold">
@if(isset($data['agencyInfo']['agencyName']))
  {{$data['agencyInfo']['agencyName']}}
@else
  Kính Chúc Quý Khách May Mắn!
@endif
<br>
@if(isset($data['agencyInfo']['agencyPhone']))
  ĐT: {{$data['agencyInfo']['agencyPhone']}}. <br> ĐC: {{$data['agencyInfo']['agencyAddress']}}
@else
  ĐT: 0938587638.<br>ĐC: 174 Thích Quảng Đức, LK, ĐN
@endif 
</div>