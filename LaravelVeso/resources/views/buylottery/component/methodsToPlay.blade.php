<h5>Cách chơi</h5>
<select name="methodsToPlay" id="selectMethodsToPlay">
    @foreach($methodsToPlay as $key=>$value)
    <option value="{{$key}}">{{$value['name']}}</option>
    @endforeach
</select>

<script>
// 
function getBallForEveryBlock(numberBallSelected){
    for(var blockIndex=1;blockIndex<=6;blockIndex++){
        var blockId='blockNumber'+blockIndex;
        var blockStr='';
        for(var ball=1;ball<=numberBallSelected;ball++){
            blockStr+="<span id='"+blockId+"_"+ball+"' class='ball'> </span>"
        }
        $("#"+blockId).html(blockStr);
    } 
}

$('#selectMethodsToPlay').change(function() {
    var selectMethodsToPlay=$(this).val();
    var numberBallSelected=methodsToPlay[selectMethodsToPlay]['numberBallSelected']; 
    getBallForEveryBlock(numberBallSelected);
});
</script>
 