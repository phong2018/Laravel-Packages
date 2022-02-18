<script>  
    function separatorNum(numb) {
        var str = numb.toString().split(".");
        str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return str.join(".");
    }

    // escapeRegExp
    function escapeRegExp(string){
        return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }
        
    /* Define functin to find and replace specified term with replacement string */
    function strReplaceAll(str, term, replacement) {
        return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
    } 

    @if(isset($idInputNumber))
        $(document).ready(function(){
            $('#{{$idInputNumber}}').on('keyup',function(){
                let tempVal=$('#{{$idInputNumber}}').val();
                tempVal=strReplaceAll(tempVal,",","");
                
                if(isNaN(tempVal))
                    $('#{{$idInputNumber}}').val(separatorNum('10,000'));
                else{
                    
                    @if(isset($stepNum) && $stepNum>0)
                        tempVal=parseInt(parseInt(tempVal)/{{$stepNum}}) * {{$stepNum}};
                        if(tempVal<{{$stepNum}}) tempVal={{$stepNum}};
                    @endif

                    $('#{{$idInputNumber}}').val(separatorNum(tempVal));
                }
            });
        });
    @endif
</script>