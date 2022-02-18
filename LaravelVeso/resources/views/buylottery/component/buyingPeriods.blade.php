<h5>Kỳ mua</h5>
<select name="buyingPeriods" id="selectbuyingPeriods">
    @foreach($buyingPeriods as $key=>$value)
    <option value="{{$key}}">Ngày #{{$value}}</option>
    @endforeach
</select>