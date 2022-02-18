 
<script>
    function checkAllCheckbox(valueOfCheckbox,nameOfCheckbox){  
        var allCheckboxs = document.getElementsByName(nameOfCheckbox); 
        for (var i = 0; i < allCheckboxs.length; i++) {
            allCheckboxs[i].checked = valueOfCheckbox;
        } 
    } 
</script>